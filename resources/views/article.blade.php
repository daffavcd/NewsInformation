@extends('layouts.parent')
@section('content')
<style>
  .falikedislike {
    color: #909090;
  }

  .falikedislike:hover {
    color: #796b6b !important;
  }
</style>
<div class="tunggu"
  style="z-index:9999999999999999; background:rgba(255,255,255,0.8); width:100%; height:100%; position:fixed; top:0; left:0; text-align:center; padding-top:23%; display:none ; ">
  <img src="{{ asset('/images/rolling.gif') }}" />
</div>

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
  <img class="img-fluid rounded" src="{{ asset('storage/articleImages/'.$article->featured_image) }}" alt="">

  <hr>

  <!-- Post Content -->
  <p class="lead">{{ $article->content}}</p>

  <hr>
  {{-- LIKE CONTENT --}}
  <input type="hidden" id="total_likes" value="{{$jumlah_likes->jumlah_likes}}">
  <input type="hidden" name="_token" id="csrf" value="{{Session::token()}}">
  <img onclick="like({{$article->id}},{{@$user->id}})" class="like"
    style="width: 5%;cursor: pointer;<?php if (!empty($cek_likes)) { echo 'display:none;';  } ?>"
    src="{{ asset('/images/hatipolos.png') }}" alt="">

  <img onclick="unlike({{$article->id}})" class="unlike"
    style="width: 5%;<?php if (empty($cek_likes)) { echo 'display:none;'; } ?>cursor: pointer;"
    src="{{ asset('/images/hatimerah.png') }}" alt="">
  <span class="badge badge-light" id="tampil_likes">{{$jumlah_likes->jumlah_likes}}</span>
  {{-- KOMEN CLICK CONTENT --}}
  <img onclick="buka_komen({{@$user->id}})" style="width: 5%;cursor: pointer; ?>"
    src="{{ asset('/images/speech-bubble.png') }}" alt="">
  <span class="badge badge-light">{{$jumlah_comment->jumlah}}</span>
  <div class="btn-group" style="float:right;">
    <div style="cursor: pointer" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      <i class="fas fa-sort-amount-down-alt fa-2x"></i>
      <span class="badge badge-light" title="Sort By" style="vertical-align: super;" id="sort_by_text">SORT BY</span>
    </div>
    <div class="dropdown-menu">
      <a class="drop-sort dropdown-item" onclick="sort_by_top({{$article->id}})" id="sortTop"
        style="cursor: pointer">Top Comment</a>
      <a class="drop-sort dropdown-item" onclick="sort_by_last({{$article->id}})" id="sortLast"
        style="cursor: pointer">Lastest First</a>
    </div>
  </div>
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
  <div class="card my-4" id="buka_komen" style="display: none">
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
  @endif
  <div id="komen_replace">
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
          <?php
        if (auth()->check()) {
        ?>
          {{-- DROPDOWN ACTION KOMEN --}}
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
              if (auth()->check()) {
                if ($user->id == $item->id_user) {
              ?>
              <a class="dropdown-item edit_{{$total}}" href="#">Edit</a>
              <a class="dropdown-item delet" style="cursor: pointer" onclick="delet({{$item->id_comment}})">Delete</a>
              <?php
                }
              }
              ?>
            </div>
          </div>
          <?php } ?>

        </div>
        <div id="komen_{{$total}}">
          {{$item->comment}}
        </div>
        <?php 
       $jumlah_like_comment = \App\Comment_like::select(DB::raw('count(*) as jumlah_likes'))->where('comment_id', $item->id_comment)->where('likes', 1)->first();
       $cek_sudah_like = \App\Comment_like::select('*')->where('comment_id', $item->id_comment)->where('likes', 1)->where('id_user', @$user->id)->first();
      
       $jumlah_dislike_comment = \App\Comment_like::select(DB::raw('count(*) as jumlah_dislikes'))->where('comment_id', $item->id_comment)->where('likes', 0)->first();
       $cek_sudah_dislike = \App\Comment_like::select('*')->where('comment_id', $item->id_comment)->where('likes', 0)->where('id_user', @$user->id)->first();
      ?>
        <div>
          {{-- LIKE DISLIKE COMMENT PARRENT --}}
          <i class="fas fa-thumbs-up falikedislike" id="like_comment_{{$item->id_comment}}" style="cursor: pointer;<?php if(!empty($cek_sudah_like)){echo 'color: blue" title="Unlike"';}else{echo '" title="Like"';}?>
          onclick=" like_comment({{$item->id_comment}},{{@$user->id}})"></i>
          <span class="badge badge-light"
            id="tampil_total_like_comment_{{$item->id_comment}}">{{$jumlah_like_comment->jumlah_likes}}</span>
          <input type="hidden" id="total_like_comment_{{$item->id_comment}}"
            value="{{$jumlah_like_comment->jumlah_likes}}">
          <i class="fas fa-thumbs-down falikedislike" id="dislike_comment_{{$item->id_comment}}"
            style="cursor: pointer;<?php if(!empty($cek_sudah_dislike)){echo 'color: blue" title="Remove Dislike"';}else{echo '" title="Dislike"';}?>"
            onclick="dislike_comment({{$item->id_comment}},{{@$user->id}})"></i>
          <span class="badge badge-light"
            id="tampil_total_dislike_comment_{{$item->id_comment}}">{{$jumlah_dislike_comment->jumlah_dislikes}}</span>
          <input type="hidden" id="total_dislike_comment_{{$item->id_comment}}"
            value="{{$jumlah_dislike_comment->jumlah_dislikes}}">
        </div>
        <?php
      if (auth()->check()) {
        if ($user->id == $item->id_user) {
      ?> {{-- UPDATE FORM KOMEN PARENT --}} <div style="display: block;margin-top: 10px;">
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
      if (auth()->check()) {
        ?>
        {{-- FORM REPLY KOMEN --}}
        <div style="display: block;margin-top: 10px;">
          <form method="POST" action="/replyComment">
            @csrf
            <input type="hidden" name="id_article" value="{{$article->id}}">
            <input type="hidden" name="id_comment_parent" value="{{$item->id_comment}}">
            <input class="form-control form-control-sm reply_komen_{{$total}}"
              style="width: 80%;display:none;float:left" type="text" name="comment" placeholder="Reply Comment...">
            <button type="submit" style="margin-left: 6px;display:none"
              class="btn btn-sm btn-primary reply_komen_{{$total}}">Submit</button>
            <button type="button" style="margin-left: 6px;display:none"
              class="btn btn-sm btn-light cancel_reply_komen_{{$total}}">Cancel</button>
          </form>
        </div>
        <?php
      }

      ?>
        {{-- TAMPIL CHILD KOMEN --}}
        @php
        $total_child=1;
        @endphp
        @foreach ($anak_comment[$index] as $item)
        <div class="media mt-4">
          <img class="d-flex mr-3 rounded-circle" src="http://placehold.it/50x50" alt="">
          <div class="media-body" style="display: grid;">
            <div style="display: block">
              <h5 class="mt-0" style="float: left">{{$item->name}}</h5>
              <?php
            if (auth()->check()) {
            ?>
              <?php
             if ($user->id == $item->id_user) {
             ?>
              <div class="btn-group" style="float:right;">
                <button type="button" class="btn btn-primary btn-sm " data-toggle="dropdown" aria-haspopup="true"
                  aria-expanded="false">
                  <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-three-dots-vertical"
                    fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                      d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z">
                    </path>
                  </svg>
                </button>

                <div class="dropdown-menu">

                  <a class="dropdown-item edit_{{$total}}_{{$total_child}}" href="#">Edit</a>
                  <a class="dropdown-item delet" style="cursor: pointer"
                    onclick="delet({{$item->id_comment}})">Delete</a>

                </div>
              </div>
              <?php
                  }

                  ?>
              <?php
            }
            ?>
            </div>
            <div id="komen_{{$total}}_{{$total_child}}">
              {{$item->comment}}
            </div>
            <?php 
       $jumlah_like_comment = \App\Comment_like::select(DB::raw('count(*) as jumlah_likes'))->where('comment_id', $item->id_comment)->where('likes', 1)->first();
       $cek_sudah_like = \App\Comment_like::select('*')->where('comment_id', $item->id_comment)->where('likes', 1)->where('id_user', @$user->id)->first();
      
       $jumlah_dislike_comment = \App\Comment_like::select(DB::raw('count(*) as jumlah_dislikes'))->where('comment_id', $item->id_comment)->where('likes', 0)->first();
       $cek_sudah_dislike = \App\Comment_like::select('*')->where('comment_id', $item->id_comment)->where('likes', 0)->where('id_user', @$user->id)->first();
      ?>
            <div>
              {{-- LIKE DISLIKE COMMENT PARRENT --}}
              <i class="fas fa-thumbs-up falikedislike" id="like_comment_{{$item->id_comment}}" style="cursor: pointer;<?php if(!empty($cek_sudah_like)){echo 'color: blue" title="Unlike"';}else{echo '" title="Like"';}?>
          onclick=" like_comment({{$item->id_comment}},{{@$user->id}})"></i>
              <span class="badge badge-light"
                id="tampil_total_like_comment_{{$item->id_comment}}">{{$jumlah_like_comment->jumlah_likes}}</span>
              <input type="hidden" id="total_like_comment_{{$item->id_comment}}"
                value="{{$jumlah_like_comment->jumlah_likes}}">
              <i class="fas fa-thumbs-down falikedislike" id="dislike_comment_{{$item->id_comment}}"
                style="cursor: pointer;<?php if(!empty($cek_sudah_dislike)){echo 'color: blue" title="Remove Dislike"';}else{echo '" title="Dislike"';}?>"
                onclick="dislike_comment({{$item->id_comment}},{{@$user->id}})"></i>
              <span class="badge badge-light"
                id="tampil_total_dislike_comment_{{$item->id_comment}}">{{$jumlah_dislike_comment->jumlah_dislikes}}</span>
              <input type="hidden" id="total_dislike_comment_{{$item->id_comment}}"
                value="{{$jumlah_dislike_comment->jumlah_dislikes}}">
            </div>
            <?php
          if (auth()->check()) {
            if ($user->id == $item->id_user) {
          ?>
            {{-- UPDATE FORM KOMEN CHILD --}}
            <div style="display: block;margin-top: 10px;">
              <form method="POST" action="/updateComment">
                @csrf
                <input type="hidden" name="id" value="{{$item->id_comment}}">
                <input class="form-control form-control-sm edit_komen_{{$total}}_{{$total_child}}"
                  style="width: 80%;display:none;float:left" type="text" name="comment" value="{{$item->comment}}">
                <button type="submit" style="margin-left: 6px;display:none"
                  class="btn btn-sm btn-primary edit_komen_{{$total}}_{{$total_child}}">Save</button>
                <button type="button" style="margin-left: 6px;display:none"
                  class="btn btn-sm btn-light cancel_komen_{{$total}}_{{$total_child}}">Cancel</button>
              </form>
            </div>
            <?php
            }
          }
          $total_child += 1;
          ?>
          </div>
        </div>
        @endforeach

      </div>
    </div>
    <?php
  $total += 1;
  $index += 1;
  ?>
    @endforeach
  </div>
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
<script>
  function sort_by_last(key){
    $.ajax( {  
			type :"GET",  
      url : "/article/sortLast/"+key,  
      beforeSend: function() {
        $(".tunggu").show();
      },
			success : function(data) { 
        $('#sort_by_text').text('SORT BY LAST');
        $("#komen_replace").html(data);
        $(".tunggu").hide();    
			} 
		});
		return false;
}
function sort_by_top(key){
    $.ajax( {  
			type :"GET",  
      url : "/article/sortTop/"+key, 
      beforeSend: function() {
            $(".tunggu").show();
      }, 
			success : function(data) { 
        $('#sort_by_text').text('SORT BY TOP');
        $("#komen_replace").html(data);   
        $(".tunggu").hide(); 
			} 
		});
		return false;
}
  function like_comment(key,cek){
  var color1 = document.getElementById('like_comment_'+key);
var color2 = document.getElementById('dislike_comment_'+key);
  if (cek) {
      $.ajax({
        url: "/commentLike",
        type: "POST",
        data: {
          _token: $("#csrf").val(),
          comment_id: key
        },
        cache: false,
        success: function(dataResult) {
          console.log(dataResult);
          var dataResult = JSON.parse(dataResult);
          if (dataResult.statusCode == 'insert') {
            color1.style.color = color1.style.color === 'blue' ? '#909090': 'blue';
            color2.style.color = '#909090';
            $('#total_like_comment_'+key).val(parseInt($('#total_like_comment_'+key).val()) + 1);
            $("#tampil_total_like_comment_"+key).html($('#total_like_comment_'+key).val());
            $('#like_comment_'+key).prop('title', 'Unlike');
            $('#dislike_comment_'+key).prop('title', 'Dislike');
          } else if (dataResult.statusCode == 'update') {
            color1.style.color = color1.style.color === 'blue' ? '#909090': 'blue';
            color2.style.color = '#909090';
            //Kurangi yang Dislike
            $('#total_dislike_comment_'+key).val(parseInt($('#total_dislike_comment_'+key).val()) - 1);
            $("#tampil_total_dislike_comment_"+key).html($('#total_dislike_comment_'+key).val());
            //
            $('#total_like_comment_'+key).val(parseInt($('#total_like_comment_'+key).val()) + 1);
            $("#tampil_total_like_comment_"+key).html($('#total_like_comment_'+key).val());
            $('#like_comment_'+key).prop('title', 'Unlike');
            $('#dislike_comment_'+key).prop('title', 'Dislike');
          }else if (dataResult.statusCode == 'delete') {
            color1.style.color = '#909090';
            $('#total_like_comment_'+key).val(parseInt($('#total_like_comment_'+key).val()) - 1);
            $("#tampil_total_like_comment_"+key).html($('#total_like_comment_'+key).val());
            $('#like_comment_'+key).prop('title', 'Like');
            $('#dislike_comment_'+key).prop('title', 'Dislike');
          }else if (dataResult.statusCode == 201) {
            alert("Error occured !");
          }

        }
      });
    } else {
      alert('Please login first to continued !');

    }
  
}

function dislike_comment(key,cek){
  var color1 = document.getElementById('like_comment_'+key);
var color2 = document.getElementById('dislike_comment_'+key);
  if (cek) {
      $.ajax({
        url: "/commentDislike",
        type: "POST",
        data: {
          _token: $("#csrf").val(),
          comment_id: key
        },
        cache: false,
        success: function(dataResult) {
          console.log(dataResult);
          var dataResult = JSON.parse(dataResult);
          if (dataResult.statusCode == 'insert') {
            color1.style.color = '#909090';
            color2.style.color = color2.style.color === 'blue' ? '#909090' : 'blue';
            $('#total_dislike_comment_'+key).val(parseInt($('#total_dislike_comment_'+key).val()) + 1);
            $("#tampil_total_dislike_comment_"+key).html($('#total_dislike_comment_'+key).val());
            $('#like_comment_'+key).prop('title', 'Like');
            $('#dislike_comment_'+key).prop('title', 'Remove Dislike');
          } else if (dataResult.statusCode == 'update') {
            color1.style.color = '#909090';
            color2.style.color = color2.style.color === 'blue' ? '#909090' : 'blue';
            //Kurangi yang Like
            $('#total_like_comment_'+key).val(parseInt($('#total_like_comment_'+key).val()- 1));
            $("#tampil_total_like_comment_"+key).html($('#total_like_comment_'+key).val());
            //
            $('#total_dislike_comment_'+key).val(parseInt($('#total_dislike_comment_'+key).val()) + 1);
            $("#tampil_total_dislike_comment_"+key).html($('#total_dislike_comment_'+key).val());
            $('#like_comment_'+key).prop('title', 'Like');
            $('#dislike_comment_'+key).prop('title', 'Remove Dislike');
          }else if (dataResult.statusCode == 'delete') {
            color2.style.color = '#909090';
            $('#total_dislike_comment_'+key).val(parseInt($('#total_dislike_comment_'+key).val()) - 1);
            $("#tampil_total_dislike_comment_"+key).html($('#total_dislike_comment_'+key).val());
            $('#like_comment_'+key).prop('title', 'Like');
            $('#dislike_comment_'+key).prop('title', 'Dislike');
          }else if (dataResult.statusCode == 201) {
            alert("Error occured !");
          }
        }
      });
    } else {
      alert('Please login first to continued !');
    }
 
}
</script>
<script>
  function buka_komen(key) {
    if (key) {
      $('#buka_komen').fadeToggle();
    } else {
      alert('Please login first to continued !');
    }
  }

  function like(key, cek) {
    if (cek) {
      $.ajax({
        url: "/articleLike",
        type: "POST",
        data: {
          _token: $("#csrf").val(),
          id_article: key
        },
        cache: false,
        success: function(dataResult) {
          console.log(dataResult);
          var dataResult = JSON.parse(dataResult);
          if (dataResult.statusCode == 200) {
            $(".like").hide();
            $(".unlike").show();
            $('#total_likes').val(parseInt($('#total_likes').val()) + 1);
            $("#tampil_likes").html($('#total_likes').val());

          } else if (dataResult.statusCode == 201) {
            alert("Error occured !");
          }

        }
      });
    } else {
      alert('Please login first to continued !');

    }
  }

  function unlike(key) {
    $.ajax({
      url: "/articleUnlike",
      type: "POST",
      data: {
        _token: $("#csrf").val(),
        id_article: key
      },
      cache: false,
      success: function(dataResult) {
        console.log(dataResult);
        var dataResult = JSON.parse(dataResult);
        if (dataResult.statusCode == 200) {
          $('#total_likes').val(parseInt($('#total_likes').val()) - 1);
          $("#tampil_likes").html($('#total_likes').val());
          $(".unlike").hide();
          $(".like").show();

        } else if (dataResult.statusCode == 201) {
          alert("Error occured !");
        }

      }
    });
  };

  function delet(key, evt) {
    $('#deletemodal').modal('show');
    $('#idcomment').val(key);
    evt.preventDefault();
  };
</script>
<script type="text/javascript">
  <?php for ($i = 1; $i < $total; $i++) {
    for ($j = 1; $j <= $i; $j++) { ?>
  $(".edit_<?php echo $i ?>_<?php echo $j ?>").click(function(evt)
  {
  $(".edit_komen_<?php echo $i ?>_<?php echo $j ?>").show("slow");
  $(".cancel_komen_<?php echo $i ?>_<?php echo $j ?>").show("slow");
  $("#komen_<?php echo $i ?>_<?php echo $j ?>").hide();
  evt.preventDefault();
  });
  $(".cancel_komen_<?php echo $i ?>_<?php echo $j ?>").click(function(evt)
  {
  $(".edit_komen_<?php echo $i ?>_<?php echo $j ?>").hide();
  $(".cancel_komen_<?php echo $i ?>_<?php echo $j ?>").hide();
  $("#komen_<?php echo $i ?>_<?php echo $j ?>").show();
  evt.preventDefault();
  });
  <?php } ?>
  $(".edit_<?php echo $i ?>").click(function(evt)
  {
  $(".edit_komen_<?php echo $i ?>").show("slow");
  $(".reply_komen_<?php echo $i ?>").hide();
  $(".cancel_reply_komen_<?php echo $i ?>").hide();
  $(".cancel_komen_<?php echo $i ?>").show("slow");
  $("#komen_<?php echo $i ?>").hide();
  evt.preventDefault();
  });
  $(".cancel_komen_<?php echo $i ?>").click(function(evt)
  {
  $(".edit_komen_<?php echo $i ?>").hide();
  $(".cancel_komen_<?php echo $i ?>").hide();
  $("#komen_<?php echo $i ?>").show();
  evt.preventDefault();
  });
  $(".reply_<?php echo $i ?>").click(function(evt)
  {
  $(".reply_komen_<?php echo $i ?>").show("slow");
  $(".edit_komen_<?php echo $i ?>").hide();
  $(".cancel_komen_<?php echo $i ?>").hide();
  $("#komen_<?php echo $i ?>").show();
  $(".cancel_reply_komen_<?php echo $i ?>").show("slow");
  evt.preventDefault();
  });
  $(".cancel_reply_komen_<?php echo $i ?>").click(function(evt)
  {
  $(".reply_komen_<?php echo $i ?>").hide();
  $(".cancel_reply_komen_<?php echo $i ?>").hide();
  evt.preventDefault();
  });
  <?php } ?>
</script>
@endsection