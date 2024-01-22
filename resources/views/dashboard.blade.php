<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form id="filterForm">
                        <div class="mb-4">
                            <label for="period" class="block text-sm font-medium text-gray-600">Select Period:</label>
                            <input type="date" id="period" name="period" class="mt-1 p-2 border border-gray-300 block w-full rounded-md" required>
                        </div>

                        <div class="mb-4">
                            <label for="character" class="block text-sm font-medium text-gray-600">Select Character:</label>
                            <select id="character" name="character" class="mt-1 p-2 border border-gray-300 block w-full rounded-md" required>
                                <!-- Populate this section with characters from your database -->
                                @foreach($characters as $character)
                                    <option value="{{ $character->id }}">{{ $character->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <button type="button" onclick="applyFilters()" class="p-2 bg-blue-500 text-white rounded-md">Apply Filters</button>
                    </form>
                    <h2><b>{{ __("Votes Over Time") }}</b></h2>
                    <!-- Chart containers -->
                    <canvas id="votesOverTimeChart"></canvas>
                    <h2><b>{{ __("Votes Per Character") }}</b></h2>
                    <canvas id="votesPerCharacterChart"></canvas>
                    <h2><b>{{ __("Top Characters") }}</b></h2>
                    <canvas id="topCharactersChart"></canvas>
                    <h2><b>{{ __("Character Popularity By Time") }}</b></h2>
                    <canvas id="characterPopularityByTimeChart"></canvas>
                    <!-- Add other chart containers -->
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
