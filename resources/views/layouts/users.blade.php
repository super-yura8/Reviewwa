@extends('layouts.master')
@section('table')
    <table class="table">
        <tr>
            <th>id</th>
            <th>пользователь</th>
            <th>e-mail</th>
            <th>обзоры</th>
            <th>подписчики</th>
            <th>дата регистрации</th>
            <th>действие</th>
        </tr>
        @foreach($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td></td>
                <td></td>
                <td>{{ $user->created_at }}</td>
                <td>
                    @if($user->is_ban)
                        <a class="btn btn-success text-white" href="#">Разбанить</a>
                    @else
                        <a class="btn btn-danger text-white" href="{{ route('admin.banUser',$user->id) }}">Забанить</a>
                    @endif
                    <a class="btn btn-success text-white">Изменить</a>
                </td>
            </tr>
        @endforeach
    </table>
@endsection
