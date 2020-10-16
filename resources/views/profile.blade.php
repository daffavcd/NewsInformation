@extends('layouts.parent')
@section('content')
<div class="container mt-5">

    <div class="row mt-md-3">

        <!-- Blog Entries Column -->
        <div class="col-md-8">

            <h1 class="my-4">Profile
            </h1>
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">My Profile</div>
                        <div class="card-body">
                            @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                            @endif

                            Name : {{ $user->name }} <br> Email : {{ $user->email}}
                        </div>
                        <div class="card-footer text-muted">
                            This is footer profile
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endsection