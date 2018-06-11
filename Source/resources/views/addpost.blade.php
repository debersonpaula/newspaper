@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Adding Post</div>

                <div class="panel-body">
                    <form action="/article" method="POST" enctype="multipart/form-data">
                         {{ csrf_field() }}
                        <div class="form-group">
                            <label for="artTitle">Title:</label>
                            <input type="text" class="form-control" id="artTitle" placeholder="Title of your post" name="artTitle" required>
                        </div>
                        <div class="form-group">
                            <label for="artText">Article Text:</label>
                            <textarea type="file" class="form-control" id="artText" name="artText" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="artPhoto">Image:</label>
                            <input type="file" class="form-control" id="artPhoto" name="artPhoto" required accept=".jpg,.gif,.png,
                            image/jpeg,image/gif,image/png">
                        </div>
                        <button type="submit" class="btn btn-default">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
