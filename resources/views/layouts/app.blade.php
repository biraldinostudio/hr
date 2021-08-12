<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta charset="utf-8">
<meta NAME="robots" CONTENT="noindex">
<meta NAME="robots" CONTENT="nofollow">
<meta NAME="robots" CONTENT="noindex,nofollow">  
  
  
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{config('app.title')}}</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{asset('template/plugins/fontawesome-free/css/all.min.css')}}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
  @stack('styles')
  <!-- Theme style -->
  <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine.min.js" defer></script>
  <link rel="stylesheet" href="{{asset('template/dist/css/adminlte.min.css')}}">
   
  @livewireStyles
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Navbar -->
	
	@section('navbar')
		@include('layouts.partials.navbar')
	@show
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
	@section('aside')
		@include('layouts.partials.aside')
	@show
  </aside>

  <!-- Content Wrapper. Contains page content -->
 
	@yield('content')

  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
      <h5>Title</h5>
      <p>Sidebar content</p>
    </div>
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
	@section('footer')
		@include('layouts.partials.footer')
	@show
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="{{asset('template/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('template/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
@stack('scripts')
<script src="{{asset('template/dist/js/adminlte.min.js')}}"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {

			document.querySelectorAll('input[type-currency="IDR"]').forEach((element) => {
			  element.addEventListener('keyup', function(e) {
			  let cursorPostion = this.selectionStart;
				let value = parseInt(this.value.replace(/[^,\d]/g, ''));
				let originalLenght = this.value.length;
				if (isNaN(value)) {
				  this.value = "";
				} else {    
				  this.value = value.toLocaleString('id-ID', {
					currency: 'IDR',
					style: 'currency',
					minimumFractionDigits: 0
				  });
				  cursorPostion = this.value.length - originalLenght + cursorPostion;
				  this.setSelectionRange(cursorPostion, cursorPostion);
				}
			  });
			});			
			
			
        Livewire.on('showModal',(id)=>{
            id = "#" + id;
            $(id).modal('show');
        });
        Livewire.on('closeModal',(id)=>{
            id = "#" + id;
            $(id).modal('hide');
        });
				
        Livewire.on('flashMessage',(param)=>{
            toastr.options = {
                "closeButton": true,
                "debug": false,
                "newestOnTop": false,
                "progressBar": true,
                "positionClass": "toast-top-center",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "600",
                "hideDuration": "1000",
                "timeOut": "2000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }
            //Command: toastr["success"]("Berhasil", "Tambah data!");
            toastr[param['type']](param['message'],param['title']);
        });
    });
</script>

    <script type="text/javascript">
       // window.livewire.on('showNotApprovModal', () => {
          //  $('#modal_not_approval_assignment').modal('show');
       // });
    </script>
@livewireScripts
</body>
</html>
