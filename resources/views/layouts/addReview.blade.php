@extends('template')
@section('content')
    <div id="editor" class="col-md-4 m-auto">
        <textarea name="review" id="review" cols="30" rows="10"></textarea>
        <a id="subm" class="btn btn-success " href="#">Отпраить</a>
    </div>
@endsection
@section('scripts')
    <script src="https://cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>    git reset --soft HEAD^
@endsection
