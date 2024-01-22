<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Thank You for Voting!') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <!-- Display thank you message -->
        <p>Thank you for casting your vote! Redirecting to the voting screen...</p>
    </div>

    <script>
        // Redirect to the voting screen after 3 seconds
        setTimeout(function() {
            window.location.href = "{{ route('vote') }}";
        }, 3000);
    </script>
</x-app-layout>
