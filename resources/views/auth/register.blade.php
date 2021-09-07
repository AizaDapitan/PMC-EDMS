@extends('layouts.login')

@section('content')

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <h3>Sign Up</h3>
        <p> Enter your account details below: </p>

        <div class="form-group @error('name') has-error @enderror">
            <label class="control-label visible-ie8 visible-ie9">Full Name</label>
            <div class="input-icon">
                <i class="fa fa-font"></i>
                <input class="form-control placeholder-no-fix" type="text" placeholder="Full Name" name="name" 
                    value="{{ old('name') }}" autofocus />
            </div>
            @error('name')
                <span for="name" class="help-block">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group @error('email') has-error @enderror">
            <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
            <label class="control-label visible-ie8 visible-ie9">Email</label>
            <div class="input-icon">
                <i class="fa fa-envelope"></i>
                <input class="form-control placeholder-no-fix" type="text" placeholder="Email" name="email" 
                    value="{{ old('email') }}" />
            </div>
            @error('email')
                <span for="email" class="help-block">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group @error('username') has-error @enderror">
            <label class="control-label visible-ie8 visible-ie9">Username</label>
            <div class="input-icon">
                <i class="fa fa-user"></i>
                <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Username" 
                name="username" value="{{ old('username') }}" />
            </div>
            @error('username')
                <span for="username" class="help-block">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group @error('password') has-error @enderror">
            <label class="control-label visible-ie8 visible-ie9">Password</label>
            <div class="input-icon">
                <i class="fa fa-lock"></i>
                <input class="form-control placeholder-no-fix" type="password" autocomplete="off" id="register_password" placeholder="Password" name="password" />
            </div>
            @error('password')
                <span for="password" class="help-block">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group @error('password_confirmation') has-error @enderror">
            <label class="control-label visible-ie8 visible-ie9">Re-type Your Password</label>
            <div class="controls">
                <div class="input-icon">
                    <i class="fa fa-check"></i>
                    <input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="Confirm Password" 
                     name="password_confirmation"/>
                </div>
            </div>
            @error('password_confirmation')
                <span for="password_confirmation" class="help-block">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-actions">
            <a href="/login" id="register-back-btn" class="btn default">
            <i class="m-icon-swapleft"></i> Back </a>
            <button type="submit" id="register-submit-btn" class="btn green pull-right">
            Sign Up <i class="m-icon-swapright m-icon-white"></i>
            </button>
        </div>

    </form>

@endsection
