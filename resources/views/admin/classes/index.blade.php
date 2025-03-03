<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- En-tête -->
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-semibold text-gray-800">
                    Gestion des Classes
                </h2>
                <a href="{{ route('admin.classes.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
                    + Nouvelle Classe
                </a>
            </div>

            <!-- Filtres -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <form action="{{ route('admin.classes.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4">
                    <!-- Recherche -->
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-700">Recherche</label>
                        <input type="text"
                               name="search"
                               id="search"
                               value="{{ request('search') }}"
                               placeholder="Nom de la classe..."
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <!-- Section -->
                    <div>
                        <label for="section" class="block text-sm font-medium text-gray-700">Section</label>
                        <select name="section"
                                id="section"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Toutes les sections</option>
                            <option value="Genie Logiciel" {{ request('section') === 'Genie Logiciel' ? 'selected' : '' }}>Scientifique</option>
                            <option value="Reseaux informatique" {{ request('section') === 'Reseaux informatique' ? 'selected' : '' }}>Littéraire</option>
                            <option value="CyberSecurite" {{ request('section') === 'CyberSecurite' ? 'selected' : '' }}>Technique</option>
                        </select>
                    </div>

                    <!-- Niveau -->
                    <div>
                        <label for="level" class="block text-sm font-medium text-gray-700">Niveau</label>
                        <select name="level"
                                id="level"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Tous les niveaux</option>
                            @for($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}" {{ request('level') == $i ? 'selected' : '' }}>
                                    Niveau {{ $i }}
                                </option>
                            @endfor
                        </select>
                    </div>

                    <!-- Année académique -->
                    <div>
                        <label for="academic_year" class="block text-sm font-medium text-gray-700">Année académique</label>
                        <select name="academic_year"
                                id="academic_year"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Toutes les années</option>
                            @php
                                $currentYear = date('Y');
                                for($i = 0; $i < 5; $i++) {
                                    $year = $currentYear - $i;
                                    $academicYear = $year . '-' . ($year + 1);
                            @endphp
                            <option value="{{ $academicYear }}" {{ request('academic_year') === $academicYear ? 'selected' : '' }}>
                                {{ $academicYear }}
                            </option>
                            @php
                                }
                            @endphp
                        </select>
                    </div>

                    <!-- Bouton Filtrer -->
                    <div class="flex items-end">
                        <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded-md hover:bg-gray-700">
                            Filtrer
                        </button>
                    </div>
                </form>
            </div>

            <!-- Liste des classes -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Classe
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Section
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Niveau
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Capacité
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Étudiants
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Année
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
                        @forelse($classrooms as $classroom)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $classroom->name }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $classroom->section }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $classroom->level }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $classroom->capacity }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        {{ $classroom->students_count }}/{{ $classroom->capacity }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $classroom->academic_year }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                            {{ $classroom->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $classroom->status === 'active' ? 'Active' : 'Inactive' }}
                                        </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('admin.classes.show', $classroom) }}"
                                       class="text-blue-600 hover:text-blue-900 mr-3">
                                        Voir
                                    </a>
                                    <a href="{{ route('admin.classes.edit', $classroom) }}"
                                       class="text-indigo-600 hover:text-indigo-900 mr-3">
                                        Modifier
                                    </a>
                                    <form action="{{ route('admin.classes.destroy', $classroom) }}"
                                          method="POST"
                                          class="inline"
                                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette classe ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">
                                            Supprimer
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-4 text-center text-gray-500">
                                    Aucune classe trouvée
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($classrooms->hasPages())
                    <div class="px-6 py-4 bg-gray-50">
                        {{ $classrooms->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
