<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    <h2 class="text-2xl font-semibold mb-6">
                        {{ isset($subject) ? 'Modifier la matière' : 'Créer une nouvelle matière' }}
                    </h2>

                    <form action="{{ isset($subject) ? route('admin.subjects.update', $subject) : route('admin.subjects.store') }}"
                          method="POST"
                          class="space-y-6">
                        @csrf
                        @if(isset($subject))
                            @method('PUT')
                        @endif

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Code -->
                            <div>
                                <label for="code" class="block text-sm font-medium text-gray-700">Code matière</label>
                                <input type="text"
                                       name="code"
                                       id="code"
                                       value="{{ old('code', $subject->code ?? '') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('code')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Nom -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Nom de la matière</label>
                                <input type="text"
                                       name="name"
                                       id="name"
                                       value="{{ old('name', $subject->name ?? '') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Coefficient -->
                            <div>
                                <label for="coefficient" class="block text-sm font-medium text-gray-700">Coefficient</label>
                                <input type="number"
                                       name="coefficient"
                                       id="coefficient"
                                       step="0.1"
                                       min="0.1"
                                       max="10"
                                       value="{{ old('coefficient', $subject->coefficient ?? '') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('coefficient')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Heures par semaine -->
                            <div>
                                <label for="hours_per_week" class="block text-sm font-medium text-gray-700">Heures par semaine</label>
                                <input type="number"
                                       name="hours_per_week"
                                       id="hours_per_week"
                                       min="1"
                                       max="20"
                                       value="{{ old('hours_per_week', $subject->hours_per_week ?? '') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('hours_per_week')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Description -->
                            <div class="md:col-span-2">
                                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                                <textarea name="description"
                                          id="description"
                                          rows="3"
                                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description', $subject->description ?? '') }}</textarea>
                                @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Statut -->
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700">Statut</label>
                                <select name="status"
                                        id="status"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="active" {{ old('status', $subject->status ?? '') === 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ old('status', $subject->status ?? '') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                                @error('status')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Enseignants -->
                        <div class="mt-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Enseignants assignés</h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                @foreach($teachers as $teacher)
                                    <div class="flex items-center">
                                        <input type="checkbox"
                                               name="teacher_ids[]"
                                               value="{{ $teacher->id }}"
                                               id="teacher_{{ $teacher->id }}"
                                               {{ in_array($teacher->id, old('teacher_ids', isset($subject) ? $subject->teachers->pluck('id')->toArray() : [])) ? 'checked' : '' }}
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
                            <a href="{{ route('admin.subjects.index') }}"
                               class="inline-flex justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50">
                                Annuler
                            </a>
                            <button type="submit"
                                    class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700">
                                {{ isset($subject) ? 'Modifier' : 'Créer' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
