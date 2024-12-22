@extends('layouts.app')

@section('title', $title)

@section('content')
<p>halaman user dashboard</p>
@if(session('success')) <div class="bg-green-500 text-white p-3 rounded mb-4">
    {{ session('success') }}
</div>
@endif
@if(session('info'))
<div class="bg-yellow-500 text-white p-3 rounded mb-4">
    {{ session('info') }}
</div>
@endif
@endsection