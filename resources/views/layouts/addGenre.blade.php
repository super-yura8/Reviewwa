@extends('layouts.master')
@section('table')
    <form action="{{route('admin.addGenre')}}" class="row" id="addGenre">
        @csrf
            <div class="d-block form-row ml-5">
                <input type="text" placeholder="Жанр" name="name"><button id="" class="btn btn-success ml-2">Добавить</button>
            </div>
    </form>
@endsection
