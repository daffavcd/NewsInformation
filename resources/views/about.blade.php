<style>
    .footer {
        position: fixed;
        left: 0;
        bottom: 0;
        width: 100%;
        background-color: red;
        color: white;
        text-align: center;
    }
</style>
@extends('layouts.app')
@section('title', 'Profil')
@section('sidebar')
<p>Sidebar halaman About.</p>
@endsection
@section('header')
<div class="card-header">About</div>
@endsection
@section('content')
<div class="card-body">
    @if (session('status'))
    <div class="alert alert-success" role="alert">
        {{ session('status') }}
    </div>
    @endif

    Nama : {{ $nama }} <br> NIM : {{ $nim}}
</div>
@endsection
@section('footer')
<div class="card-footer text-muted">
    Ini Footer about
</div>
@endsection