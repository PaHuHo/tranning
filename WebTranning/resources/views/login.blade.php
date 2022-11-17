<!DOCTYPE html>
<html>
<title>Login</title>
<!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
<link href="{{asset('assets/css/theme.css')}}" rel="stylesheet">
<link rel="stylesheet" href="{{asset('assets/plugins/fontawesome-free/css/all.min.css')}}">

<div class="container">
    <div class="box">
        <form method="Post" action="{{route('store-login')}}">
            @csrf
            <div class="row">
                <div class="input-group flex-nowrap">
                    <span class="input-group-text" id="addon-wrapping"><i class="fa fa-user " aria-hidden="true"></i></span>
                    <input type="text" class="form-control" name="email" placeholder="Email" aria-label="Username" aria-describedby="addon-wrapping">

                </div>
                @error('email')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <br>
            <div class="row">
                <div class="input-group flex-nowrap">
                    <span class="input-group-text" id="addon-wrapping"><i class="fa fa-lock " aria-hidden="true"></i></span>
                    <input type="password" class="form-control" name="password" placeholder="Password" aria-label="Username" aria-describedby="addon-wrapping">
                </div>
                @if($fail)
                <div class="text-danger">Mật khẩu không chính xác</div>
                @endif

                @error('password')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- <div class="form-group">
                <label for="inputPassword">Password</label>
                <input type="password" class="form-control" placeholder="Password" name="password">
                @if($fail)
                <div class="text-danger">Mật khẩu không chính xác</div>
                @endif

                @error('password')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div> -->
            <br>
            <div class="row">
                <div class="col">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="rememberCheck" value="1">
                        <label class="form-check-label">Remember me</label>
                    </div>
                </div>
                <div class="col-sm-4">
                    <button type="submit" class="btn btn-primary" style="margin-left: 13px;">Đăng nhập</button>
                </div>
            </div>

        </form>
    </div>

</div>

</html>