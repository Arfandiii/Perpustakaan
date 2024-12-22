@extends('layouts.app')

@section('title', $title)

@section('content')
{{-- Massage --}}
@if (session()->has('success'))
<div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
    <p>{{ session('success')}}</p>
</div>
@endif
@if(session('info'))
<div class="bg-yellow-500 text-white p-3 rounded mb-4">
    {{ session('info') }}
</div>
@endif
<div class="container">
    <h1>Konfirmasi Peminjaman</h1>
    <p>Apakah Anda yakin ingin meminjam buku ini?</p>

    <div class="card mb-4">
        <div class="card-body">
            <h2>{{ $book->title }}</h2>
            <p><strong>Author:</strong> {{ $book->author }}</p>
            <p><strong>Stock:</strong> {{ $book->stock }}</p>
        </div>
    </div>

    <form action="{{ route('loans.createLoan', $book->slug) }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-success">Konfirmasi Peminjaman</button>
        <a href="{{ route('book.showUser', $book->slug) }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection