<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">My Job Listings</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
            @endif

            <a href="{{ route('jobs.create') }}" class="inline-block mb-4 bg-indigo-600 text-white px-4 py-2 rounded-md">+ Post New Job</a>

            @forelse ($jobs as $job)
                <div class="bg-white p-5 rounded shadow mb-4 flex justify-between items-center">
                    <div>
                        <h3 class="font-bold">{{ $job->title }}</h3>
                        <p class="text-sm text-gray-600">{{ $job->location }} &middot; {{ ucfirst($job->status) }}</p>
                    </div>
                    <div class="space-x-3">
                        <a href="{{ route('jobs.applicants', $job) }}" class="text-indigo-600 hover:underline">Applicants</a>
                        <a href="{{ route('jobs.edit', $job) }}" class="text-indigo-600 hover:underline">Edit</a>
                        <form method="POST" action="{{ route('jobs.destroy', $job) }}" class="inline" onsubmit="return confirm('Delete this job listing?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline">Delete</button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="text-gray-600">You haven't posted any jobs yet.</p>
            @endforelse
        </div>
    </div>
</x-app-layout>