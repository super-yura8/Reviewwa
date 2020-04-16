@extends('layouts.master')
@section('table')
    <form action="" class="row">
        <div class="col-6">
            <div class="form-row">
                <div class="col">
                    <input type="text" class="form-control" placeholder="Имя">
                </div>
                <div class="col">
                    <input type="text" class="form-control" placeholder="E-mail">
                </div>
            </div>
            <div class="form-row">
                <div class="col">
                    <input type="password" class="form-control mt-2 mb-2" placeholder="Пароль">
                    <input type="password" class="form-control mb-2" placeholder="Повторите пароль">
                </div>
            </div>
            <div class="form-row">
                <div class="col">
                    <button class="btn btn-success">Добавить</button>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="form-row">
                <h4>Роли: </h4>
                <div class="col form-check">
                    @foreach(App\Models\Roles::all('name') as $role)
                        @if($role->name != 'super-admin')
                            <label for="">{{ $role->name }}</label>
                            <input type="checkbox" name="role" value="{{ $role->name }}">,
                        @endif
                    @endforeach
                </div>
            </div>
            <div>
                <div class="form-row">
                    <h4>Права: </h4>
                    <div class="col form-check">
                        @foreach(\App\Models\Permissions::all('name') as $item)
                            <label for="">{{ $item->name }}</label>
                            <input type="checkbox" name="permission" value="{{ $item->name }}">,
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
