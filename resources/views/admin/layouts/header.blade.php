<div class="fixed w-full z-30 flex bg-gray-800 p-2 items-center justify-center h-16 px-10">
    <div
        class="logo ml-12 text-white  transform ease-in-out duration-500 flex-none h-full flex items-center justify-center">
        Dashboard
    </div>
    <!-- SPACER -->
    <div class="grow h-full flex items-center justify-center"></div>
    <div class="flex-none h-full flex items-center justify-center">

        <div class="flex space-x-3 items-center px-3">
            <!-- Profile dropdown -->
            <div class="relative ml-3">
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" type="button"
                        class=" items-center relative flex rounded-full bg-gray-800 text-sm focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800"
                        id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                        <span class="absolute -inset-1.5"></span>
                        <span class="sr-only">Open user menu</span>
                        <img class="h-8 w-8 rounded-full"
                            src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                            alt="">
                        <div class="p-1 ml-1 hidden md:block text-sm md:text-md text-white">John Doe</div>
                    </button>
                    <div x-show="open" @click.away="open = false"
                        x-transition:enter="transition ease-out duration-100 transform"
                        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75 transform"
                        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                        class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                        role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                        <!-- Active: "bg-gray-100", Not Active: "" -->
                        <x-profile-dropdown href="/settings" :active="request()->is('settings')">Settings
                        </x-profile-dropdown>
                        <x-profile-dropdown :active="request()->is('logout')">
                            <form action="{{ route('logout') }}" method="post"
                                class="block w-full hover:cursor-pointer">
                                @csrf
                                <button type="submit" class="w-full text-left">
                                    Sign Out
                                </button>
                            </form>
                        </x-profile-dropdown>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>