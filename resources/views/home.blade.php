@extends('layouts.parent')
<div class="container mt-5">

    <div class="row mt-md-3">

        <!-- Blog Entries Column -->
        <div class="col-md-8">

            <h1 class="my-4">Home

            </h1>

            @foreach ($article as $item)
            <!-- Blog Post -->
            <div class="card mb-4">
                <img class="card-img-top" src="{{ asset('/images/'.$item->featured_image) }}" alt="Card image cap">
                <div class="card-body">
                    <h2 class="card-title">{{$item->title}}</h2>
                    <p class="card-text">{{$item->content}}</p>
                    <a href="article/{{ $item->id }}" class="btn btn-primary">Read More &rarr;</a>
                </div>
                <div class="card-footer text-muted">
                    Posted on {{$item->created_at}} |
                    <a href="/category/{{$item->category}}">{{$item->category}}</a>
                </div>
            </div>
            @endforeach


            <!-- Pagination -->
            <ul class="pagination justify-content-center mb-4">
                @if($article->onFirstPage()!=1)
                <li class="page-item">
                    <a class="page-link" href="{{$article->previousPageUrl()}}">&larr; Previous</a>
                </li>
                @endif
                @if($article->hasMorePages()==1)
                <li class="page-item">
                    <a class="page-link" href="{{$article->nextPageUrl()}}">Next &rarr;</a>
                </li>
                @endif
            </ul>

        </div>