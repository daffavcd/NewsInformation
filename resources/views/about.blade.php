@extends('layouts.app')
<div class="container" style="margin-top: 75px;padding-bottom: 40px;">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">About</div>
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