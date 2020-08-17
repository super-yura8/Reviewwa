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
                <td class="user-id" data-id="{{ $user->id }}">{{ $user->id }}</td>
                <td class="user-name">{{ $user->name }}</td>
                <td class="user-email">{{ $user->email }}</td>
                <td class="user-reviews">{{ $user->reviews()->count() }}</td>
                <td>{{ $user->subscribers->count() }}</td>
                <td>{{ $user->created_at }}</td>
                <td>
                    <div></div>
                    @if($user->is_ban)
                        <a class="unbanBtn btn btn-success text-white" href="#"></a>
                    @else
                        <a data-fancybox="" data-src="#banForm" data-modal="true" href="#" class="banBtn btn btn-danger text-white"></a>
                    @endif
                    <a data-fancybox="" data-src="#changeForm" data-modal="true" href="#" class="changeBtn btn btn-success text-white">Изменить</a>
                </td>
            </tr>
        @endforeach
    </table>
    <div style="display: none;" id="banForm">
        <h2>Заблокировать позьзователя</h2>
        <form action="{{ route('admin.banUser') }}" method="post">
            @csrf
            <input type="hidden" name="id">
            <label class="mr-1">Заблокировать до </label>
            <input type="date" id="date" name="date">
            <div class="form-row">
                <button type="submit" class="btn btn-danger datepicker">заблокировать</button>
            </div>
            <button type="button" data-fancybox-close="" class="fancybox-button fancybox-close-small" title="Close">
                <svg xmlns="http://www.w3.org/2000/svg" version="1" viewBox="0 0 24 24">
                    <path d="M13 12l5-5-1-1-5 5-5-5-1 1 5 5-5 5 1 1 5-5 5 5 1-1z"></path>
                </svg>
            </button>
        </form>
    </div>

        <div style="display: none;" id="changeForm">
        <h2>Изменить пользователя</h2>
        <form method="post">
            @csrf
            @method('put')
            <div class="form-row mb-1">
                <input type="text" name="name">
                <label for="">Имя</label>
            </div>
            <div class="form-row mb-1">
                <input type="email" name="email">
                <label for="">E-mail</label>
            </div>
            <input type="hidden" name="id">

            <div class="form-row">
                <button type="submit" class="btn btn-info text-white">Изменить</button>
            </div>
            <button type="button" data-fancybox-close="" class="fancybox-button fancybox-close-small" title="Close">
                <svg xmlns="http://www.w3.org/2000/svg" version="1" viewBox="0 0 24 24">
                    <path d="M13 12l5-5-1-1-5 5-5-5-1 1 5 5-5 5 1 1 5-5 5 5 1-1z"></path>
                </svg>
            </button>
        </form>
    </div>
@endsection
