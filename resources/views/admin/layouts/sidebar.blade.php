<!-- Sidebar -->
<aside
    class="w-60 -translate-x-48 fixed transition transform ease-in-out duration-1000 z-50 flex h-screen bg-gray-800 ">
    <!-- open sidebar button -->
    <div
        class="max-toolbar translate-x-24 scale-x-0 w-full -right-6 transition transform ease-in duration-300 flex items-center justify-between border-4 border-white bg-gray-800  absolute top-2 rounded-full h-12">

        <div class="pl-4 items-center space-x-2 ">
            <div class="hover:cursor-pointer text-white hover:text-indigo-600">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-4">
                    <path fill-rule="evenodd"
                        d="M12 5a4 4 0 0 0-8 0v2.379a1.5 1.5 0 0 1-.44 1.06L2.294 9.707a1 1 0 0 0-.293.707V11a1 1 0 0 0 1 1h2a3 3 0 1 0 6 0h2a1 1 0 0 0 1-1v-.586a1 1 0 0 0-.293-.707L12.44 8.44A1.5 1.5 0 0 1 12 7.38V5Zm-5.5 7a1.5 1.5 0 0 0 3 0h-3Z"
                        clip-rule="evenodd" />
                </svg>
            </div>
        </div>
        <div class="flex items-center space-x-3 group bg-indigo-600  pl-10 pr-2 py-1 rounded-full text-white  ">
            <div class="transform ease-in-out duration-300 mr-12">
                Dashboard
            </div>
        </div>
    </div>
    <div onclick="openNav()"
        class="hover:cursor-pointer -right-6 transition transform ease-in-out duration-500 flex border-4 border-white bg-gray-800 hover:bg-indigo-600 absolute top-2 p-3 rounded-full text-white hover:rotate-45">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={3} stroke="currentColor"
            class="w-4 h-4">
            <path strokeLinecap="round" strokeLinejoin="round"
                d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
        </svg>
    </div>
    <!-- MAX SIDEBAR-->
    <div class="max hidden text-white mt-20 flex-col space-y-2 w-full h-[calc(100vh)]">
        <a href="{{ route('admin.dashboard') }}">
            <x-nav-link-admin iconType="dashboard">Dashboard</x-nav-link-admin>
        </a>
        <a href="{{ route('admin.users.index') }}">
            <x-nav-link-admin iconType="users">Manajemen Pengguna</x-nav-link-admin>
        </a>
        <a href="{{ route('admin.books.index') }}">
            <x-nav-link-admin iconType="books">Manajemen Buku</x-nav-link-admin>
        </a>
        <a href="{{ route('admin.loans.index') }}">
            <x-nav-link-admin iconType="borrowings">Manajemen Peminjaman</x-nav-link-admin>
        </a>
        <a href="{{ route('dicesimilarity.index') }}">
            <x-nav-link-admin iconType="settings">Dice Similarity</x-nav-link-admin>
        </a>
    </div>
    <!-- MINI SIDEBAR-->
    <div class="mini mt-20 flex flex-col space-y-2 w-full h-[calc(100vh)]">
        <a href="{{ route('admin.dashboard') }}">
            <x-nav-link-mini-admin iconType="dashboard"></x-nav-link-mini-admin>
        </a>
        <a href="{{ route('admin.users.index') }}">
            <x-nav-link-mini-admin iconType="users"></x-nav-link-mini-admin>
        </a>
        <a href="{{ route('admin.books.index') }}">
            <x-nav-link-mini-admin iconType="books"></x-nav-link-mini-admin>
        </a>
        <a href="{{ route('admin.loans.index') }}">
            <x-nav-link-mini-admin iconType="borrowings"></x-nav-link-mini-admin>
        </a>
        <a href="{{ route('dicesimilarity.index') }}">
            <x-nav-link-mini-admin iconType="settings"></x-nav-link-mini-admin>
        </a>
    </div>

</aside>