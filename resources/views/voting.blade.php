<x-guest-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Vote for Your Favorite Character') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Vote for Your Favorite Character') }}
            </h2>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-6">
                <!-- Success Message -->
                @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <strong class="font-bold">Success!</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
                @endif

                <!-- Error Message -->
                @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <strong class="font-bold">Error!</strong>
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
                @endif

                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('vote.store') }}">
                        @csrf
                        <div class="mb-4">

                            <p class="block text-sm font-medium text-gray-600">Select Your Favorite Character:</p>
                            <!-- Populate this section with characters from your database -->
                            @foreach($characters as $character)
                                <div class="flex items-center mt-2">
                                    <input type="radio" id="character{{ $character->id }}" name="character" value="{{ $character->id }}">
                                    <label for="character{{ $character->id }}" class="ml-4 mr-4">{{ $character->name }}</label>
                                    <img src="{{ url('storage/'. $character->image) }}" alt="Image" width="100">
                                </div>
                            @endforeach

                        </div>
                        <div class="mt-4 mb-10">
                            {{ $characters->links() }}
                        </div>
                        <x-primary-button>
                            {{ __('Vote') }}
                        </x-primary-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
