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
      <p class="login-box-msg">Halaman ini khusus untuk Administrator</p>
            @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form method="POST" action="{{ route('password.email') }}" novalidate="novalidate">
                        @csrf
        <div class="input-group mb-3">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Alamat email..." required autocomplete="email" autofocus>


          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
		  @error('email')
			<span class="invalid-feedback" role="alert">
				{{ $message }}
			</span>
		 @enderror		  
        </div>
        <div class="row">
          <div class="col-8">
            <button type="submit" class="btn btn-primary btn-block">Kirim link password</button>
          </div>

        </div>
      </form>

      <div class="social-auth-links text-center mb-3">
	  
      </div>

	  <p class="mb-1">
	  </p>
      <p class="mb-0">
        <a href="{{route('login')}}">Kembali ke login</a>
      </p>

    </div>
  </div>
</div>

<script src="{{asset('template/plugins/jquery/jquery.min.js')}}"></script>
<script src="{{asset('template/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('template/dist/js/adminlte.min.js')}}"></script>
</body>
</html>
