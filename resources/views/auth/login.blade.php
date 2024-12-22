@extends('auth.layouts.app')

@section('title', $title)

@section('content')
<h2 class="text-2xl font-bold mb-6 text-center">Login to Your Account</h2>
<form method="POST" action="{{ route('login') }}">
    @csrf
    <div class="relative z-0 w-full mb-5 group">
        <input type="email" id="email" name="email" required
            class="block py-2.5 px-0 w-full text-sm bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer @error('email') text-pink-600 @enderror"
            placeholder=" " value="{{ old('email') }}">
        <label for="email"
            class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-2 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Email</label>
        @error('email')
        <div class="text-pink-600">
            {{ $message }}
        </div>
        @enderror
    </div>
    <div class="relative z-0 w-full mb-5 group">
        <input type="password" id="password" name="password" required
            class="block py-2.5 px-0 w-full text-sm bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
            placeholder=" ">
        <label for="password"
            class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-2 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Password</label>
    </div>
    <button type="submit"
        class="w-full bg-indigo-600 text-white font-bold py-2 rounded-lg hover:bg-indigo-700 transition duration-200">
        Login
    </button>
</form>
<p class="mt-4 text-center text-gray-600">
    Don't have an account? <a href="{{ route('register') }}" class="text-indigo-600 hover:text-indigo-500">Sign
        up</a>
</p>
@endsection