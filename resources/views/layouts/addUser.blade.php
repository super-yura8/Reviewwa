@extends('layouts.master')
@section('table')
    <form action="{{ route('admin.add') }}" method="post" class="row" id="addUser">
        @csrf
        <div class="col-6">
            <div class="form-row">
                <div class="col">
                    <input type="text" class="form-control" placeholder="Имя" name="name">
                </div>
                <div class="col">
                    <input type="text" class="form-control" placeholder="E-mail" name="email">
                </div>
            </div>
            <div class="form-row">
                <div class="col">
                    <input type="password" class="form-control mt-2 mb-2" placeholder="Пароль" name="password">
                    <input type="password" class="form-control mb-2" placeholder="Повторите пароль"
                           name="passwordAgain">
                </div>
            </div>
            <div class="form-row">
                <div class="col">
                    <button class="btn btn-success" type="submit">Добавить</button>
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
                            <input type="checkbox" name="role[]" value="{{ $role->name }}">,
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
                            <input type="checkbox" name="permission[]" value="{{ $item->name }}">,
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
