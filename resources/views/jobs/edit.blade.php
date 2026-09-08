<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Job</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded shadow">
                <form method="POST" action="{{ route('jobs.update', $job) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <x-input-label for="title" value="Job Title" />
                        <x-text-input id="title" name="title" class="block mt-1 w-full" value="{{ old('title', $job->title) }}" required />
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="company_name" value="Company Name" />
                        <x-text-input id="company_name" name="company_name" class="block mt-1 w-full" value="{{ old('company_name', $job->company_name) }}" required />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="location" value="Location" />
                        <x-text-input id="location" name="location" class="block mt-1 w-full" value="{{ old('location', $job->location) }}" required />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="job_type" value="Job Type" />
                        <select id="job_type" name="job_type" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                            <option value="full-time" @selected($job->job_type === 'full-time')>Full-time</option>
                            <option value="part-time" @selected($job->job_type === 'part-time')>Part-time</option>
                            <option value="contract" @selected($job->job_type === 'contract')>Contract</option>
                            <option value="remote" @selected($job->job_type === 'remote')>Remote</option>
                        </select>
                    </div>

                    <div class="mb-4 grid grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="salary_min" value="Salary Min ($)" />
                            <x-text-input id="salary_min" name="salary_min" type="number" step="0.01" class="block mt-1 w-full" value="{{ old('salary_min', $job->salary_min) }}" />
                        </div>
                        <div>
                            <x-input-label for="salary_max" value="Salary Max ($)" />
                            <x-text-input id="salary_max" name="salary_max" type="number" step="0.01" class="block mt-1 w-full" value="{{ old('salary_max', $job->salary_max) }}" />
                        </div>
                    </div>

                    <div class="mb-4">
                        <x-input-label for="description" value="Job Description" />
                        <textarea id="description" name="description" rows="6" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>{{ old('description', $job->description) }}</textarea>
                    </div>

                    <div class="mb-4">
                        <x-input-label for="requirements" value="Requirements (optional)" />
                        <textarea id="requirements" name="requirements" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('requirements', $job->requirements) }}</textarea>
                    </div>

                    <div class="mb-4">
                        <x-input-label for="status" value="Status" />
                        <select id="status" name="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                            <option value="open" @selected($job->status === 'open')>Open</option>
                            <option value="closed" @selected($job->status === 'closed')>Closed</option>
                        </select>
                    </div>

                    <x-primary-button>Save Changes</x-primary-button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>