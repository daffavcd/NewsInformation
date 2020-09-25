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
<p>Sidebar halaman Home.</p>
@endsection
@section('header')
<div class="card-header">Gome</div>
@endsection
@section('content')
<div class="card-body">
    @if (session('status'))
    <div class="alert alert-success" role="alert">
        {{ session('status') }}
    </div>
    @endif

    You are logged in!
</div>
@endsection
@section('footer')
<div class="card-footer text-muted">
    Ini Footer article
</div>
@endsection