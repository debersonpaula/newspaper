@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">My Dashboard</div>
                <div class="panel-body">
                    <p>You can read, delete or create all your posts in your dashboard. All your post will appear in the list below</p>
                    @if (Auth::user()->activated)
                        <p>To create new post, <a href="addpost">click here</a></p>
                    @else
                        <p>To create new post, please activate your account first.</p>
                    @endif
                </div>
            </div>
            @foreach ($articles as $article)
            <div class="panel panel-default">
                <div class="panel-heading">
                    <b>{{ $article->artTitle }}</b><br>
                    <small><a href="mailto:{{ $article->email }}">{{ $article->name }}</a> - {{ $article->currentTime }}</small>
                    <div class="text-right">
                        <form action="/article" method="POST">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <input type="hidden" name="id" value="{{ $article->id }}">
                            <button type="submit" class="btn btn-default">Remove this post</button>
                        </form>
                    </div>
                </div>
                <div class="panel-body">
                    <img width="50%" style="float:left;margin: 0 15px 15px 0" src="/images/{{ $article->id }}">
                    {{ $article->artText }}
                </div>
            </div>                    
            @endforeach
        </div>
    </div>
</div>
@endsection
