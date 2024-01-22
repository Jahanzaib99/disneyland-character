<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Character') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('characters.update', $character->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <!-- Name -->
                        <div>
                            <x-input-label for="name" :value="__('Name')" />
                            <x-text-input id="name" class="block mt-1 w-full"
                                            type="text"
                                            name="name"
                                            required autofocus value="{{ $character->name }}"/>
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="image" :value="__('Character Image')" />
                            <x-file-input class="custom-class mt-2" id="fileInput" name="character_image" />
                            <!-- Image Preview -->
                            <img id="imagePreview" class="mt-2" style="max-width: 100%; max-height: 200px;" src="{{ url('storage/' . $character->image)}}">
                            <x-input-error :messages="$errors->get('character_image')" class="mt-2" />
                        </div>

                        <x-primary-button class="ms-3 mt-4 mb-4 float-right">
                            {{ __('Update') }}
                        </x-primary-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const fileInput = document.getElementById('fileInput');
            const imagePreview = document.getElementById('imagePreview');

            fileInput.addEventListener('change', function () {
                const file = this.files[0];

                if (file) {
                    const reader = new FileReader();

                    reader.addEventListener('load', function (e) {
                        imagePreview.src = e.target.result;
                        imagePreview.style.display = 'block';
                    });

                    reader.readAsDataURL(file);
                } else {
                    imagePreview.src = '';
                    imagePreview.style.display = 'none';
                }
            });
        });
    </script>

</x-app-layout>
