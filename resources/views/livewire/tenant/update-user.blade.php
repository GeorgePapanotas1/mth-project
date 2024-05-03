<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Edit user') }}
    </h2>
</x-slot>

<div>
    <div class="max-w-2xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
        <div>
            <h3 class="text-lg leading-6 font-medium text-gray-900">Edit {{ $name }}</h3>
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
                        <input wire:model="email" type="email" name="email" id="email" disabled
                               class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm disabled:bg-gray-200 disabled:cursor-not-allowed">
                    </div>
                    @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">
                        Password
                    </label>
                    <div class="mt-1">
                        <input wire:model="password" type="password" name="password" id="password"
                               class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                    @error('password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">
                        Password Confirmation
                    </label>
                    <div class="mt-1">
                        <input wire:model="password_confirmation" type="password" name="password_confirmation" id="password_confirmation"
                               class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                    @error('password_confirmation') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Edit Role</h3>
                </div>
                @if($role === \Mth\Tenant\Core\Constants\Enums\Role::ADMIN)
                    Cannot edit role on admins
                @else
                    <div class="mt-6">
                        <div class="mt-1">
                            @foreach($availableRoles as $role)
                                <label class="inline-flex items-center mr-4">
                                    <input wire:model="role" type="radio" name="role" value="{{ $role }}"
                                           class="form-radio h-4 w-4 text-indigo-600 transition duration-150 ease-in-out">
                                    <span class="ml-2">{{$role}}</span>
                                </label>
                            @endforeach

                            <label class="inline-flex items-center">
                                <input wire:model="role" type="radio" name="role" value=""
                                       class="form-radio h-4 w-4 text-indigo-600 transition duration-150 ease-in-out disabled:cursor-not-allowed">
                                <span class="ml-2">None</span>
                            </label>
                            @error('role') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>
                @endif

                <div>
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Company</h3>
                </div>

                <div class="w-full mx-auto">
                    <label for="multi-select" class="block text-sm font-medium text-gray-700">Select Options</label>
                    <select id="multi-select" wire:model="selectedCompanies" multiple class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                        @foreach ($availableCompanies as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>

                    <div class="mt-4">
                        <strong>Selected:</strong>
                        <ul>
                            @foreach($selectedCompanies as $selected)
                                <li>{{ $availableCompanies[$selected] ?? 'Invalid option' }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <div class="flex justify-end mt-5">
                    <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Update User
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
