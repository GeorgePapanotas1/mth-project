<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Edit Company') }}
    </h2>
</x-slot>

<div>
    <div class="max-w-2xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
        <div>
            <h3 class="text-lg leading-6 font-medium text-gray-900">Edit {{ $name }}</h3>

        </div>

        <div class="mt-6">
            <form wire:submit.prevent="save" class="space-y-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">
                        Company Name
                    </label>
                    <div class="mt-1">
                        <input wire:model="name" type="text" name="name" id="name" required
                               class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                    @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="domain" class="block text-sm font-medium text-gray-700">
                        Address
                    </label>
                    <div class="mt-1">
                        <input wire:model="address" type="text" name="address" id="address" required
                               class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                    @error('address') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Update Company
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
