<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{trans('label.admin')}}</title>
    {{-- Bootstrap CSS --}}
    <link rel="stylesheet" href="{{ asset('public/assets/frontend/css/bootstrap/bootstrap.min.css') }}">

    {{-- Font Awesome CSS --}}
    <link rel="stylesheet" href="{{ asset('public/assets/frontend/css/font-awesome/css/all.css') }}">

    {{-- Admin Login CSS --}}
    <link rel="stylesheet" href="{{ asset('public/assets/admin/css/admin_users/admin.css') }}">
    <link rel="stylesheet" href="{{ asset('public/assets/admin/css/admin_users/custom.css') }}">

    {{-- Font Style --}}
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700' rel='stylesheet' type='text/css'>

    {{-- Toastr CSS --}}
    <link rel="stylesheet" href="{{ asset('public/assets/admin/css/toastr/toastr.min.css') }}">

</head>

<body class="login">

    <div class="auth">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-4 position-relative">
                    <div class="admin_logo text-center mb-3">
                        {{-- <img alt="logo" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQDOLfmIA4IGukHskftrTRSelu-K73Xu9drKw&usqp=CAU" class="theme-logo"> --}}
                        <h4 class="mt-2">{{ trans('label.Naveli') }}</h4>
                    </div>
                    <div class="login_detail">
                        <form method="post" action="{{ route('admin.do.login') }}">
                            @csrf
                            <div class="row">
                                {{-- <div class="col-md-12 text-center">
                                    <img alt="logo" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQDOLfmIA4IGukHskftrTRSelu-K73Xu9drKw&usqp=CAU" class="theme-logo">
                                    <h4 class="mt-2">{{trans('label.Naveli')}}</h4>
                                </div> --}}
                               
                                <div class="col-md-12">
                                    {{-- Email --}}
                                    <div class="form-group">
                                        <label for="email" class="form-label">{{trans('label.email')}}</label>
                                        <div class="input-group">
                                            <input type="text"
                                                class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                                name="email" id="email" placeholder="E-mail"
                                                value="{{ old('email') }}">
                                            @if ($errors->has('email'))
                                                <span class="invalid-feedback">
                                                    {{ $errors->first('email') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    {{-- Password --}}
                                    <div class="form-group">
                                        <label for="password" class="form-label">{{trans('label.password')}}</label>
                                        <div class="input-group">
                                            <input type="password"
                                                class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                                                name="password" id="password" placeholder="Password"
                                                value="{{ old('password') }}">
                                                <span class="input-group-text" onclick="ShowHidePassword()" id="passIcon">
                                                    <i class="fa fa-eye-slash"></i>
                                                </span>
                                            @if ($errors->has('password'))
                                                <span class="invalid-feedback">
                                                    {{ $errors->first('password') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <button class="btn btn-gradient-dark w-100 btn-rounded">{{ trans('label.Sign_In') }}</button>
                                    </div>
                                </div>
                                <div class="col-md-12 text-center">
                                    <div class="form-group forget-pass">
                                        <a href="{{ route('forget.password.get') }}">{{trans('label.Forget_Password')}}</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Jquery --}}
    <script src="{{ asset('public/assets/admin/js/jquery/jquery.min.js') }}"></script>

    {{-- Popper JS --}}
    <script src="{{ asset('public/assets/frontend/js/popper/popper.min.js') }}"></script>

    {{-- Bootstarp JS --}}
    <script src="{{ asset('public/assets/frontend/js/bootstrap/bootstrap.min.js') }}"></script>

    {{-- Toastr --}}
    <script src="{{ asset('public/assets/admin/js/toastr/toastr.min.js') }}"></script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script type="text/javascript">
        @if (Session::has('message'))
            toastr.options = {
                "closeButton": true,
                "progressBar": true
            }
            toastr.success("{{ session('message') }}");
        @endif

        @if (Session::has('error'))
            toastr.options = {
                "closeButton": true,
                "progressBar": true
            }
            toastr.error("{{ session('error') }}");
        @endif
    </script>

    <script type="text/javascript">
        // Show & Hide Password
        function ShowHidePassword() {
            var currentType = $('#password').attr('type');

            if (currentType == 'password') {
                $('#password').attr('type', 'text');
                $('#passIcon').html('');
                $('#passIcon').append('<i class="fa fa-eye"></i>');
            } else {
                $('#password').attr('type', 'password');
                $('#passIcon').html('');
                $('#passIcon').append('<i class="fa fa-eye-slash"></i>');
            }
        }
    </script>

</body>

</html>
