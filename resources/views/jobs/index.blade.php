<x-guest-layout>
    

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
            @endif

            <form method="GET" class="mb-6 bg-white p-4 rounded shadow flex gap-3">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search job titles..." class="flex-1 border-gray-300 rounded-md shadow-sm">
                <select name="job_type" class="border-gray-300 rounded-md shadow-sm">
                    <option value="">All Types</option>
                    <option value="full-time" @selected(request('job_type') === 'full-time')>Full-time</option>
                    <option value="part-time" @selected(request('job_type') === 'part-time')>Part-time</option>
                    <option value="contract" @selected(request('job_type') === 'contract')>Contract</option>
                    <option value="remote" @selected(request('job_type') === 'remote')>Remote</option>
                </select>
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md">Search</button>
            </form>

            @forelse ($jobs as $job)
                <div class="bg-white p-5 rounded shadow mb-4">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-lg font-bold"><a href="{{ route('jobs.show', $job) }}" class="text-indigo-700 hover:underline">{{ $job->title }}</a></h3>
                            <p class="text-gray-600">{{ $job->company_name }} &middot; {{ $job->location }}</p>
                            <span class="inline-block mt-2 text-xs bg-gray-200 px-2 py-1 rounded">{{ ucfirst($job->job_type) }}</span>
                        </div>
                        @if ($job->salary_min || $job->salary_max)
                            <p class="text-sm text-gray-700">${{ number_format($job->salary_min) }} - ${{ number_format($job->salary_max) }}</p>
                        @endif
                    </div>
                </div>
            @empty
                <p class="text-gray-600">No job listings found.</p>
            @endforelse

            <div class="mt-4">{{ $jobs->links() }}</div>
        </div>
    </div>
</x-guest-layout>