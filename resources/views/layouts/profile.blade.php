@extends('template')
@section('content')
<div class="container">
    <div class="row profile">
        <div class="col-md-3">
            <div class="profile-sidebar">
                <!-- SIDEBAR USERPIC -->
                <div class="profile-userpic">
                    <img src="http://keenthemes.com/preview/metronic/theme/assets/admin/pages/media/profile/profile_user.jpg" class="img-responsive" alt="user img">
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
                        @if(!auth()->user()->subscribers->where('subscriber_id', $user->id)->first())
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
