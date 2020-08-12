@extends('template')
@section('content')
<div class="container">
    <div class="row profile">
        <div class="col-md-3">
            <div class="profile-sidebar">
                <!-- SIDEBAR USERPIC -->
                <div class="profile-userpic">
                    @if(auth()->check() && auth()->id() == $user->id)
                    <label for="file-input" id="img" class="m-0">
                        <img class="w-100" src="{{($user->avatars->first() != null) ? '/'.$user->avatars->first()->avatar_big : 'https://image.ibb.co/jw55Ex/def_face.jpg'}}" alt="user img">
                        <div class="middle text-white">
                            Изменить картинку
                        </div>
                    </label>
                        <form enctype="multipart/form-data">
                            @csrf
                            <input type="file" id="file-input" class="img-responsive" name="upload" alt="user img">
                        </form>
                        @else
                        <img class="w-100" src="{{($user->avatars->first() != null) ? '/'.$user->avatars->first()->avatar_big : 'https://image.ibb.co/jw55Ex/def_face.jpg'}}" alt="user img">
                    @endif
                </div>
                <!-- END SIDEBAR USERPIC -->
                <!-- SIDEBAR USER TITLE -->
                <div class="profile-usertitle">
                    <div class="profile-usertitle-name">
                        {{ $user->name }}
                    </div>
                </div>
                <!-- END SIDEBAR USER TITLE -->
                <!-- SIDEBAR BUTTONS -->
                <div class="profile-userbuttons">
                    @if(auth()->check() && auth()->id() != $user->id)
                        @if(!auth()->user()->follows->where('id', $user->id)->first())
                            <a id="subscribe-on-user" data-id="{{ $user->id }}" href="/subscribe/user/{{ $user->id }}" class="btn btn-success btn-sm">Подписаться</a>
                        @else
                            <a id="subscribe-on-user" href="/unsubscribe/user/{{ $user->id }}" class="btn btn-danger btn-sm">Отписаться</a>
                        @endif
                    @endif
                </div>
                <!-- END SIDEBAR BUTTONS -->
                <!-- SIDEBAR MENU -->
                <div class="profile-usermenu">
                    <ul class="nav list-group user-func-list">
                        <li class="active">
                            <a href="user/profile/reviews/{{ $user->id }}">
                                <i class="glyphicon glyphicon-home"></i>
                                Обзоры </a>
                        </li>
                            @if(auth()->check() && auth()->id() == $user->id)
                            <li>
                                <a href="user/changePassForm">
                                    <i class="glyphicon glyphicon-user"></i>
                                    Сменить пароль
                                </a>
                            </li>
                        @endif
                        <li>
                            <a href="user/{{ $user->id }}/follower" target="_blank">
                                <i class="glyphicon glyphicon-ok"></i>
                                Подпищики </a>
                        </li>
                        <li>
                            <a href="user/{{ $user->id }}/subscriptions">
                                <i class="glyphicon glyphicon-flag"></i>
                                Подписки </a>
                        </li>
                    </ul>
                </div>
                <!-- END MENU -->
            </div>
        </div>
        <div class="col-md-9">
            <div class="profile-content" id="user-func-content">
                    @include('inc.post')
                    @if($reviews->nextPageUrl())
                        <a href="{{ $reviews->nextPageUrl()}}" id="showMoreReviews" class="w-100 btn btn-light">Показать еще</a>
                    @endif
            </div>
        </div>
    </div>
</div>
@endsection
