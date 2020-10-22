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

  {{-- FORM INPUT KOMEN --}}
  @if(auth()->check())
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
  @else
  <div class="card my-4">
    <h5 class="card-header">Leave a Comment:</h5>
    <div class="card-body">
      <h5>You need to login first to leave a comment.</h5>
    </div>
  </div>
  @endif
  @php
  $total=1;
  $index=0;
  @endphp
  <!-- TAMPIL KOMEN -->
  {{-- KOMEN PARENT --}}
  @foreach ($comment as $item)
  <div class="media mb-4">
    <img class="d-flex mr-3 rounded-circle" src="http://placehold.it/50x50" alt="">
    <div class="media-body" style="display: grid;">
      <div style="display:block">
        <h5 class="mt-0" style="float: left">{{$item->name}}</h5>

        <div class="btn-group" style="float:right;">
          <button type="button" class="btn btn-primary btn-sm " data-toggle="dropdown" aria-haspopup="true"
            aria-expanded="false">
            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-three-dots-vertical" fill="currentColor"
              xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd"
                d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z">
              </path>
            </svg>
          </button>
          <div class="dropdown-menu">
            <a class="dropdown-item reply_{{$total}}" href="#">Reply</a>
            <?php
            if(auth()->check()){
              if($user->id==$item->id_user){
              ?>
            <a class="dropdown-item edit_{{$total}}" href="#">Edit</a>
            <a class="dropdown-item delet" onclick="delet({{$item->id_comment}})" href="#">Delete</a>
            <?php
            }
            }
            ?>
          </div>
        </div>

      </div>
      <div id="komen_{{$total}}">
        {{$item->comment}}
      </div>
      <?php
        if(auth()->check()){
          if($user->id==$item->id_user){
          ?>
          {{-- UPDATE FORM KOMEN PARENT --}}
      <div style="display: block;margin-top: 10px;">
        <form method="POST" action="/updateComment">
          @csrf
          <input type="hidden" name="id" value="{{$item->id_comment}}">
          <input class="form-control form-control-sm edit_komen_{{$total}}" style="width: 82%;display:none;float:left"
            type="text" name="comment" value="{{$item->comment}}">
          <button type="submit" style="margin-left: 6px;display:none"
            class="btn btn-sm btn-primary edit_komen_{{$total}}">Save</button>
          <button type="button" style="margin-left: 6px;display:none"
            class="btn btn-sm btn-light cancel_komen_{{$total}}">Cancel</button>
        </form>
      </div>
      <?php
    } 
    }
      ?>
      {{-- FORM REPLY KOMEN --}}
      <div style="display: block;margin-top: 10px;">
        <form method="POST" action="/replyComment">
          @csrf
          <input type="hidden" name="id_article" value="{{$article->id}}">
          <input type="hidden" name="id_comment_parent" value="{{$item->id_comment}}">
          <input class="form-control form-control-sm reply_komen_{{$total}}" style="width: 80%;display:none;float:left"
            type="text" name="comment" placeholder="Reply Comment...">
          <button type="submit" style="margin-left: 6px;display:none"
            class="btn btn-sm btn-primary reply_komen_{{$total}}">Submit</button>
          <button type="button" style="margin-left: 6px;display:none"
            class="btn btn-sm btn-light cancel_reply_komen_{{$total}}">Cancel</button>
        </form>
      </div>
      {{-- TAMPIL CHILD KOMEN --}}
      @foreach ($anak_comment[$index] as $item)

      <div class="media mt-4">
        <img class="d-flex mr-3 rounded-circle" src="http://placehold.it/50x50" alt="">
        <div class="media-body">
          <h5 class="mt-0">{{$item->name}}</h5>
          {{$item->comment}}
        </div>
      </div>
      @endforeach

    </div>
  </div>
  <?php
  $total+=1;
  $index+=1;
  ?>
  @endforeach
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
        <form method="POST" action="/deleteComment">
          @csrf
          <input type="hidden" id="idcomment" name="id" value="">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
          <button type="submit" class="btn btn-danger">Yes</button>
        </form>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  <?php
      for ($i=1; $i < $total; $i++) { 
        ?>
        // EDIT SHOW KOMEN JQUERY
  $(".edit_<?php echo $i ?>").click(function(evt)
  {
  $(".edit_komen_<?php echo $i ?>").show("slow");
  $(".cancel_komen_<?php echo $i ?>").show("slow");
  $("#komen_<?php echo $i ?>").hide();
  evt.preventDefault();
  });
        // CANCEL EDIT KOMEN JQUERY
  $(".cancel_komen_<?php echo $i ?>").click(function(evt)
  {
  $(".edit_komen_<?php echo $i ?>").hide();
  $(".cancel_komen_<?php echo $i ?>").hide();
  $("#komen_<?php echo $i ?>").show();
  evt.preventDefault();
  });
        // REPLY SHOW KOMEN JQUERY

  $(".reply_<?php echo $i ?>").click(function(evt)
  {
  $(".reply_komen_<?php echo $i ?>").show("slow");
  $(".cancel_reply_komen_<?php echo $i ?>").show("slow");
  evt.preventDefault();
  });
        // CANCEL REPLY JQUERY
  $(".cancel_reply_komen_<?php echo $i ?>").click(function(evt)
  {
  $(".reply_komen_<?php echo $i ?>").hide();
  $(".cancel_reply_komen_<?php echo $i ?>").hide();
  evt.preventDefault();
  });
  <?php } ?>
  function
  delet(key,evt){
  $('#deletemodal').modal('show');
  $('#idcomment').val(key);
  evt.preventDefault();
  };
</script>
@endsection