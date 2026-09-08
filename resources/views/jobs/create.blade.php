<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Post a New Job</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded shadow">
                <form method="POST" action="{{ route('jobs.store') }}">
                    @csrf

                    <div class="mb-4">
                        <x-input-label for="title" value="Job Title" />
                        <x-text-input id="title" name="title" class="block mt-1 w-full" value="{{ old('title') }}" required />
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="company_name" value="Company Name" />
                        <x-text-input id="company_name" name="company_name" class="block mt-1 w-full" value="{{ old('company_name') }}" required />
                        <x-input-error :messages="$errors->get('company_name')" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="location" value="Location" />
                        <x-text-input id="location" name="location" class="block mt-1 w-full" value="{{ old('location') }}" required />
                        <x-input-error :messages="$errors->get('location')" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="job_type" value="Job Type" />
                        <select id="job_type" name="job_type" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                            <option value="full-time">Full-time</option>
                            <option value="part-time">Part-time</option>
                            <option value="contract">Contract</option>
                            <option value="remote">Remote</option>
                        </select>
                        <x-input-error :messages="$errors->get('job_type')" class="mt-2" />
                    </div>

                    <div class="mb-4 grid grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="salary_min" value="Salary Min ($)" />
                            <x-text-input id="salary_min" name="salary_min" type="number" step="0.01" class="block mt-1 w-full" value="{{ old('salary_min') }}" />
                        </div>
                        <div>
                            <x-input-label for="salary_max" value="Salary Max ($)" />
                            <x-text-input id="salary_max" name="salary_max" type="number" step="0.01" class="block mt-1 w-full" value="{{ old('salary_max') }}" />
                        </div>
                    </div>

                    <div class="mb-4">
                        <x-input-label for="description" value="Job Description" />
                        <textarea id="description" name="description" rows="6" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>{{ old('description') }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="requirements" value="Requirements (optional)" />
                        <textarea id="requirements" name="requirements" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('requirements') }}</textarea>
                    </div>

                    <x-primary-button>Post Job</x-primary-button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>