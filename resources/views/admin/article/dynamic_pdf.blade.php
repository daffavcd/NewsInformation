<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Laravel - How to Generate Dynamic PDF from HTML using DomPDF</title>
    <style type="text/css">
        hr {
            margin-top: 1rem;
            margin-bottom: 1rem;
            border: 0;
            border-top: 1px solid rgba(0, 0, 0, 0.1);
            box-sizing: content-box;
            height: 0;
            overflow: visible;
        }

        body {
            margin: 0;
            font-family: "Nunito", sans-serif;
            font-size: 0.9rem;
            font-weight: 400;
            line-height: 1.6;
            color: #212529;
            text-align: left;
        }

        .rounded {
            border-radius: 0.25rem !important;
        }

        .img-fluid {
            max-width: 100%;
            height: auto;
        }

        .lead {
            font-size: 1.125rem;
            font-weight: 300;
        }

        .badge-light {
            color: #212529;
            background-color: #f8f9fa;
        }

        .badge {
            padding: 0.25em 0.4em;
            font-size: 75%;
            font-weight: 700;
            line-height: 1;
            text-align: center;
            white-space: nowrap;
            vertical-align: baseline;
            border-radius: 0.25rem;
            transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        h1,
        .h1 {
            font-size: 2.25rem;
        }
    </style>
</head>

<body>
    <div style="text-align: center;">

        <!-- Title -->
        <h1 class="mt-8">{{ $article->title}}</h1>

        <!-- Author -->
        <p class="lead">
            by
            <a href="#" id="target">{{$article->admin_name}}</a>
        </p>

        <hr>

        <!-- Date/Time -->
        <h5>{{ $article->category_name}}</h5>
        <p>Posted on {{ $article->created_at}}</p>

        <hr>

        <!-- Preview Image -->
        <img class="img-fluid rounded" src="{{ public_path('images/'.$article->featured_image) }}" alt="">

        <hr>

        <!-- Post Content -->
        <p class="lead">{{ $article->content}}</p>

        <hr>
        <?php
        $jumlah_like = App\Like::select(DB::raw('count(*) as jumlah_likes'))->where('id_article', $article->id_article)->first();
        $jumlah_comment = App\Comment::select(DB::raw('count(*) as jumlah'))->where('id_article', $article->id_article)->first()
        ?>
        <img class="like" style="width: 2.5%;cursor: pointer;" src="{{ public_path('images/hatipolos.png') }}" alt="">
        <span class="badge badge-light" id="tampil_likes">{{$jumlah_like->jumlah_likes}}</span>
        <img style="width: 2.5%; ?>" src="{{ public_path('images/speech-bubble.png') }}" alt="">
        <span class="badge badge-light">{{$jumlah_comment->jumlah}}</span>
    </div>
</body>

</html>