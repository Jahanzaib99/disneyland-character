<div class="bg-gray-800 text-white w-64 py-8 px-6">
    <!-- Your sidebar content goes here -->
    <h1 class="text-2xl font-bold"><a href="{{ url('/dashboard') }}">Techlify Test</a></h1>
    <ul class="mt-6">
        <li class="mt-4"><a href="{{ route('characters.index') }}" class="text-gray-300 hover:text-white"><b>Characters</b></a></li>
        <li class="mt-4"></i><a href="{{ route('users.index') }}" class="text-gray-300 hover:text-white"><b>Users</b></a></li>
        <li class="mt-4"></i><a href="{{ route('vote') }}" class="text-gray-300 hover:text-white"><b>Voting system</b></a></li>
        <!-- Add more sidebar links as needed -->
    </ul>
</div>
