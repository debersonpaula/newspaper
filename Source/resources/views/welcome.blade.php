@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-body">Welcome to Newspaper</div>
            </div>
            @foreach ($articles as $article)
            <div class="panel panel-default">
                <div class="panel-heading">
                    <b>{{ $article->artTitle }}</b><br>
                    <small><a href="mailto:{{ $article->email }}">{{ $article->name }}</a> - {{ $article->currentTime }}</small>
                </div>
                <div class="panel-body">
                    <img width="50%" style="float:left;margin: 0 15px 15px 0" src="/images/{{ $article->id }}">
                    <?php
                        //strip the article text if the lengths is > $maxsize chars
                        //to be better visualized in the welcome page
                        $maxsize = 100;
                        $articleText = $article->artText;
                        if (strlen($articleText) > $maxsize){
                            $articleText = substr($articleText,0,$maxsize) . "...";
                        }
                        echo $articleText;
                    ?>
                    <div class="text-right"><a href="/article/{{ $article->id }}">See details</a></div>
                </div>
            </div>                    
            @endforeach
        </div>
    </div>
</div>
@endsection
