@extends('layouts.app')

@section('content')
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Halaman Beranda</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
              <li class="breadcrumb-item active">Halaman Beranda</li>
            </ol>
          </div>
        </div>
      </div>
    </section>
    <section class="content">
      <div class="container-fluid">
	  @if(Auth::user()->level=='department_head' or Auth::user()->level=='site_manager' or Auth::user()->level=='administrator')
		<div class="card card-default">
			<div class="card-header">
				<h3 class="card-title">PENGAJUAN KARYAWAN</h3>
			</div>
			<div class="card-body">
				<div class="row">
				  <div class="col-md-4 col-sm-6 col-12">
					<div class="info-box bg-info">
					  <span class="info-box-icon"><i class="fas fa-holly-berry"></i></span>

					  <div class="info-box-content">
						<span class="info-box-text">Pengajuan</span>
						<span class="info-box-number"><a href="{{route('day-of')}}" style="color:#ffffff;">CUTI JOB SITE</a></span>

						<div class="progress">
						  <div class="progress-bar" style="width: 100%"></div>
						</div>
						<span class="progress-description">
							@if($countDayOfs==0) Blm Approv: <strong>0</strong> Pengajuan @else Blm Approv: <strong>{{$countDayOfs}}</strong> Pengajuan @endif
						</span>
					  </div>
					</div>
				  </div>
				  <div class="col-md-4 col-sm-6 col-12">
					<div class="info-box bg-success">
					  <span class="info-box-icon"><i class="fas fa-handshake"></i></span>

					  <div class="info-box-content">
						<span class="info-box-text">Pengajuan</span>
						<span class="info-box-number"><a href="{{route('permission')}}" style="color:#ffffff;">IZIN TIDAK KERJA</a></span>

						<div class="progress">
						  <div class="progress-bar" style="width: 100%"></div>
						</div>
						<span class="progress-description">
							@if($countPermissions==0) Blm Approv: <strong>0</strong> Pengajuan @else Blm Approv: <strong>{{$countPermissions}}</strong> Pengajuan @endif
						</span>
					  </div>
					</div>
				  </div>
				  <div class="col-md-4 col-sm-6 col-12">
					<div class="info-box bg-warning">
					  <span class="info-box-icon"><i class="fas fa-tasks"></i></span>

					  <div class="info-box-content">
						<span class="info-box-text">Pengajuan</span>
						<span class="info-box-number"><a href="{{route('assignment')}}" style="color:#ffffff;">DINAS/TRAINING</a></span>

						<div class="progress">
						  <div class="progress-bar" style="width: 100%"></div>
						</div>
						<span class="progress-description">
							@if($countAssignments==0) Blm Approv: <strong>0</strong> Pengajuan @else Blm Approv: <strong>{{$countAssignments}}</strong> Pengajuan @endif
						</span>
					  </div>
					</div>
				  </div>
				</div>
			</div>
        </div>
		@else
		@endif
		<div class="card card-default">
			<div class="card-header">
				<h3 class="card-title">PENGAJUAN SAYA</h3>
			</div>
			<div class="card-body">
				<div class="row">
				  <div class="col-md-4 col-sm-6 col-12">
					<div class="info-box bg-orange">
					  <span class="info-box-icon"><i class="fas fa-holly-berry"></i></span>

					  <div class="info-box-content">
						<span class="info-box-text">Pengajuan</span>
						<span class="info-box-number"><a href="{{route('my-day-of')}}" style="color:#ffffff;">CUTI JOB SITE</a></span>

						<div class="progress">
						  <div class="progress-bar" style="width: 100%"></div>
						</div>
						<span class="progress-description">
							&nbsp;
						</span>
					  </div>
					</div>
				  </div>
				  <div class="col-md-4 col-sm-6 col-12">
					<div class="info-box bg-purple">
					  <span class="info-box-icon"><i class="fas fa-handshake"></i></span>

					  <div class="info-box-content">
						<span class="info-box-text">Pengajuan</span>
						<span class="info-box-number"><a href="{{route('my-permission')}}" style="color:#ffffff;">IZIN TIDAK KERJA</a></span>

						<div class="progress">
						  <div class="progress-bar" style="width: 100%"></div>
						</div>
						<span class="progress-description">
							&nbsp;
						</span>
					  </div>
					</div>
				  </div>
				  <div class="col-md-4 col-sm-6 col-12">
					<div class="info-box bg-primary">
					  <span class="info-box-icon"><i class="fas fa-tasks"></i></span>

					  <div class="info-box-content">
						<span class="info-box-text">Pengajuan</span>
						<span class="info-box-number"><a href="{{route('my-assignment')}}" style="color:#ffffff;">DINAS/TRAINING</a></span>

						<div class="progress">
						  <div class="progress-bar" style="width: 100%"></div>
						</div>
						<span class="progress-description">
							&nbsp;
						</span>
					  </div>
					</div>
				  </div>
				</div>
			</div>
        </div>		
      </div>
    </section>

  </div>
@endsection
@push('styles')
  <link rel="stylesheet" href="{{asset('template/custom/home.css')}}">
@endpush
@push('scripts')
<script>
</script>
@endpush
