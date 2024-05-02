<div>
    <div class="mx-auto mt-8">
        <div class="flex justify-center">
            <div class="block p-6 rounded-lg shadow-lg bg-white w-3/4">
                <div class="pb-5 flex align-middle justify-between">
                    <h2 class="text-gray-600 text-left text-4xl font-bold">Companies</h2>

                    <a href="#">
                        <button class="bg-blue-600 hover:bg-blue-400 text-white-800 font-bold py-2 px-4 rounded inline-flex items-center">
                            <img src="{{ asset('icons/plus.svg') }}" alt="Plus Icon" width="24" height="24">
                        </button>
                    </a>

                </div>

                <table class="table-auto w-full">
                    <thead>
                    <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                        <th class="py-3 px-6 text-center">Name</th>
                        <th class="py-3 px-6 text-center">Address</th>
                        <th class="py-3 px-6 text-center">Action</th>
                    </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm font-light">
                    @foreach ($companies as $company)
                        <tr class="border-b border-gray-200 hover:bg-gray-100 text-center leading-7" wire:key="tenant-{{ $company->id }}">
                            <td class="py-3 px-6 text-center">
                                {{ $company->name }}
                            </td>
                            <td class="py-3 px-6 text-center">
                                {{ $company->address }}
                            </td>
                            <td class="py-3 px-6 text-center flex justify-center align-middle gap-2">

                                <div>
                                    <a href="#" target="_blank">
                                        <button class="bg-gray-200 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded inline-flex items-center">
                                            <img src="{{ asset('icons/edit.svg') }}" alt="Plus Icon" width="16" height="16">
                                        </button>
                                    </a>
                                </div>

                                <div>
                                    <a href="#" target="_blank">
                                        <button class="bg-red-200 hover:bg-red-400 text-gray-800 font-bold py-2 px-4 rounded inline-flex items-center">
                                            <img src="{{ asset('icons/delete.svg') }}" alt="Plus Icon" width="16" height="16">
                                        </button>
                                    </a>
                                </div>

                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="mt-8">
                    {{ $companies->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
