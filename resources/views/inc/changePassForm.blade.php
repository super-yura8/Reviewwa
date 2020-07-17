<form action="/user/changePass" id="changePass">
    @csrf
    <input type="hidden" value="{{ auth()->id() }}">
    <div class="form-group">
        <label for="">Оригинальный пароль</label>
        <input type="password" class="form-control" name="originPass" placeholder="Пароль">
    </div>
    <div class="form-group">
        <label for="">Пароль</label>
        <input type="password" class="form-control" name="pass" placeholder="Пароль">
    </div>
    <div class="form-group">
        <label for="">Повторите пароль</label>
        <input type="password" class="form-control" name="passAgg" placeholder="Пароль">
    </div>
    <a href="#" class="btn btn-primary" id="changePassBtn">Submit</a>
</form>
