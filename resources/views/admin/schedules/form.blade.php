<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    <h2 class="text-2xl font-semibold mb-6">
                        {{ isset($schedule) ? 'Modifier le cours' : 'Ajouter un nouveau cours' }}
                    </h2>

                    <form action="{{ isset($schedule) ? route('admin.schedules.update', $schedule) : route('admin.schedules.store') }}"
                          method="POST"
                          class="space-y-6">
                        @csrf
                        @if(isset($schedule))
                            @method('PUT')
                        @endif

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Classe -->
                            <div>
                                <label for="classroom_id" class="block text-sm font-medium text-gray-700">Classe</label>
                                <select name="classroom_id"
                                        id="classroom_id"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        required>
                                    <option value="">Sélectionner une classe</option>
                                    @foreach($classrooms as $classroom)
                                        <option value="{{ $classroom->id }}"
                                            {{ old('classroom_id', $schedule->classroom_id ?? '') == $classroom->id ? 'selected' : '' }}>
                                            {{ $classroom->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('classroom_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Matière -->
                            <div>
                                <label for="subject_id" class="block text-sm font-medium text-gray-700">Matière</label>
                                <select name="subject_id"
                                        id="subject_id"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        required>
                                    <option value="">Sélectionner une matière</option>
                                    @foreach($subjects as $subject)
                                        <option value="{{ $subject->id }}"
                                            {{ old('subject_id', $schedule->subject_id ?? '') == $subject->id ? 'selected' : '' }}>
                                            {{ $subject->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('subject_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Enseignant -->
                            <div>
                                <label for="teacher_id" class="block text-sm font-medium text-gray-700">Enseignant</label>
                                <select name="teacher_id"
                                        id="teacher_id"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        required>
                                    <option value="">Sélectionner un enseignant</option>
                                    @foreach($teachers as $teacher)
                                        <option value="{{ $teacher->id }}"
                                            {{ old('teacher_id', $schedule->teacher_id ?? '') == $teacher->id ? 'selected' : '' }}>
                                            {{ $teacher->user->full_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('teacher_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Salle -->
                            <div>
                                <label for="room_id" class="block text-sm font-medium text-gray-700">Salle</label>
                                <select name="room_id"
                                        id="room_id"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        required>
                                    <option value="">Sélectionner une salle</option>
                                    @foreach($rooms as $room)
                                        <option value="{{ $room->id }}"
                                            {{ old('room_id', $schedule->room_id ?? '') == $room->id ? 'selected' : '' }}>
                                            {{ $room->name }} (Capacité: {{ $room->capacity }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('room_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Jour -->
                            <div>
                                <label for="day" class="block text-sm font-medium text-gray-700">Jour</label>
                                <select name="day"
                                        id="day"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        required>
                                    <option value="">Sélectionner un jour</option>
                                    @foreach(['monday' => 'Lundi', 'tuesday' => 'Mardi', 'wednesday' => 'Mercredi', 'thursday' => 'Jeudi', 'friday' => 'Vendredi', 'saturday' => 'Samedi'] as $value => $label)
                                        <option value="{{ $value }}"
                                            {{ old('day', $schedule->day ?? '') == $value ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('day')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Heure de début -->
                            <div>
                                <label for="start_time" class="block text-sm font-medium text-gray-700">Heure de début</label>
                                <input type="time"
                                       name="start_time"
                                       id="start_time"
                                       value="{{ old('start_time', isset($schedule) ? date('H:i', strtotime($schedule->start_time)) : '') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                       required>
                                @error('start_time')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Heure de fin -->
                            <div>
                                <label for="end_time" class="block text-sm font-medium text-gray-700">Heure de fin</label>
                                <input type="time"
                                       name="end_time"
                                       id="end_time"
                                       value="{{ old('end_time', isset($schedule) ? date('H:i', strtotime($schedule->end_time)) : '') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                       required>
                                @error('end_time')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Semestre -->
                            <div>
                                <label for="semester" class="block text-sm font-medium text-gray-700">Semestre</label>
                                <select name="semester"
                                        id="semester"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        required>
                                    <option value="S1" {{ old('semester', $schedule->semester ?? '') == 'S1' ? 'selected' : '' }}>Semestre 1</option>
                                    <option value="S2" {{ old('semester', $schedule->semester ?? '') == 'S2' ? 'selected' : '' }}>Semestre 2</option>
                                </select>
                                @error('semester')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Année académique -->
                            <div>
                                <label for="academic_year" class="block text-sm font-medium text-gray-700">Année académique</label>
                                <select name="academic_year"
                                        id="academic_year"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        required>
                                    @php
                                        $currentYear = date('Y');
                                        for($i = 0; $i < 5; $i++) {
                                            $year = $currentYear - $i;
                                            $academicYear = $year . '-' . ($year + 1);
                                    @endphp
                                    <option value="{{ $academicYear }}"
                                        {{ old('academic_year', $schedule->academic_year ?? '') == $academicYear ? 'selected' : '' }}>
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
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        required>
                                    <option value="active" {{ old('status', $schedule->status ?? '') == 'active' ? 'selected' : '' }}>Actif</option>
                                    <option value="cancelled" {{ old('status', $schedule->status ?? '') == 'cancelled' ? 'selected' : '' }}>Annulé</option>
                                </select>
                                @error('status')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Notes -->
                        <div>
                            <label for="notes" class="block text-sm font-medium text-gray-700">Notes</label>
                            <textarea name="notes"
                                      id="notes"
                                      rows="3"
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('notes', $schedule->notes ?? '') }}</textarea>
                            @error('notes')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Boutons d'action -->
                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('admin.schedules.index') }}"
                               class="inline-flex justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50">
                                Annuler
                            </a>
                            <button type="submit"
                                    class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700">
                                {{ isset($schedule) ? 'Modifier' : 'Créer' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
