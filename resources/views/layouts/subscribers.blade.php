@if(isset($users[0]))
<div id="subs">
    @foreach($users as $nUser)
        <div class="pl-3 pt-2 pr-2 pb-2 w-100 border mb-2">
            <h4 class="text-primary">{{ $nUser->name }}</h4>
            <p class="text-right m-0"><a href="/user/{{ $nUser->id }}" class="btn btn-primary"><i class="far fa-user"></i>View Profile</a></p>
        </div>
    @endforeach
</div>
@if($count>10)
    <a href="#" id="showMoreUsers" data-type="{{ $type }}" class="w-100 btn btn-light">Показать еще</a>
@endif
@endif
