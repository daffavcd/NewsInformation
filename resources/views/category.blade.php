@extends('layouts.parent')
@section('content')

        <!-- Blog Entries Column -->
        <div class="col-md-8">

            <h1 class="my-4">Based on Category 
                <small>{{Request::segment(2)}}</small>
            </h1>

            @foreach ($data as $item)
            <!-- Blog Post -->
            <div class="card mb-4">
                <img class="card-img-top" src="{{ asset('/images/'.$item->featured_image) }}" alt="Card image cap">
                <div class="card-body">
                    <h2 class="card-title">{{$item->title}}</h2>
                    <p class="card-text">{{$item->content}}</p>
                    <a href="/article/{{ $item->id }}" class="btn btn-primary">Read More &rarr;</a>
                </div>
                <div class="card-footer text-muted">
                    Posted on {{$item->created_at}} |
                    <a href="/category/{{$item->category}}">{{$item->category}}</a>
                </div>
            </div>
            @endforeach


            <!-- Pagination -->

        </div>

        @endsection