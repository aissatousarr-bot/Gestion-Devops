<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h2 class="text-2xl font-semibold mb-6">Tableau de bord enseignant</h2>

                    <!-- Classes du jour -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold mb-4">Mes classes aujourd'hui</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <!-- Class cards here -->
                        </div>
                    </div>

                    <!-- Tâches en attente -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-lg font-semibold mb-4">Notes à saisir</h3>
                            <!-- Add grades to enter list -->
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-lg font-semibold mb-4">Présences à marquer</h3>
                            <!-- Add attendance to mark list -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
