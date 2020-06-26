@extends('layouts.master')
@section('table')
    <table class="table">
        <tr>
            <th>id</th>
            <th>Заголовок</th>
            <th>Пользователь</th>
            <th>лайки</th>
            <th>просмотры</th>
            <th>комментарии</th>
            <th>дата создания</th>
        </tr>
        @foreach($reviews as $review)
            <tr>
                <td>{{ $review->id }}</td>
                <td>{{ $review->title }}</td>
                <td>{{ $review->user->name }}</td>
                <td></td>
                <td></td>
                <td></td>
                <td>{{ date('d-m-Y', strtotime($review->created_at))}}</td>
            </tr>
        @endforeach
    </table>
@endsection
