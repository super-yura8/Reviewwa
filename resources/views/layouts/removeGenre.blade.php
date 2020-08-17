@extends('layouts.master')
@section('table')
    <form action="{{route('admin.removeGenres')}}" method="post" class="row" id="deleteGenre"
          xmlns="http://www.w3.org/1999/html">
        @csrf
        <div class="col-12 form-check form-group">
            @foreach($genres as $genre)
                <span class="delGenre"><label for="">{{$genre->name}}</label>
                    <input type="checkbox" name="genres[]" value="{{$genre->id}}">{{$loop->last ? '' : ','}}</span>
            @endforeach
        </div>
        <div class="col form-group">
            <button class="btn btn-danger" type="submit">Удалить</button>
        </div>
    </form>
@endsection


