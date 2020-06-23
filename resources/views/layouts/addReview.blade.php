@extends('template')
@section('content')
    <form action="">
        <div id="editor" class="m-auto">
            <label for="">Заглавие</label>
            <input type="text" class="w-100 mb-1" name="title">
            <textarea name="review" id="review" cols="30" rows="10"></textarea>
            <a id="subm" class="btn btn-success " href="#">Отпраить</a>
        </div>
    </form>
@endsection
@section('scripts')
    <script src="https://cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
    <script>CKEDITOR.replace('review', {
            filebrowserUploadUrl: '/uploader/img/upload?_token=' + $('meta[name="csrf-token"]').attr('content'),
            filebrowserWindowWidth: 678,
            removePlugins: 'uploadimage',
            resize_maxWidth: 678,
        });</script>
@endsection
