<div id="content">
    @foreach($reviews as $review)
        <div id="{{ $review->id }}" class="card mb-4 post">
            <div class="card-body post-content">
                <h2 class="card-title">{{ $review->title }}</h2>
                <p class="card-text">
                    {!! $review->content !!}
                    <span style="display: none"></span>
                </p>
            </div>
            <div class="card-body open-all">
            </div>
            <div class="card-footer text-muted footer">
                <p class="float-left m-0">
                    дата публикации: {{ date('d-m-Y', strtotime($review->created_at)) }}
                </p>
                <p class="float-left ml-1 mr-1 mb-0 like-count">{{ $review->likes->where('like', true)->count() }}</p>
                <p class="float-left ml-1 mr-1 mb-0 like">
                    @if($review->likes->where('like', 1)->where('user_id', auth()->id())->first())
                        <i font class="fa fa-heart" style="font-size: 1.4em;"></i>
                    @else
                        <i font class="far fa-heart" style="font-size: 1.4em;"></i>
                    @endif
                </p>
                <p class="float-left ml-1 mr-1 mb-0">
                    цифра
                </p>
                <p class="float-left ml-1 mr-1 mb-0">
                    <i class="far fa-comment-alt" style="font-size: 1.4em;"></i>
                </p>
                <p class="float-right ml-1 mr-1 mb-0">{{ $review->user->name }}</p> {{--также надо добавить иконку--}}
            </div>
        </div>
    @endforeach

</div>
<div class="bottom" style="height: 3px"></div>
