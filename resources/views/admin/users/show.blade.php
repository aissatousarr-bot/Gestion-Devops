<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Détails de l\'utilisateur') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex flex-col md:flex-row items-center justify-between">
                        <div class="flex flex-col md:flex-row items-center mb-4 md:mb-0">
                            <img src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}" class="h-24 w-24 md:h-32 md:w-32 object-cover rounded-full">
                            <div class="ml-0 md:ml-6 text-center md:text-left">
                                <h1 class="text-2xl md:text-3xl font-semibold text-gray-800 mb-2">{{ $user->name }}</h1>
                                <p class="text-lg font-medium text-gray-600">{{ $user->email }}</p>
                                <div class="mt-2 flex flex-wrap justify-center md:justify-start">
                                    <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full mr-2 mb-2
                                        {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-800' : '' }}
                                        {{ $user->role === 'teacher' ? 'bg-blue-100 text-blue-800' : '' }}
                                        {{ $user->role === 'student' ? 'bg-green-100 text-green-800' : '' }}
                                        {{ $user->role === 'parent' ? 'bg-yellow-100 text-yellow-800' : '' }}">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                    <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full mb-2
                                        {{ $user->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ ucfirst($user->status) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col md:flex-row items-center">
                            <a href="{{ route('admin.users.edit', $user) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded mb-4 md:mb-0 md:mr-4">
                                <i class="fas fa-edit mr-2"></i>Modifier
                            </a>
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="mb-4 md:mb-0">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-6 rounded">
                                    <i class="fas fa-trash-alt mr-2"></i>Supprimer
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-8">
                <a href="{{ route('admin.users.index') }}" class="inline-block bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold py-2 px-4 rounded">
                    <i class="fas fa-arrow-left mr-2"></i>Retour
                </a>
            </div>
        </div>
    </div>


    <x-slot name="scripts">
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const deleteButton = document.querySelector('form button[type="submit"]');
                deleteButton.addEventListener('click', function(event) {
                    if (!confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')) {
                        event.preventDefault();
                    }
                });
            });
        </script>
    </x-slot>

</x-app-layout>
