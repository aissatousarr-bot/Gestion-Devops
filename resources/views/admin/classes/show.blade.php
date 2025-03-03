<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- En-tête -->
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-semibold text-gray-800">
                    Détails de la classe : {{ $class->name }}
                </h2>
                <div class="flex space-x-3">
                    <a href="{{ route('admin.classes.edit', $class) }}"
                       class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
                        Modifier
                    </a>
                    <a href="{{ route('admin.classes.index') }}"
                       class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700">
                        Retour
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Informations générales -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4">Informations générales</h3>
                        <div class="space-y-4">
                            <div class="grid grid-cols-2 gap-4">
                                <div class="text-sm font-medium text-gray-500">Section</div>
                                <div class="text-sm text-gray-900">{{ $class->section }}</div>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="text-sm font-medium text-gray-500">Niveau</div>
                                <div class="text-sm text-gray-900">{{ $class->level }}</div>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="text-sm font-medium text-gray-500">Année académique</div>
                                <div class="text-sm text-gray-900">{{ $class->academic_year }}</div>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="text-sm font-medium text-gray-500">Capacité</div>
                                <div class="text-sm text-gray-900">
                                    {{ $class->current_students_count }}/{{ $class->capacity }}
                                    <span class="text-sm text-gray-500">
                                       ({{ $class->available_seats }} places disponibles)
                                   </span>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="text-sm font-medium text-gray-500">Statut</div>
                                <div>
                                   <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                       {{ $class->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                       {{ $class->status === 'active' ? 'Active' : 'Inactive' }}
                                   </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Enseignants -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4">Enseignants assignés</h3>
                        <div class="divide-y divide-gray-200">
                            @forelse($class->teachers as $teacher)
                                <div class="py-3 flex justify-between items-center">
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ $teacher->full_name }}</p>
                                        <p class="text-sm text-gray-500">{{ $teacher->specialty }}</p>
                                    </div>
                                    <a href="{{ route('admin.teachers.show', $teacher) }}"
                                       class="text-indigo-600 hover:text-indigo-900 text-sm">
                                        Voir le profil
                                    </a>
                                </div>
                            @empty
                                <p class="text-sm text-gray-500">Aucun enseignant assigné</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Liste des étudiants -->
            <div class="mt-6 bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">Étudiants inscrits</h3>
                        <a href="{{ route('admin.users.create', ['classroom_id' => $class->id]) }}"
                           class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm hover:bg-indigo-700">
                            + Ajouter un étudiant
                        </a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Nom complet
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Numéro d'inscription
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Genre
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Statut
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($class->students as $student)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $student->full_name }}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $student->registration_number }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $student->gender === 'M' ? 'Masculin' : 'Féminin' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                           <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                               {{ $student->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                               {{ ucfirst($student->status) }}
                                           </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('admin.users.show', $student) }}" class="text-blue-600 hover:text-blue-900 mr-3">
                                            Voir
                                        </a>
                                        <a href="{{ route('admin.users.edit', $student) }}" class="text-indigo-600 hover:text-indigo-900">
                                            Modifier
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                        Aucun étudiant inscrit dans cette classe
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
