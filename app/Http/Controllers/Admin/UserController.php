<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\Classroom;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        Gate::authorize('viewAny', User::class);

        // Appliquer les filtres
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'like', "%$search%")
                    ->orWhere('last_name', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%");
            });
        }

        // Paginer les résultats
        $users = $query->latest()->paginate(10);


        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        Gate::authorize('view', $user);
        return view('admin.users.show', compact('user'));
    }

    protected function showFormView(User $user = new User())
    {
        $classrooms = Classroom::all();
        return view('admin.users.create', compact('user', 'classrooms'));
    }

    public function create()
    {
        Gate::authorize('create', User::class);
        return $this->showFormView();
    }

    public function store(UserRequest $request)
    {
        return $this->save($request->validated());
    }

    public function edit(User $user)
    {
        Gate::authorize('update', $user);
        return $this->showFormView($user);
    }

    public function update(UserRequest $request, User $user)
    {
        return $this->save($request->validated(), $user);
    }

    protected function save(array $data, User $user = null): RedirectResponse
    {
        try {
            DB::beginTransaction();



            // Préparation des données utilisateur
            $userData = [
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'email' => $data['email'],
                'phone_number' => $data['phone_number'] ?? null,
                'address' => $data['address'] ?? null,
                'role' => $data['role'],
                'status' => $data['status']
            ];

            // Gestion du mot de passe
            if (isset($data['password'])) {
                $userData['password'] = Hash::make($data['password']);
            }

            // Création ou mise à jour de l'utilisateur
            if (!$user) {
                $user = User::create($userData);
                Log::info('Nouvel utilisateur créé:', ['id' => $user->id]);
            } else {
                $user->update($userData);
                Log::info('Utilisateur mis à jour:', ['id' => $user->id]);
            }

            //Gestion des profils spécifiques
            switch ($data['role']) {
                case 'teacher':
                    $this->handleTeacherProfile($user, $data);
                    break;
                case 'student':
                    $this->handleStudentProfile($user, $data);
                    break;
                case 'parent':
                    $this->handleParentProfile($user, $data);
                    break;
                default:
                    break;

            }

            DB::commit();

            return redirect()
                ->route('admin.users.index')
                ->with('success', 'Utilisateur ' . ($user->wasRecentlyCreated ? 'créé' : 'modifié') . ' avec succès.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erreur lors de la création/modification de l\'utilisateur:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()
                ->withInput()
                ->with('error', 'Une erreur est survenue: ' . $e->getMessage());
        }
    }

    protected function handleTeacherProfile(User $user, array $data): void
    {
        $teacherData = [
            'specialty' => $data['specialty'],
            'hire_date' => $data['hire_date'],
            'user_id' => $user->id
        ];

        try {
            if ($user->teacher) {
                $user->teacher->update($teacherData);
                Log::info('Profil enseignant mis à jour', ['teacher_id' => $user->teacher->id]);
            } else {
                Teacher::create($teacherData);
                Log::info('Nouveau profil enseignant créé pour l\'utilisateur', ['user_id' => $user->id]);
            }
        } catch (Exception $e) {
            Log::error('Erreur lors de la gestion du profil enseignant:', [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    protected function handleStudentProfile(User $user, array $data): void
    {
        $studentData = [
            'registration_number' => $data['registration_number'],
            'birth_date' => $data['birth_date'],
            'gender' => $data['gender'],
            'classroom_id' => $data['classroom_id'],
            'user_id' => $user->id
        ];

        try {
            if ($user->student) {
                $user->student->update($studentData);
                Log::info('Profil étudiant mis à jour', ['student_id' => $user->student->id]);
            } else {
                Student::create($studentData);
                Log::info('Nouveau profil étudiant créé pour l\'utilisateur', ['user_id' => $user->id]);
            }
        } catch (Exception $e) {
            Log::error('Erreur lors de la gestion du profil étudiant:', [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    protected function handleParentProfile(User $user, array $data): void
    {
        $parentData = [
            'occupation' => $data['occupation'] ?? null,
            'relationship_type' => $data['relationship_type'],
            'emergency_contact' => $data['emergency_contact'],
            'user_id' => $user->id
        ];

        try {
            if ($user->parent) {
                $user->parent->update($parentData);
                Log::info('Profil parent mis à jour', ['parent_id' => $user->parent->id]);
            } else {
                Parent::create($parentData);
                Log::info('Nouveau profil parent créé pour l\'utilisateur', ['user_id' => $user->id]);
            }
        } catch (Exception $e) {
            Log::error('Erreur lors de la gestion du profil parent:', [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }
}
