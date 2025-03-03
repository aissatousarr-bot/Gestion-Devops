<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    <!-- En-tête -->
                    <h2 class="text-2xl font-semibold mb-6">
                        {{ isset($classroom) ? 'Modifier la classe' : 'Créer une nouvelle classe' }}
                    </h2>

                    <!-- Formulaire -->
                    <form action="{{ isset($classroom) ? route('admin.classes.update', $classroom) : route('admin.classes.store') }}"
                          method="POST"
                          class="space-y-6">
                        @csrf
                        @if(isset($classroom))
                            @method('PUT')
                        @endif

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Nom de la classe -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Nom de la classe</label>
                                <input type="text"
                                       name="name"
                                       id="name"
                                       value="{{ old('name', $classroom->name ?? '') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Section -->
                            <div>
                                <label for="section" class="block text-sm font-medium text-gray-700">Section</label>
                                <select name="section"
                                        id="section"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Sélectionnez une section</option>
                                    <option value="Scientifique" {{ old('section', $class->section ?? '') === 'Scientifique' ? 'selected' : '' }}>Scientifique</option>
                                    <option value="Littéraire" {{ old('section', $class->section ?? '') === 'Littéraire' ? 'selected' : '' }}>Littéraire</option>
                                    <option value="Technique" {{ old('section', $class->section ?? '') === 'Technique' ? 'selected' : '' }}>Technique</option>
                                </select>
                                @error('section')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Niveau -->
                            <div>
                                <label for="level" class="block text-sm font-medium text-gray-700">Niveau</label>
                                <select name="level"
                                        id="level"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Sélectionnez un niveau</option>
                                    @for($i = 1; $i <= 12; $i++)
                                        <option value="{{ $i }}" {{ old('level', $class->level ?? '') == $i ? 'selected' : '' }}>
                                            Niveau {{ $i }}
                                        </option>
                                    @endfor
                                </select>
                                @error('level')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Capacité -->
                            <div>
                                <label for="capacity" class="block text-sm font-medium text-gray-700">Capacité</label>
                                <input type="number"
                                       name="capacity"
                                       id="capacity"
                                       min="1"
                                       value="{{ old('capacity', $class->capacity ?? '') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('capacity')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Année académique -->
                            <div>
                                <label for="academic_year" class="block text-sm font-medium text-gray-700">Année académique</label>
                                <select name="academic_year"
                                        id="academic_year"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @php
                                        $currentYear = date('Y');
                                        for($i = 0; $i < 5; $i++) {
                                            $year = $currentYear - $i;
                                            $academicYear = $year . '-' . ($year + 1);
                                    @endphp
                                    <option value="{{ $academicYear }}" {{ old('academic_year', $class->academic_year ?? '') === $academicYear ? 'selected' : '' }}>
                                        {{ $academicYear }}
                                    </option>
                                    @php
                                        }
                                    @endphp
                                </select>
                                @error('academic_year')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Statut -->
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700">Statut</label>
                                <select name="status"
                                        id="status"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="active" {{ old('status', $class->status ?? '') === 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ old('status', $class->status ?? '') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                                @error('status')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Enseignants -->
                        <div class="mt-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Enseignants</label>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                @foreach($teachers as $teacher)
                                    <div class="flex items-center">
                                        <input type="checkbox"
                                               name="teacher_ids[]"
                                               value="{{ $teacher->id }}"
                                               id="teacher_{{ $teacher->id }}"
                                               {{ in_array($teacher->id, old('teacher_ids', isset($schedule) ? $schedule->teachers->pluck('id')->toArray() : [])) ? 'checked' : '' }}
                                               class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                        <label for="teacher_{{ $teacher->id }}" class="ml-2 block text-sm text-gray-900">
                                            {{ $teacher->user->full_name }} ({{ $teacher->specialty }})
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            @error('teacher_ids')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Boutons d'action -->
                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('admin.classes.index') }}"
                               class="inline-flex justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50">
                                Annuler
                            </a>
                            <button type="submit"
                                    class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700">
                                {{ isset($classroom) ? 'Modifier' : 'Créer' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
