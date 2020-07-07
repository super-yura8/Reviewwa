@extends('template')
@section('content')
    <form action="">
        <div id="editor" class="m-auto">
            <label for="">Заглавие</label>
            @if(isset($data))
                <input type="hidden" value="{{$data['id']}}" name="id">
            @endif
            <input type="text" class="w-100 mb-1" name="title" value="@if(isset($data)) {{ $data['title'] }} @endif">
            <textarea name="review" id="review" cols="30" rows="10">@if(isset($data)) {!! $data['content'] !!} @endif</textarea>
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
