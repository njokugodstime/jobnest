<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Applicants for {{ $job->title }}</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
            @endif

            @forelse ($job->applications as $application)
                <div class="bg-white p-5 rounded shadow mb-4">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="font-bold">{{ $application->candidate->name }}</h3>
                            <p class="text-sm text-gray-600">{{ $application->candidate->email }}</p>
                            @if ($application->cover_letter)
                                <p class="mt-2 text-sm">{{ $application->cover_letter }}</p>
                            @endif
                            @if ($application->resume_path)
                                <a href="{{ asset('storage/' . $application->resume_path) }}" target="_blank" class="text-indigo-600 text-sm hover:underline">View Resume</a>
                            @endif
                        </div>
                        <form method="POST" action="{{ route('applications.update-status', $application) }}">
                            @csrf
                            @method('PATCH')
                            <select name="status" onchange="this.form.submit()" class="border-gray-300 rounded-md shadow-sm text-sm">
                                <option value="pending" @selected($application->status === 'pending')>Pending</option>
                                <option value="reviewed" @selected($application->status === 'reviewed')>Reviewed</option>
                                <option value="accepted" @selected($application->status === 'accepted')>Accepted</option>
                                <option value="rejected" @selected($application->status === 'rejected')>Rejected</option>
                            </select>
                        </form>
                    </div>
                </div>
            @empty
                <p class="text-gray-600">No applicants yet.</p>
            @endforelse
        </div>
    </div>
</x-app-layout>