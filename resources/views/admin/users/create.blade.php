<x-app-layout>
    <div class="py-12">
        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Erreur!</strong>
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Succès!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h2 class="text-2xl font-semibold mb-6">
                        {{ isset($user->id) ? 'Modifier' : 'Créer' }} un utilisateur
                    </h2>

                    <!-- Formulaire -->
                    <form action="{{ isset($user->id) ? route('admin.users.update', $user) : route('admin.users.store') }}"
                          method="POST"
                          class="space-y-6">
                        @csrf
                        @if(isset($user->id))
                            @method('PUT')
                        @endif

                        <!-- Informations de base -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="first_name" class="block text-sm font-medium text-gray-700">Prénom</label>
                                <input type="text"
                                       name="first_name"
                                       id="first_name"
                                       value="{{ old('first_name', $user->first_name) }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('first_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="last_name" class="block text-sm font-medium text-gray-700">Nom</label>
                                <input type="text"
                                       name="last_name"
                                       id="last_name"
                                       value="{{ old('last_name', $user->last_name) }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('last_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                <input type="email"
                                       name="email"
                                       id="email"
                                       value="{{ old('email', $user->email) }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            @if(!isset($user->id))
                                <div>
                                    <label for="password" class="block text-sm font-medium text-gray-700">Mot de passe</label>
                                    <input type="password"
                                           name="password"
                                           id="password"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('password')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            @endif

                            <div>
                                <label for="phone_number" class="block text-sm font-medium text-gray-700">Téléphone</label>
                                <input type="text"
                                       name="phone_number"
                                       id="phone_number"
                                       value="{{ old('phone_number', $user->phone_number) }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('phone_number')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="address" class="block text-sm font-medium text-gray-700">Adresse</label>
                                <textarea name="address"
                                          id="address"
                                          rows="3"
                                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('address', $user->address) }}</textarea>
                                @error('address')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Sélection du rôle -->
                        <div class="mt-6">
                            <label for="role" class="block text-sm font-medium text-gray-700">Rôle</label>
                            <select name="role"
                                    id="role"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    onchange="toggleRoleFields(this.value)">
                                <option value="">Sélectionnez un rôle</option>
                                <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Administrateur</option>
                                <option value="teacher" {{ old('role', $user->role) === 'teacher' ? 'selected' : '' }}>Enseignant</option>
                                <option value="student" {{ old('role', $user->role) === 'student' ? 'selected' : '' }}>Étudiant</option>
                                <option value="parent" {{ old('role', $user->role) === 'parent' ? 'selected' : '' }}>Parent</option>
                            </select>
                            @error('role')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Champs spécifiques aux enseignants -->
                        <div id="teacher-fields" class="hidden space-y-6">
                            <div>
                                <label for="specialty" class="block text-sm font-medium text-gray-700">Spécialité</label>
                                <input type="text"
                                       name="specialty"
                                       id="specialty"
                                       value="{{ old('specialty', $user->teacher->specialty ?? '') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('specialty')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="hire_date" class="block text-sm font-medium text-gray-700">Date d'embauche</label>
                                <input type="date"
                                       name="hire_date"
                                       id="hire_date"
                                       value="{{ old('hire_date', $user->teacher->hire_date ?? '') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('hire_date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Champs spécifiques aux étudiants -->
                        <div id="student-fields" class="hidden space-y-6">
                            <div>
                                <label for="registration_number" class="block text-sm font-medium text-gray-700">Numéro d'inscription</label>
                                <input type="text"
                                       name="registration_number"
                                       id="registration_number"
                                       value="{{ old('registration_number', $user->student->registration_number ?? '') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('registration_number')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="birth_date" class="block text-sm font-medium text-gray-700">Date de naissance</label>
                                <input type="date"
                                       name="birth_date"
                                       id="birth_date"
                                       value="{{ old('birth_date', $user->student->birth_date ?? '') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('birth_date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="gender" class="block text-sm font-medium text-gray-700">Genre</label>
                                <select name="gender"
                                        id="gender"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Sélectionnez un genre</option>
                                    <option value="M" {{ old('gender', $user->student->gender ?? '') === 'M' ? 'selected' : '' }}>Masculin</option>
                                    <option value="F" {{ old('gender', $user->student->gender ?? '') === 'F' ? 'selected' : '' }}>Féminin</option>
                                </select>
                                @error('gender')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="classroom_id" class="block text-sm font-medium text-gray-700">Classe</label>
                                <select name="classroom_id"
                                        id="classroom_id"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Sélectionnez une classe</option>
                                    @foreach($classrooms as $classroom)
                                        <option value="{{ $classroom->id }}"
                                            {{ old('classroom_id', $user->student->classroom_id ?? '') == $classroom->id ? 'selected' : '' }}>
                                            {{ $classroom->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('classroom_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Champs spécifiques aux parents -->
                        <div id="parent-fields" class="hidden space-y-6">
                            <div>
                                <label for="occupation" class="block text-sm font-medium text-gray-700">Profession</label>
                                <input type="text"
                                       name="occupation"
                                       id="occupation"
                                       value="{{ old('occupation', $user->parent->occupation ?? '') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('occupation')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="relationship_type" class="block text-sm font-medium text-gray-700">Type de relation</label>
                                <select name="relationship_type"
                                        id="relationship_type"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Sélectionnez un type</option>
                                    <option value="father" {{ old('relationship_type', $user->parent->relationship_type ?? '') === 'father' ? 'selected' : '' }}>Père</option>
                                    <option value="mother" {{ old('relationship_type', $user->parent->relationship_type ?? '') === 'mother' ? 'selected' : '' }}>Mère</option>
                                    <option value="guardian" {{ old('relationship_type', $user->parent->relationship_type ?? '') === 'guardian' ? 'selected' : '' }}>Tuteur</option>
                                </select>
                                @error('relationship_type')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="emergency_contact" class="block text-sm font-medium text-gray-700">Contact d'urgence</label>
                                <input type="text"
                                       name="emergency_contact"
                                       id="emergency_contact"
                                       value="{{ old('emergency_contact', $user->parent->emergency_contact ?? '') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('emergency_contact')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Statut -->
                        <div class="mt-6">
                            <label for="status" class="block text-sm font-medium text-gray-700">Statut</label>
                            <select name="status"
                                    id="status"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="active" {{ old('status', $user->status) === 'active' ? 'selected' : '' }}>Actif</option>
                                <option value="inactive" {{ old('status', $user->status) === 'inactive' ? 'selected' : '' }}>Inactif</option>
                            </select>
                            @error('status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Boutons -->
                        <div class="mt-6 flex justify-end space-x-3">
                            <a href="{{ route('admin.users.index') }}"
                               class="inline-flex justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                Annuler
                            </a>
                            <button type="submit"
                                    class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                {{ isset($user->id) ? 'Modifier' : 'Créer' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function toggleRoleFields(role) {
                // Cacher tous les champs spécifiques
                document.getElementById('teacher-fields').classList.add('hidden');
                document.getElementById('student-fields').classList.add('hidden');
                document.getElementById('parent-fields').classList.add('hidden');

                // Afficher les champs selon le rôle sélectionné
                if (role === 'teacher') {
                    document.getElementById('teacher-fields').classList.remove('hidden');
                } else if (role === 'student') {
                    document.getElementById('student-fields').classList.remove('hidden');
                } else if (role === 'parent') {
                    document.getElementById('parent-fields').classList.remove('hidden');
                }
            }

            // Exécuter au chargement de la page pour afficher les bons champs si un rôle est déjà sélectionné
            document.addEventListener('DOMContentLoaded', function() {
                const roleSelect = document.getElementById('role');
                if (roleSelect) {
                    toggleRoleFields(roleSelect.value);
                }
            });
        </script>
    @endpush
</x-app-layout>
