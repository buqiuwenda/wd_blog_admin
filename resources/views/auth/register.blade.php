@extends('auth.app')

@section('content')
    <div class="middle-box text-center loginscreen animated fadeInDown">
        <div>
            <div>
                <h1 class="logo-name">WD+</h1>
            </div>
            <h3>Register to WD+</h3>
            <p>Create account to see it in action.</p>
            <form class="m-t" role="form" method="post" action="{{ route('register') }}" >
                @csrf

                <div class="form-group">
                    <input type="text" name="name" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="Username" required="" value="{{ old('name') }}" autofocus>
                    @if ($errors->has('name'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group">
                    <input type="email" name="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="Email-Address" required="" value="{{ old('email') }}" autofocus>
                    @if ($errors->has('email'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group">
                    <input type="password" name="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="Password" required="">
                    @if ($errors->has('password'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group">
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Confirm-Password" required="">
                </div>
                <div class="form-group">
                    <div class="checkbox i-checks"><label> <input type="checkbox" name="is_agree" value="1">
                            @if ($errors->has('is_agree'))
                                <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('is_agree') }}</strong>
                        </span>
                            @endif
                            <i></i> Agree the terms and policy </label></div>
                </div>
                <button type="submit" class="btn btn-primary block full-width m-b">Register</button>

                <p class="text-muted text-center"><small>Already have an account?</small></p>
                <a class="btn btn-sm btn-white btn-block" href="{{ route('login') }}">Login</a>
            </form>
            <p class="m-t"> <small>Wenda we app framework base on Bootstrap 3 &copy; 2018</small> </p>
        </div>
    </div>
@endsection
