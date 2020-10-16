@extends('layouts.parent')
@section('content')
<div class="container mt-5">

    <div class="row mt-md-3">

        <!-- Blog Entries Column -->
        <div class="col-md-8">

            <h1 class="my-4">About
            </h1>
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">About me</div>
                        <div class="card-body">
                            @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                            @endif

                            Nama : {{ $nama }} <br> NIM : {{ $nim}}
                        </div>
                        <div class="card-footer text-muted">
                            Ini Footer about
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endsection