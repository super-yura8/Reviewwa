@extends('layouts.master')
@section('table')
    <table class="table">
        <tr>
            <th>id</th>
            <th>Заголовок</th>
            <th>Пользователь</th>
            <th>лайки</th>
            <th>комментарии</th>
            <th>дата создания</th>
        </tr>
        @foreach($reviews as $review)
            <tr>
                <td>{{ $review->id }}</td>
                <td><a href="/Reviews/{{ $review->id }}">{{ $review->title }}</a></td>
                <td>{{ $review->user->name }}</td>
                <td>{{ $review->likes()->where('like', 1)->count() }}</td>
                <td>{{ $review->comments()->count() }}</td>
                <td>{{ date('d-m-Y', strtotime($review->created_at))}}</td>
            </tr>
        @endforeach
    </table>
@endsection
