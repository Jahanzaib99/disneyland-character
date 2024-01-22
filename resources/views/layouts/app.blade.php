<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 flex">
        <!-- Sidebar -->
        @include('layouts.sidebar')

        <div class="flex-1">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main class="py-8 px-4">
                {{ $slot }}
            </main>
        </div>
    </div>
    {{-- Include the Select2 library --}}
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script> --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>


    {{-- Initialize the Select2 instance --}}
    <script>
        // Function to apply filters
        function applyFilters() {
            fetchChartData();
        }
        function fetchChartData() {
            // Fetch chart data with filters
            const period = $('#period').val();
            const character = $('#character').val();
            const url = `/admin/chart-data?period=${period}&character=${character}`;

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    // Update charts using Chart.js
                    updateVotesOverTimeChart(data.votesOverTime);
                    updateVotesPerCharacterChart(data.votesPerCharacter);
                    updateTopCharactersChart(data.topCharacters);
                    updateCharacterPopularityByTimeChart(data.characterPopularityByTime);
                    // Update other charts
                })
                .catch(error => console.error('Error fetching chart data:', error));
        }
        $(document).ready(function () {
            // Apply filters when the form is submitted
            $('#filterForm').submit(function (event) {
                event.preventDefault();
                fetchChartData();
            });
            function updateVotesOverTimeChart(data) {
                updateChart('votesOverTimeChart', 'line', 'Votes Over Time', Object.keys(data), [Object.values(data)], ['rgb(75, 192, 192)'], 0.1);
            }

            function updateVotesPerCharacterChart(data) {
                const labels = data.map(character => character.name);
                const votesCount = data.map(character => character.votes_count);
                updateChart('votesPerCharacterChart', 'bar', 'Votes Per Character', labels, [votesCount], ['rgba(75, 192, 192, 0.2)'], 1, true);
            }

            function updateTopCharactersChart(data) {
                const labels = data.map(character => character.name);
                const votesCount = data.map(character => character.votes_count);
                updateChart('topCharactersChart', 'bar', 'Top Characters', labels, [votesCount], ['rgba(192, 75, 192, 0.2)'], 1, true);
            }

            function updateCharacterPopularityByTimeChart(data) {
                updateChart('characterPopularityByTimeChart', 'bar', 'Character Popularity By Time', Object.keys(data), [Object.values(data)], ['rgba(192, 192, 75, 0.2)'], 1);
            }

            function updateChart(chartId, type, label, labels, data, backgroundColor, borderWidth, isMultiDataset = false) {
                const datasets = isMultiDataset ? data.map((dataset, index) => ({
                    label: label + ' ' + (index + 1),
                    data: dataset,
                    backgroundColor: backgroundColor[index],
                    borderColor: backgroundColor[index],
                    borderWidth: borderWidth,
                })) : [{
                    label: label,
                    data: data[0],
                    backgroundColor: backgroundColor[0],
                    borderColor: backgroundColor[0],
                    borderWidth: borderWidth,
                }];

                new Chart(document.getElementById(chartId), {
                    type: type,
                    data: {
                        labels: labels,
                        datasets: datasets,
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true,
                            },
                        },
                    },
                });
            }




            // Fetch chart data on page load
            fetch('/admin/chart-data')
                .then(response => response.json())
                .then(data => {
                    // Update charts using Chart.js
                    updateVotesOverTimeChart(data.votesOverTime);
                    updateVotesPerCharacterChart(data.votesPerCharacter);
                    updateTopCharactersChart(data.topCharacters);
                    updateCharacterPopularityByTimeChart(data.characterPopularityByTime);
                    // Update other charts
                })
                .catch(error => console.error('Error fetching chart data:', error));


        });

    </script>
</body>
</html>
