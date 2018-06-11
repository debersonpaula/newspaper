@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            
        @foreach ($articles as $article)
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="text-left" style="float:left"><b>{{ $article->artTitle }}</b></div>
                    <div class="text-right">Posted on: {{ $article->currentTime }}</div>
                    <div class="text-right">Posted by: {{ $article->name }} / {{ $article->email }}</div>
                </div>
                <div class="panel-body">
                    <img width="100%" style="margin-bottom: 15px" src="/images/{{ $article->id }}">
                    {{ $article->artText }}
                    <div class="text-right"><a href="/article/PDF/{{ $article->id }}" target="_blank">Export to PDF</a></div>
                    <div class="text-right"><a href="/">Go back to main page</a></div>
                </div>
            </div>                    
            @endforeach

        </div>
    </div>
</div>
@endsection
