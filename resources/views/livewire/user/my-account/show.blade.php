  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Profile</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
              <li class="breadcrumb-item active">User Profile</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-5">

            <!-- Profile Image -->
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">

                <h3 class="profile-username text-center">{{$myAccounts->name}}</h3>

                <p class="text-muted text-center">{{$myAccounts->nrp}}<br>
              	
						{{$myAccounts->position->name}}
                </p>					

                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b>Departemen</b> <span class="float-right">{{$myAccounts->position->department->name}}</span>
                  </li>
                  <li class="list-group-item">
                    <b>Job Site</b> <span class="float-right">{{$myAccounts->site->name}}</span>
                  </li>
                  <li class="list-group-item">
                    <b>Tanggal Bergabung</b> <span class="float-right">{{date('d M Y',strtotime($myAccounts->join_date))}}</span>
                  </li>
                  <li class="list-group-item">
                    <b>Level Karyawan</b> <span class="float-right">@if($myAccounts->staff=='1') Staff @else Non Staf @endif</span>
                  </li>
                  <li class="list-group-item">
                    <b>POH</b> <span class="float-right">{{$myAccounts->poh->name}}</span>
                  </li>
                  <li class="list-group-item">
                    <b>Nomor KTP</b> <span class="float-right">{{$myAccounts->ktp}}</span>
                  </li>
                  <li class="list-group-item">
                    <b>Lump Sum</b> <span class="float-right">{{currency_IDR($myAccounts->lumpsum)}}</span>
                  </li>
                  <li class="list-group-item">
                    <b>Tempat  / Tgl Lahir</b> <span class="float-right">{{$myAccounts->place_of_birth}} / {{date('d M Y',strtotime($myAccounts->date_of_birth))}}</span>
                  </li>					  
                  <li class="list-group-item">
                    <b>Agama</b> <span class="float-right">{{$myAccounts->religion}}</span>
                  </li>
                  <li class="list-group-item">
                    <b>No HP</b> <span class="float-right">{{$myAccounts->phone}}</span>
                  </li>
                  <li class="list-group-item">
                    <b>Golongan Darah</b> <span class="float-right">{{$myAccounts->blood_type}}</span>
                  </li>
                  <li class="list-group-item">
                    <b>Alamat</b> <span class="float-right">{{Str::limit($myAccounts->address,50)}}</span>
                  </li>				  
				  
                </ul>

                <a href="{{route('home')}}" class="btn btn-secondary btn-block"><i class="fa fa-home"></i> <b>Beranda</b></a>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- /.card -->
          </div>
          <!-- /.col -->
          <div class="col-md-7">
            <div class="card">
              <div class="card-header p-2">
				<strong>Ubah kata sandi</strong>
              </div><!-- /.card-header -->
              <div class="card-body">

                  <div class="tab-pane">
                    <form wire:submit.prevent="updatePassword" class="form-horizontal">
                      <div class="form-group row">
                        <div class="col-sm-7">
                          <input wire:model="passwordOld" type="password" class="form-control @error('passwordOld') is-invalid @enderror" placeholder="Kata sandi lama ...">
						  @error('passwordOld')
							<span class="invalid-feedback" role="alert">
								{{ $message }}
							</span>
						   @enderror
					   </div>
                      </div>
                      <div class="form-group row">
                        <div class="col-sm-7">
                          <input wire:model="passwordNew"  type="password" class="form-control @error('passwordNew') is-invalid @enderror" placeholder="Kata sandi baru ...">
						  @error('passwordNew')
							<span class="invalid-feedback" role="alert">
								{{ $message }}
							</span>
						   @enderror                        
						</div>
                      </div>
                      <div class="form-group row">
                        <div class="col-sm-7">
                          <input wire:model="passwordConfirm"  type="password" class="form-control @error('passwordConfirm') is-invalid @enderror" id="inputName2" placeholder="Ulangi kata sandi baru ...">
						  @error('passwordConfirm')
							<span class="invalid-feedback" role="alert">
								{{ $message }}
							</span>
						   @enderror                        
						</div>
                      </div>
                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-7">
                          <a href="{{route('home')}}" type="button" class="btn btn-default"><i class="fa fa-home"></i> Beranda</a>						
                          <button type="submit" class="btn btn-danger"><i class="fa fa-lock"></i> Ubah Kata Sandi</button>
                        </div>
                      </div>
                    </form>
                  </div>
                  <!-- /.tab-pane -->
          
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>