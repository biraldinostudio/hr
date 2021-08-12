<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{config('app.title')}}</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="{{asset('template/plugins/fontawesome-free/css/all.min.css')}}">
  <link rel="stylesheet" href="{{asset('template/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
  <link rel="stylesheet" href="{{asset('template/dist/css/adminlte.min.css')}}">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <img src="{{asset('template/dist/img/logo/logo.png')}}" alt="Logo" style="height:50px;">
  </div>
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Masuk untuk mulai sesi</p>
							@if (session('error'))
								<div class="alert alert-danger">
									{{ session('error') }}
								</div>
							@endif	
		<form method="POST" action="{{ route('login') }}" novalidate="novalidate">
        @csrf
        <div class="input-group mb-3">
          <input type="text" class="form-control @error('nrp') is-invalid @enderror" name="nrp" placeholder="NRP" value="{{ old('nrp') }}" required autocomplete="nrp" autofocus>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-id-card"></span>
            </div>
          </div>
		  @error('nrp')
			<span class="invalid-feedback" role="alert">
				{{ $message }}
			</span>
		 @enderror		  
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Kata sandi" required autocomplete="current-password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
		  @error('password')
			<span class="invalid-feedback" role="alert">
				{{ $message }}
			</span>
		 @enderror		  
        </div>
        <div class="row">
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Login</button>
          </div>

        </div>
      </form>

      <div class="social-auth-links text-center mb-3">
	  
      </div>
	  <p class="mb-1">
	  Jika anda lupa kata sandi, silahkan hubungi administrator GEA/HRGA!
	  <p>
	  <p class="mb-1">
	  </p>
      <p class="mb-0">
        <a href="{{route('password.request')}}">Lupa kata sandi</a><span style="color:#ff0000;font-size:11px;"> (fitur ini khusus administrator)</span>
      </p>

    </div>
  </div>
</div>
<script src="{{asset('template/plugins/jquery/jquery.min.js')}}"></script>
<script src="{{asset('template/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('template/dist/js/adminlte.min.js')}}"></script>
</body>
</html>
