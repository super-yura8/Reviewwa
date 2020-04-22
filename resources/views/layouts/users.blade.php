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
        </tr>
        @foreach($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td></td>
                <td></td>
                <td>{{ $user->created_at }}</td>
            </tr>
        @endforeach
    </table>
@endsection
