<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('User Creation') }}
    </h2>
</x-slot>

<div>
    <div class="max-w-2xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
        <div>
            <h3 class="text-lg leading-6 font-medium text-gray-900">Add new user</h3>
            <p class="mt-1 text-sm text-gray-600">
                Use the form below to add a new user to the system.
            </p>
        </div>

        <div class="mt-6">
            <form wire:submit.prevent="submit" class="space-y-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">
                        User Name
                    </label>
                    <div class="mt-1">
                        <input wire:model="name" type="text" name="name" id="name" required
                               class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                    @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">
                        Email
                    </label>
                    <div class="mt-1">
                        <input wire:model="email" type="email" name="email" id="email" required
                               class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                    @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">
                        Password
                    </label>
                    <div class="mt-1">
                        <input wire:model="password" type="password" name="password" id="password" required
                               class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                    @error('password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">
                        Password Confirmation
                    </label>
                    <div class="mt-1">
                        <input wire:model="password_confirmation" type="password" name="password_confirmation" id="password_confirmation" required
                               class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                    @error('password_confirmation') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Create User
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
