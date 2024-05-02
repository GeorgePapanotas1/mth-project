<div class="mx-auto mt-8">
    <div class="flex justify-center">
        <div class="block p-6 rounded-lg shadow-lg bg-white w-3/4">
            <div class="pb-5 flex align-middle justify-around">
                {{--                @dd($this)--}}
                @if($isAdmin)

                    <div class="text-center hover:bg-gray-100 p-4">
                        <a href="{{ route(\Mth\Common\Constants\NamedRoutes::COMPANIES) }}">
                            <div class="pb-4">
                                <button class="text-white-800 font-bold py-2 px-4 rounded inline-flex items-center">
                                    <img src="{{ asset('icons/company.svg') }}" alt="Plus Icon" width="36" height="36">
                                </button>
                            </div>
                            Companies
                        </a>
                    </div>
                @endif

                <div class="text-center hover:bg-gray-100 p-4">
                    <a href="{{ route(\Mth\Common\Constants\NamedRoutes::USERS) }}">
                        <div class="pb-4">

                            <button class="text-white-800 font-bold py-2 px-4 rounded inline-flex items-center">
                                <img src="{{ asset('icons/user.svg') }}" alt="Plus Icon" width="36" height="36">
                            </button>
                        </div>
                        Users
                    </a>
                </div>
                <div class="text-center hover:bg-gray-100 p-4">
                    <a href="{{ route(\Mth\Common\Constants\NamedRoutes::PROJECTS) }}">
                        <div class="pb-4">

                            <button class="text-white-800 font-bold py-2 px-4 rounded inline-flex items-center">
                                <img src="{{ asset('icons/project.svg') }}" alt="Plus Icon" width="36" height="36">
                            </button>
                        </div>
                        Projects
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
