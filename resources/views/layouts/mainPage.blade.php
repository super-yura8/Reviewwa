@extends('template')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8" id="big-content">
                <div class=" mt-2 mb-2 pt-2 pb-2">
                    <nav class="navbar bg-info">
                <span class="list-link">
                    <a href="/new" class="text-white">Новые</a>
                    <a href="/best" class="text-white">Лучшие</a>
                    <a href="/" class="text-white">Популярные</a>
                    @if(auth()->check())
                        <a href="/tracked" class="text-white">Отслеживаемые</a>
                    @endif
                </span>
                        <a id="show-filter" href="#filter-modal">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                 version="1.1" id="Capa_1" x="0px" y="0px" width="24" height="24" viewBox="0 0 459 459"
                                 style="enable-background:new 0 0 459 459;" xml:space="preserve">
<g>
    <g id="filter">
        <path d="M178.5,382.5h102v-51h-102V382.5z M0,76.5v51h459v-51H0z M76.5,255h306v-51h-306V255z"/>
    </g>
</g>
</svg>
                        </a>
                    </nav>
                </div>
                <div class=" mb-2 pb-2" id="filter-modal" style="display: none">
                    <div class="card">
                        <nav class="navbar-nav">
                            @if(strpos(request()->path(), 'best') !== false)
                                <div class="col-3 bg-gray-light border">
                                    <form action="" class="list-group-horizontal">
                                        <ul class="nav list-group">
                                            <li>
                                                <input type="radio" name="period" value="" class="best-radio" {{ request()->path() == 'best' ? 'checked' : ''}}>
                                                <label class="mb-0" for="">
                                                    за день
                                                </label>
                                            </li>
                                            <li>
                                                <input type="radio" name="period" value="week" class="best-radio" {{ request()->path() == 'best/week' ? 'checked' : ''}}>
                                                <label class="mb-0" for="">
                                                    за неделю
                                                </label>
                                            </li>
                                            <li>
                                                <input type="radio" name="period" value="mouth" class="best-radio" {{ request()->path() == 'best/mouth' ? 'checked' : ''}}>
                                                <label class="mb-0" for="">
                                                    за месяц
                                                </label>
                                            </li>
                                            <li>
                                                <input type="radio" name="period" value="year" class="best-radio" {{ request()->path() == 'best/year' ? 'checked' : ''}}>
                                                <label class="mb-0" for="">
                                                    за год
                                                </label>
                                            </li>
                                            <li>
                                                <input type="radio" name="period" value="all" class="best-radio" {{ request()->path() == 'best/all' ? 'checked' : ''}}>
                                                <label class="mb-0" for="">
                                                    за все время
                                                </label>
                                            </li>
                                        </ul>
                                    </form>
                                </div>
                            @endif
                            тут должны быть категории
                        </nav>
                    </div>

                </div>
                @include('inc.post')
                @if($reviews->isNotEmpty() && $reviews->total()>10)
                    @if(isset(request()->all()['find']))
                        <a id="show-more-rew" class="infinite-more-link w-100 btn btn-light" href="?find={{ request()->all()['find'] }}&page=2">More</a>
                    @else
                        <a id="show-more-rew" class="infinite-more-link w-100 btn btn-light" href="?page=2">More</a>
                    @endif
                @endif
            </div>
            @include('inc.sidebar')
        </div>
    </div>

@endsection
