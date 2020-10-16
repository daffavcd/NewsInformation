@extends('layouts.parent')
<div class="container mt-5">

  <div class="row">

    <!-- Post Content Column -->
    <div class="col-lg-8">

      <!-- Title -->
      <h1 class="mt-4">{{ $article->title}}</h1>

      <!-- Author -->
      <p class="lead">
        by
        <a href="#">Start Bootstrap</a>
      </p>

      <hr>

      <!-- Date/Time -->
      <p>Posted on {{ $article->created_at}}</p>

      <hr>

      <!-- Preview Image -->
      <img class="img-fluid rounded" src="{{ asset('/images/'.$article->featured_image) }}" alt="">

      <hr>

      <!-- Post Content -->
      <p class="lead">{{ $article->content}}</p>


      <hr>

      <!-- Comments Form -->
      <div class="card my-4">
        <h5 class="card-header">Leave a Comment:</h5>
        <div class="card-body">
          <form method="POST" action="/insertComment">
            @csrf
            <div class="form-group">
              <input type="hidden" name="id_article" value="{{$article->id}}">
              <textarea class="form-control" name="comment" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
          </form>
        </div>
      </div>

      <!-- Single Comment -->
      @foreach ($comment as $item)
      <div class="media mb-4">
        <img class="d-flex mr-3 rounded-circle" src="http://placehold.it/50x50" alt="">
        <div class="media-body">
          <h5 class="mt-0">{{$item->name}}</h5>
          {{$item->comment}}
        </div>
      </div>
      @endforeach

      <!-- Comment with nested comments -->


    </div>