@extends('layouts.parent')
@section('content')

<!-- Post Content Column -->
<div class="col-lg-8">

  <!-- Title -->
  <h1 class="mt-4">{{ $article->title}}</h1>

  <!-- Author -->
  <p class="lead">
    by
    <a href="#" id="target">Start Bootstrap</a>
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
  @if ($message = Session::get('success'))
  <div class="alert alert-success alert-block">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <strong>{{ $message }}</strong>
  </div>
  @endif
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
        <button type="submit" class="btn btn-primary">Submi</button>
      </form>
    </div>
  </div>

  @php
  $total=1;
  @endphp
  <!-- Single Comment -->
  @foreach ($comment as $item)
  <div class="media mb-4">
    <img class="d-flex mr-3 rounded-circle" src="http://placehold.it/50x50" alt="">
    <div class="media-body" style="display: grid;">
      <div style="display:block">
        <h5 class="mt-0" style="float: left">{{$item->name}}</h5>
        <?php
            if($user->id==$item->id_user){
            ?>
        <div class="btn-group" style="float:right;">
          <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            Action
          </button>
          <div class="dropdown-menu">
            <a class="dropdown-item edit_{{$total}}" href="#">Edit</a>
            <a class="dropdown-item delet" href="#">Delete</a>
          </div>
        </div>
        <?php
            }
            ?>
      </div>
      <div id="komen_{{$total}}">
        {{$item->comment}}
      </div>
      <?php
          if($user->id==$item->id_user){
          ?>
      <div style="display: inline-flex;margin-top: 10px;">
        <input class="form-control edit_komen_{{$total}}" style="width: 590px;display:none" type="text"
          name="edit_{{$item->id_comment}}" value="{{$item->comment}}">
        <button type="submit" style="margin-left: 6px;display:none"
          class="btn btn-warning edit_komen_{{$total}}">Save</button>
      </div>
      <?php
            }
            ?>
    </div>
  </div>
  <?php
  $total+=1;
  ?>
  @endforeach

  <!-- Comment with nested comments -->
</div>
@endsection
@section('script')
<div class="modal fade" id="deletemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Alert ! </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p> Are you sure you want to delete this comment ? </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
        <button type="button" class="btn btn-danger">Yes</button>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  <?php
      for ($i=1; $i < $total; $i++) { 
        ?>
  $(".edit_<?php echo $i ?>").click(function(evt)
  {
  $(".edit_komen_<?php echo $i ?>").show("slow");
  $("#komen_<?php echo $i ?>").hide();
  evt.preventDefault();
  });
  <?php } ?>
  $(".delet").click(function(evt){
  $('#deletemodal').modal('show');
  evt.preventDefault();
  });
</script>
@endsection