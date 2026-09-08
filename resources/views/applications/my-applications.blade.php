<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">My Applications</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @forelse ($applications as $application)
                <div class="bg-white p-5 rounded shadow mb-4 flex justify-between items-center">
                    <div>
                        <h3 class="font-bold">
                            <a href="{{ route('jobs.show', $application->jobListing) }}" class="text-indigo-700 hover:underline">
                                {{ $application->jobListing->title }}
                            </a>
                        </h3>
                        <p class="text-sm text-gray-600">{{ $application->jobListing->company_name }}</p>
                    </div>
                    <span class="text-sm px-3 py-1 rounded bg-gray-200">{{ ucfirst($application->status) }}</span>
                </div>
            @empty
                <p class="text-gray-600">You haven't applied to any jobs yet.</p>
            @endforelse
        </div>
    </div>
</x-app-layout>