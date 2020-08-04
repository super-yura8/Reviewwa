<div id="content" data-more="{{$reviews->total()>10 ? 'true' : 'false'}}">
    @foreach($reviews as $review)
        <div id="{{ $review->id }}" class="card mb-4 post">
            <div class="card-body post-content">
                <h2 class="card-title">{{ $review->title }}</h2>
                <div class="card-text">
                    {!! $review->content !!}
                </div>
            </div>
            <div class="card-body open-all"></div>
            <div class="card-body pt-0">@foreach($review->genres as $genre)<a>{{$genre->name}} </a>@endforeach</div>
            <div class="card-footer text-muted footer">
                <p class="float-left m-0">
                    дата публикации: {{ date('j-m-Y', strtotime($review->created_at)) }}
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
                    {{ $review->comments()->count() }}
                </p>
                <p class="float-left ml-1 mr-1 mb-0">
                    <a href="/Reviews/{{ $review->id }}" class="far fa-comment-alt" style="font-size: 1.4em; text-decoration: none;"></a>
                </p>
                @if(auth()->check())
                    @if($review->user->id == auth()->id() || auth()->user()->hasPermissionTo('unpublish review'))
                        <p class="float-right ml-1 mr-1 mb-0 del-review">
                            <i class="fas fa-trash"></i>
                        </p>
                    @endif
                        @if($review->user->id == auth()->id() || auth()->user()->hasPermissionTo('edit reviews'))
                            <p class="float-right ml-1 mr-1 mb-0">
                                <a href="#" class="edit-review">изменить</a>
                            </p>
                        @endif

                @endif
                <a href="/user/{{$review->user->id}}" class="float-right ml-1 mr-1 mb-0">{{ $review->user->name }}
                    @if($review->user->avatars != null)<img
                        src="{{$review->user->avatars->first()->avatar_small}}" alt="" class="ml-1">
                    @endif
                </a>{{--также надо добавить иконку--}}

            </div>
        </div>
    @endforeach

    @if(isset($comments))
        <div class="card mb-4">
            <div class="card-body">
                <h2 class="card-title">Коментарии</h2>
                <p class="card-text">
                <div id="comments" class="box-footer box-comments">
                    @foreach($comments as $comment)
                        <div data-id="{{ $comment->id }}" class="box-comment border-bottom bg-gray-light">
                            <!-- User image -->
                            <span >
                                <img class=" img-comment img-circle img-sm" src="../dist/img/user3-128x128.jpg" alt="User Image" style="width: 50px">
                                @if(auth()->check())
                                    <div class="float-right">
                                    @if($comment->user_id === auth()->user()->id || auth()->user()->hasPermissionTo('unpublish comment'))

                                            <div>
                                            <li class="del-comment float-right fas fa-trash"></li>
                                            </div>
                                            @endif
                                            @if($comment->user_id === auth()->user()->id || auth()->user()->hasPermissionTo('edit comments'))
                                            <div>
                                                <a class="float-right edit-comment">изменить</a>
                                            </div>

                                            @endif
                        </div>
                                @endif
                                <p class="mb-1">{{ $comment->user->name }}
                                    <span class="text-muted pull-right">{{ date('j-m-Y', strtotime($comment->created_at)) }}</span>
                                </p>
                            </span>
                            <div class="comment-text">{!! $comment->content !!}</div>
                            <!-- /.comment-text -->
                        </div>
                        <!-- /.box-comment -->
                    @endforeach
                    <!-- /.box-comment -->
                </div>
                </p>
                @if($count>20)
                    <a href="#" id="more" class="w-100 btn btn-light">Показать еще</a>
                @endif
            </div>
            <div class="card-body open-all bg-gray-light">
                <form id="comment-form">
                    <textarea class="textarea" ></textarea>
                </form>
            </div>
            <div class="card-footer text-muted footer">
                <a href="../comment" class="btn btn-success" id="send-comment">Отправить</a>
            </div>
        </div>
<div style="display: none;" id="edit-form">
    <form>
        <input name="id" type="hidden">
        <div>
            <textarea name="content" id="" cols="30" rows="10"></textarea>
        </div>

        <a href="#" id="edit-btn" class="btn btn-success">Изменить</a>
    </form>
</div>
    @endif
</div>

