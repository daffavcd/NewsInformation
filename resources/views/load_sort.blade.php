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
                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-three-dots-vertical"
                        fill="currentColor" xmlns="http://www.w3.org/2000/svg">
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
                    <a class="dropdown-item delet" style="cursor: pointer"
                        onclick="delet({{$item->id_comment}})">Delete</a>
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
                <input class="form-control form-control-sm edit_komen_{{$total}}"
                    style="width: 82%;display:none;float:left" type="text" name="comment" value="{{$item->comment}}">
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
                    style="width: 80%;display:none;float:left" type="text" name="comment"
                    placeholder="Reply Comment...">
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
                        <button type="button" class="btn btn-primary btn-sm " data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
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
                            style="width: 80%;display:none;float:left" type="text" name="comment"
                            value="{{$item->comment}}">
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