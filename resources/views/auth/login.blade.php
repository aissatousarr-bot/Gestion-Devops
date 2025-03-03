<x-app-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-100 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <div>
                <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                    Connexion à votre compte
                </h2>
            </div>
            <form class="mt-8 space-y-6" action="{{ route('login') }}" method="POST">
                @csrf
                <div class="rounded-md shadow-sm -space-y-px">
                    <div>
                        <x-input
                            type="email"
                            name="email"
                            required
                            class="rounded-t-md"
                            placeholder="Adresse email"
                        />
                    </div>
                    <div>
                        <x-input
                            type="password"
                            name="password"
                            required
                            class="rounded-b-md"
                            placeholder="Mot de passe"
                        />
                    </div>
                </div>

                @error('email')
                <div class="text-red-500 text-sm">{{ $message }}</div>
                @enderror

                <div>
                    <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Se connecter
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
