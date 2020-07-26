<!-- Sidebar Widgets Column -->
<div class="col-md-4">
    <!-- Categories Widget -->
    @if(!auth()->check())
        <div id="form-auth" class="card my-3">
            <h5 class="card-header">Вход</h5>
            <div class="card-body">
                <div class="d-flex justify-content-center">
                    <a id="reg" href="#" class="change-auth">Регистрация</a>
                </div>
                <form action="/auth" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="">Email</label>
                        <input class="w-100" type="email" placeholder="Email" name="email">
                    </div>
                    <div class="form-group">
                        <label for="">Password</label>
                        <input class="w-100" type="password" placeholder="Password" name="password">
                    </div>
                    <button type="submit" class="btn btn-success loginUser">Отправить</button>
                </form>
            </div>
        </div>
        <div id="form-reg" class="card my-3 d-none">
            <h5 class="card-header">Регистрация</h5>
            <div class="card-body">
                <div class="d-flex justify-content-center">
                    <a id="auth" href="#" class="change-auth">Вход</a>
                </div>
                <form action="/reg" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="">Name</label>
                        <input class="w-100" type="text" placeholder="Name" name="name">
                    </div>
                    <div class="form-group">
                        <label for="">Email</label>
                        <input class="w-100" type="email" placeholder="Email" name="email">
                    </div>
                    <div class="form-group">
                        <label for="">Password</label>
                        <input class="w-100" type="password" placeholder="Password" name="password">
                    </div>
                    <div class="form-group">
                        <label for="">Password</label>
                        <input class="w-100" type="password" placeholder="Password again" name="password_again">
                    </div>
                    <button type="submit" class="btn btn-success loginUser">Отправить</button>
                </form>
            </div>
        </div>
    @endif
    <!-- Side Widget -->
    {{--<div class="card my-4">--}}
        {{--<h5 class="card-header">Side Widget</h5>--}}
        {{--<div class="card-body">--}}
            {{--Lorem ipsum dolor sit amet, consectetur adipisicing elit. Beatae consequatur cum dicta dolorem--}}
            {{--dolores dolorum earum error est fugit impedit libero magnam, odit officia perspiciatis placeat quam--}}
            {{--reiciendis suscipit, veniam?--}}
        {{--</div>--}}
    {{--</div>--}}
    @if(auth()->check())
    <div class="card my-4 ">
        <h5 class="card-header">Чат</h5>
        <div class="card-body">
            общий чат(не виден если пользователь не зареган)
        </div>
    </div>
    @endif
</div>
