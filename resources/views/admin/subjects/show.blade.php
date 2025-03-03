<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- En-tête -->
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-semibold text-gray-800">
                    Détails de la matière : {{ $subject->name }}
                </h2>
                <div class="flex space-x-3">
                    <a href="{{ route('admin.subjects.edit', $subject) }}"
                       class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
                        Modifier
                    </a>
                    <a href="{{ route('admin.subjects.index') }}"
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
                                <div class="text-sm font-medium text-gray-500">Code</div>
                                <div class="text-sm text-gray-900">{{ $subject->code }}</div>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="text-sm font-medium text-gray-500">Coefficient</div>
                                <div class="text-sm text-gray-900">{{ $subject->coefficient }}</div>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="text-sm font-medium text-gray-500">Heures par semaine</div>
                                <div class="text-sm text-gray-900">{{ $subject->hours_per_week }}</div>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="text-sm font-medium text-gray-500">Statut</div>
                                <div>
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                        {{ $subject->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $subject->status === 'active' ? 'Active' : 'Inactive' }}
                                    </span>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="text-sm font-medium text-gray-500">Description</div>
                                <div class="text-sm text-gray-900">{{ $subject->description ?? 'Aucune description' }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Enseignants assignés -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4">Enseignants assignés</h3>
                        <div class="divide-y divide-gray-200">
                            @forelse($subject->teachers as $teacher)
                                <div class="py-3 flex justify-between items-center">
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ $teacher->user->full_name }}</p>
                                        <p class="text-sm text-gray-500">{{ $teacher->specialty }}</p>
                                    </div>
                                    <a href="{{ route('admin.users.show', $teacher) }}"
                                       class="text-indigo-600 hover:text-indigo-900 text-sm">
                                        Voir le profil
                                    </a>
                                </div>
                            @empty
                                <p class="text-sm text-gray-500">Aucun enseignant assigné à cette matière</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Classes et cours -->
            <div class="mt-6 bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Cours associés</h3>
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Classe</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Enseignant</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Semestre</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Année académique</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($subject->courses as $course)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $course->classroom->name }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $course->teacher->user->full_name }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $course->semester }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $course->academic_year }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                            {{ $course->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $course->status }}
                                        </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('admin.courses.show', $course) }}" class="text-indigo-600 hover:text-indigo-900">
                                        Voir
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                    Aucun cours associé à cette matière
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

