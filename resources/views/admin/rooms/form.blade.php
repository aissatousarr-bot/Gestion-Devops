<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    <h2 class="text-2xl font-semibold mb-6">
                        {{ isset($room) ? 'Modifier la salle' : 'Ajouter une nouvelle salle' }}
                    </h2>

                    <form action="{{ isset($room) ? route('admin.rooms.update', $room) : route('admin.rooms.store') }}"
                          method="POST"
                          class="space-y-6">
                        @csrf
                        @if(isset($room))
                            @method('PUT')
                        @endif

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Nom de la salle -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Nom de la salle</label>
                                <input type="text"
                                       name="name"
                                       id="name"
                                       value="{{ old('name', $room->name ?? '') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                       required>
                                @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Numéro de la salle -->
                            <div>
                                <label for="number" class="block text-sm font-medium text-gray-700">Numéro de la salle</label>
                                <input type="text"
                                       name="number"
                                       id="number"
                                       value="{{ old('number', $room->number ?? '') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                       required>
                                @error('number')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Type de salle -->
                            <div>
                                <label for="type" class="block text-sm font-medium text-gray-700">Type de salle</label>
                                <select name="type"
                                        id="type"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        required>
                                    <option value="">Sélectionner un type</option>
                                    <option value="classroom" {{ old('type', $room->type ?? '') === 'classroom' ? 'selected' : '' }}>
                                        Salle de classe
                                    </option>
                                    <option value="lab" {{ old('type', $room->type ?? '') === 'lab' ? 'selected' : '' }}>
                                        Laboratoire
                                    </option>
                                    <option value="conference" {{ old('type', $room->type ?? '') === 'conference' ? 'selected' : '' }}>
                                        Salle de conférence
                                    </option>
                                    <option value="other" {{ old('type', $room->type ?? '') === 'other' ? 'selected' : '' }}>
                                        Autre
                                    </option>
                                </select>
                                @error('type')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Capacité -->
                            <div>
                                <label for="capacity" class="block text-sm font-medium text-gray-700">Capacité</label>
                                <input type="number"
                                       name="capacity"
                                       id="capacity"
                                       value="{{ old('capacity', $room->capacity ?? '') }}"
                                       min="1"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                       required>
                                @error('capacity')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Bâtiment -->
                            <div>
                                <label for="building" class="block text-sm font-medium text-gray-700">Bâtiment</label>
                                <input type="text"
                                       name="building"
                                       id="building"
                                       value="{{ old('building', $room->building ?? '') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('building')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Étage -->
                            <div>
                                <label for="floor" class="block text-sm font-medium text-gray-700">Étage</label>
                                <input type="text"
                                       name="floor"
                                       id="floor"
                                       value="{{ old('floor', $room->floor ?? '') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('floor')
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
                                    <option value="available" {{ old('status', $room->status ?? '') === 'available' ? 'selected' : '' }}>
                                        Disponible
                                    </option>
                                    <option value="maintenance" {{ old('status', $room->status ?? '') === 'maintenance' ? 'selected' : '' }}>
                                        En maintenance
                                    </option>
                                    <option value="occupied" {{ old('status', $room->status ?? '') === 'occupied' ? 'selected' : '' }}>
                                        Occupée
                                    </option>
                                </select>
                                @error('status')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea name="description"
                                      id="description"
                                      rows="3"
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description', $room->description ?? '') }}</textarea>
                            @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Boutons d'action -->
                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('admin.rooms.index') }}"
                               class="inline-flex justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50">
                                Annuler
                            </a>
                            <button type="submit"
                                    class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700">
                                {{ isset($room) ? 'Modifier' : 'Créer' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
