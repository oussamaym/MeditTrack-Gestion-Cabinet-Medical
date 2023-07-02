@extends(backpack_view('layouts.plain'))

@section('content')
<!doctype html>
<html lang="en">
  <head>
    <title>Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">

    <!-- Include your custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  </head>
  <body class="img js-fullheight" style="background-image: url({{ asset('images/bg.jpg') }});">
    <section class="ftco-section">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-md-6 text-center mb-5">
            <h2 class="heading-section">{{ trans('backpack::base.login') }}</h2>
          </div>
        </div>
        <div class="row justify-content-center">
          <div class="col-md-6 col-lg-4">
            <div class="login-wrap p-0">
              <!--<h3 class="mb-4 text-center">{{ trans('backpack::base.have_account') }}</h3>-->
              <form class="signin-form" role="form" method="POST" action="{{ route('backpack.auth.login') }}">
                {!! csrf_field() !!}
                <div class="form-group">
                <div>
                    <input type="text" class="form-control{{ $errors->has($username) ? ' is-invalid' : '' }}" placeholder="{{ config('backpack.base.authentication_column_name') }}" name="{{ $username }}" value="{{ old($username) }}" id="{{ $username }}">

                        @if ($errors->has($username))
                            <span class="invalid-feedback">
                                    <strong>{{ $errors->first($username) }}</strong>
                            </span>
                        @endif
                </div>
                 <!-- <input type="text" class="form-control" placeholder="{{ trans('backpack::base.username') }}" name="{{ $username }}" value="{{ old($username) }}" id="{{ $username }}" required>-->
                </div>
                <div class="form-group">
                  <input id="password-field" type="password" class="form-control" placeholder="{{ trans('backpack::base.password') }}" name="password" required>
                  <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                </div>
                <div class="form-group">
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" name="remember"> {{ trans('backpack::base.remember_me') }}
                    </label>
                  </div>
                </div>
                <div  class="form-group"> 
                  <button type="submit"  class="form-control btn btn-primary submit px-3">{{ trans('backpack::base.login') }}</button>
                </div>
              </form>
              @if (backpack_users_have_email() && backpack_email_column() == 'email' && config('backpack.base.setup_password_recovery_routes', true))
              <div class="text-center"><a href="{{ route('backpack.auth.password.reset') }}">{{ trans('backpack::base.forgot_your_password') }}</a></div>
              @endif
              @if (config('backpack.base.registration_open'))
              <div class="text-center"><a href="{{ route('backpack.auth.register') }}">{{ trans('backpack::base.register') }}</a></div>
              @endif
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Include jQuery and Bootstrap JS -->
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/popper.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
  </body>
</html>
@endsection
