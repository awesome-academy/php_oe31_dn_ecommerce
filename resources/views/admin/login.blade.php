<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ trans('custome.admin_page') }}</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
</head>
<body>
    <div class="admin-login w-100">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-7 my-4">
                    <div class="form-box">
                        <form action="{{ route('admin.login.post') }}" method="POST">
                            @csrf
                            <div class="form-title text-center">
                                <h4 class="mb-0">{{ trans('custome.sign_in') . ' - ' . trans('custome.admin')}}</h4>
                                @if (session('status'))
                                    <div class="alert alert-danger mb-0 mt-2" role="alert">
                                        {{ session('status') }}
                                    </div>
                                @endif
                            </div>
                            <div class="form-body">
                                <div class="form-group">
                                    <label for="email">{{ trans('custome.enter_input', ['attribute' => trans('validation.attributes.email')]) }}</label>
                                    @if ($errors->has('email'))
                                        <p class="mb-0 text-danger">{{ $errors->first('email') }}</p>
                                    @endif
                                    <input type="email" name="email" class="form-control" id="email" value="{{ old('email') }}">
                                </div>
                                <div class="form-group mb-0">
                                    <label for="pwd">{{ trans('custome.enter_input', ['attribute' => trans('validation.attributes.password')]) }}</label>
                                    @if ($errors->has('password'))
                                        <p class="mb-0 text-danger">{{ $errors->first('password') }}</p>
                                    @endif
                                    <input type="password" name="password" class="form-control" id="password">
                                </div>
                            </div>
                            <div class="form-footer text-center">
                                <button type="submit" class="btn btn-primary">{{ trans('custome.sign_in') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
