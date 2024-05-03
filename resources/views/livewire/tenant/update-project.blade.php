<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Edit Project') }}
    </h2>
</x-slot>

<div>
    <div class="max-w-2xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
        <div>
            <h3 class="text-lg leading-6 font-medium text-gray-900">Edit {{ $name }}</h3>
            <p class="mt-1 text-sm text-gray-600">
                Use the form below to add a new project to the system.
            </p>
        </div>

        <div class="mt-6">
            <form wire:submit.prevent="submit" class="space-y-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">
                        Project Name
                    </label>
                    <div class="mt-1">
                        <input wire:model="name" type="text" name="name" id="name" required
                               class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                    @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">
                        Project Description
                    </label>
                    <div class="mt-1">
                        <textarea wire:model="description" type="text" name="description" id="description" required
                                  class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
                    </div>
                    @error('address') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <div>
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Company</h3>
                    </div>

                    <div class="w-full mx-auto">
                        <label for="multi-select" class="block text-sm font-medium text-gray-700">Select Options</label>
                        <select id="multi-select" wire:model="selectedCompany" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                            <option value="">Select Company</option>
                            @foreach ($availableCompanies as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>

                    </div>
                </div>

                @if($isAdmin)
                    <div>
                        <div>
                            <h3 class="text-lg leading-6 font-medium text-gray-900">User</h3>
                        </div>

                        <div class="w-full mx-auto">
                            <label for="multi-select" class="block text-sm font-medium text-gray-700">Select Options</label>
                            <select id="multi-select" wire:model="selectedUser" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                <option value="">Select User</option>

                                @foreach ($availableUsers as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>

                        </div>
                    </div>
                @endif

                <div class="flex justify-end">
                    <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Update Project
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
