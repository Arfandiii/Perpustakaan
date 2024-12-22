@extends('layouts.app')

@section('title', $title)

@section('content')
<div class="relative isolate overflow-hidden bg-gray-800 py-8 sm:py-12">
    <div class="hidden sm:absolute sm:-top-10 sm:right-1/2 sm:-z-10 sm:mr-10 sm:block sm:transform-gpu sm:blur-3xl"
        aria-hidden="true">
        <div class="aspect-[1097/845] w-[68.5625rem] bg-gradient-to-tr from-[#ff4694] to-[#776fff] opacity-20"
            style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)">
        </div>
    </div>
    <div class="absolute -top-52 left-1/2 -z-10 -translate-x-1/2 transform-gpu blur-3xl sm:top-[-28rem] sm:ml-16 sm:translate-x-0 sm:transform-gpu"
        aria-hidden="true">
        <div class="aspect-[1097/845] w-[68.5625rem] bg-gradient-to-tr from-[#ff4694] to-[#776fff] opacity-20"
            style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)">
        </div>
    </div>
    <div class="px-6 font-medium my-16">
        <div class="mx-auto max-w-2xl text-center">
            <h2 class="text-balance text-4xl font-semibold tracking-tight text-gray-200 sm:text-5xl">Contact Me
            </h2>
            <p class="mt-2 text-lg/8 text-gray-100">Aute magna irure deserunt veniam aliqua magna enim voluptate.
            </p>
        </div>
        <form action="#" method="POST" class="mx-auto mt-8 max-w-xl">
            <div class="grid grid-cols-1 gap-x-8 gap-y-6 sm:grid-cols-2">
                <div class="sm:col-span-2">
                    <label for="first-name" class="block text-sm/6 font-semibold text-white">Nama Lengkap</label>
                    <div class="mt-2.5">
                        <input type="text" name="first-name" id="first-name" autocomplete="off"
                            class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-purple-300 placeholder:text-gray-400 focus:ring-2 focus:outline-none focus:ring-purple-600 sm:text-sm/6">
                    </div>
                </div>
                <div class="sm:col-span-2">
                    <label for="email" class="block text-sm/6 font-semibold text-white">Email</label>
                    <div class="mt-2.5">
                        <input type="text" name="email" id="email" autocomplete="off"
                            class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-purple-300 placeholder:text-gray-400 focus:ring-2 focus:outline-none focus:ring-purple-600 sm:text-sm/6">
                    </div>
                </div>
                <div class="sm:col-span-2">
                    <label for="message" class="block text-sm/6 font-semibold text-white">Message</label>
                    <div class="mt-2.5">
                        <textarea name="message" id="message" rows="4" autocomplete="off"
                            class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-purple-300 placeholder:text-gray-400 focus:ring-2 focus:outline-none focus:ring-purple-600 sm:text-sm/6"></textarea>
                    </div>
                </div>
            </div>
            <div class="mt-10">
                <button type="submit"
                    class="block w-full rounded-md bg-purple-500 px-3.5 py-2.5 text-center text-sm font-semibold text-white shadow-sm hover:bg-purple-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Kirim</button>
            </div>
        </form>
    </div>
</div>
@endsection