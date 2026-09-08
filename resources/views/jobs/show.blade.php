<x-guest-layout>
    

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="mb-4 p-4 bg-red-100 text-red-800 rounded">{{ session('error') }}</div>
            @endif

            <div class="bg-white p-6 rounded shadow">
                <p class="text-gray-600">{{ $job->company_name }} &middot; {{ $job->location }}</p>
                <span class="inline-block mt-2 text-xs bg-gray-200 px-2 py-1 rounded">{{ ucfirst($job->job_type) }}</span>

                @if ($job->salary_min || $job->salary_max)
                    <p class="mt-3 font-semibold">${{ number_format($job->salary_min) }} - ${{ number_format($job->salary_max) }}</p>
                @endif

                <div class="mt-6">
                    <h3 class="font-bold text-lg">Description</h3>
                    <p class="mt-2 whitespace-pre-line">{{ $job->description }}</p>
                </div>

                @if ($job->requirements)
                    <div class="mt-6">
                        <h3 class="font-bold text-lg">Requirements</h3>
                        <p class="mt-2 whitespace-pre-line">{{ $job->requirements }}</p>
                    </div>
                @endif

                <p class="mt-6 text-sm text-gray-500">Posted by {{ $job->employer->name }}</p>

                @auth
                    @if (auth()->user()->role === 'candidate')
                        <div class="mt-6 border-t pt-6">
                            @if ($hasApplied)
                                <p class="text-green-700 font-semibold">You have already applied to this job.</p>
                            @else
                                <form method="POST" action="{{ route('applications.store', $job) }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-4">
                                        <x-input-label for="cover_letter" value="Cover Letter (optional)" />
                                        <textarea id="cover_letter" name="cover_letter" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></textarea>
                                    </div>
                                    <div class="mb-4">
                                        <x-input-label for="resume" value="Resume (PDF/DOC, optional)" />
                                        <input type="file" id="resume" name="resume" class="mt-1 block w-full">
                                    </div>
                                    <x-primary-button>Apply Now</x-primary-button>
                                </form>
                            @endif
                        </div>
                    @endif
                @endauth

                @guest
                    <div class="mt-6 border-t pt-6">
                        <a href="{{ route('login') }}" class="text-indigo-600 hover:underline">Log in to apply for this job</a>
                    </div>
                @endguest
            </div>
        </div>
    </div>
</x-guest-layout>