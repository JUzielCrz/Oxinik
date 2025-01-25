@extends('layouts.app')

@section('content')

<style>
    .container-login {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
        background: #2F4858
    }
    .card{
        width: 25rem;
    }
    .card-body{
        background: #329F5B;
        color: #fff;
    }
</style>

{{-- <div id="app"> --}}

    <main class="container-login">
        <div class="card">
            {{-- <div class="card-header bg-morado">{{ __('Login') }}</div> --}}

            <div class="card-body">
                <div class="row">
                    <div class="col mt-5 mb-4 text-center" >
                        <img src="img/logo-gris.jpg" width="250px" alt="" >
                    </div>
                </div>
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="form-group row">
                        <div class="col">
                            <label for="email">{{ __('E-Mail Address') }}</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col">
                            <label for="password">{{ __('Password') }}</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col text-center">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                <label class="form-check-label" for="remember">
                                    {{ __('Remember Me') }}
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col text-center">
                            <button type="submit" class="btn btn-block btn-gris">
                                {{ __('Login') }}
                            </button>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col text-right ">
                            @if (Route::has('password.request'))
                                <a class="btn btn-link text-white" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>




    </main>
{{-- </div> --}}









@endsection
