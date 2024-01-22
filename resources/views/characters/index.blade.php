<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Characters') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
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

                    <a href="{{ route('characters.create') }}" class="bg-gray-800  hover:bg-gray-800  text-white font-bold py-2 px-4 rounded float-right">
                        <i class="fa fa-plus"></i> Add Character
                    </a>

                    <div class="overflow-x-auto mt-10">
                        <table class="table min-w-full">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 text-left">ID</th>
                                    <th class="px-6 py-3 text-left">Name</th>
                                    <th class="px-6 py-3 text-left">Image</th>
                                    <th class="px-6 py-3 text-left">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($characters as $character)
                                    <tr>
                                        <td class="px-6 py-4">{{ $character->id }}</td>
                                        <td class="px-6 py-4">{{ $character->name }}</td>
                                        <td class="px-6 py-4"><img src="{{ url('storage/'. $character->image) }}" alt="Image" width="100" height="100"></td>
                                        <td class="px-6 py-4">
                                            <a href="{{ route('characters.edit', $character->id) }}" class="bg-blue-500  hover:bg-blue-500  text-white font-bold py-2 px-4 rounded">Edit</a>
                                            {{-- <a href="{{ route('characters.edit', $character->id) }}" class="btn btn-primary">Edit</a> --}}
                                            <form action="{{ route('characters.destroy', $character->id) }}" method="POST" style="display:inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-500  hover:bg-red-500  text-white font-bold py-2 px-4 rounded">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $characters->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
