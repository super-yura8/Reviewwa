@extends('template')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class=" mt-2 mb-2 pt-2 pb-2">
                    <nav class="navbar bg-info">
                <span>
                    <a href="" class="text-white">Все</a>
                    <a href="" class="text-white">Отслеживаемые</a>
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
                            тут должны быть категории
                        </nav>
                    </div>

                </div>
                @include('inc.post')
            </div>
            @include('inc.sidebar')
        </div>
    </div>
    <div id="footer"></div>
@endsection
