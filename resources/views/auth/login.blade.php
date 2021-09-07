@extends('layouts.login')

@section('content')

    <form method="POST" action="{{ route('login') }}" class="login-form">
        @csrf

        <h3 class="form-title">
            <strong>Login to your domain</strong>
        </h3>

        <div class="form-group @error('username') has-error @enderror">

            <div class="input-icon">
                <i class="fa fa-user"></i>
                <input class="form-control placeholder-no-fix" type="text" 
                    autocomplete="off" placeholder="Username" name="username" required
                    value="{{ old('username') }}" autofocus />
            </div>
            
            @error('username')
                <span for="username" class="help-block">{{ $message }}</span>
            @enderror

        </div>

        <div class="form-group">

            <div class="input-icon">
                <i class="fa fa-lock"></i>
                <input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="Password" name="password" required="required" />
            </div>

            @error('password')
                <span for="password" class="help-block">{{ $message }}</span>
            @enderror

        </div>

        <div class="form-actions">

            <div class="form-actions">

                <button type="submit" class="btn green pull-right">
                    Login <i class="m-icon-swapright m-icon-white"></i>
                </button>
                
            </div>

        </div>
        
    </form>

@endsection
