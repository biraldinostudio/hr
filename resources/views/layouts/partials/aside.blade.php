  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{route('home')}}" class="brand-link">
      <img src="{{asset('template/dist/img/logo/logo.png')}}" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">PT Riung</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{asset('template/dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{Auth::user()->name}}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item menu-open">
            <a href="{{route('home')}}" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Beranda
              </p>
            </a>
          </li>
	@if(Auth::user()->level=='administrator')
		  <li class="nav-header">MASTER DATA</li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-map-marker"></i>
              <p>
                Lokasi
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('poh')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>POH</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('destination')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Destinasi</p>
                </a>
              </li>			  
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Organisasi Perusahaan
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('site')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Site</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('department')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Departemen</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('position')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Jabatan</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('employee')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Karyawan</p>
                </a>
              </li>
            </ul>
          </li>
              <li class="nav-item">
                <a href="{{route('permission-category')}}" class="nav-link">
                  <i class="fa fa-file-contract nav-icon"></i>
                  <p>Jenis Izin</p>
                </a>
              </li>		  
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-building"></i>
              <p>
                Parameter Cuti
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('day-of-period')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Periode Cuti Job Site</p>
                </a>
              </li>			
              <li class="nav-item">
                <a href="{{route('poh-day-of')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Cuti Job Site</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('poh-annual-leave')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Cuti Tahunan</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('poh-big-leave')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Cuti Besar</p>
                </a>
              </li>				  				  
            </ul>
          </li>
	@endif
		  <li class="nav-header">TRANSAKSI</li>
	@if(Auth::user()->level=='administrator' or Auth::user()->level=='department_head' or Auth::user()->level=='site_manager')	
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-holly-berry"></i>
              <p>
                Pengajuan Cuti
                <i class="fas fa-angle-left right"></i>
              
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('day-of')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Cuti Karyawan  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('my-day-of')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Cuti Saya  </p>
                </a>
              </li>			  		  
						  
            </ul>
          </li>	
		  
		   
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-handshake"></i>
              <p>
                Pengajuan Izin
                <i class="fas fa-angle-left right"></i>
              
              </p>
            </a>
			
            <ul class="nav nav-treeview">		  
              <li class="nav-item">
                <a href="{{route('permission')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Izin Karyawan</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('my-permission')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Izin Saya</p>
                </a>
              </li>			  
            </ul>
          </li>	
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-tasks"></i>
              <p>
                Pengajuan Tugas
                <i class="fas fa-angle-left right"></i>
              
              </p>
            </a>
            <ul class="nav nav-treeview">		  	  
              <li class="nav-item">
                <a href="{{route('assignment')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Tugas Karyawan</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('my-assignment')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Tugas Saya</p>
                </a>
              </li>		  
            </ul>
          </li>	
 
	@if(Auth::user()->level=='administrator')		  
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-file-invoice-dollar"></i>
              <p>
                Klaim Cuti Besar
                <i class="fas fa-angle-left right"></i>
              
              </p>
            </a>
            <ul class="nav nav-treeview">	  	  
              <li class="nav-item">
                <a href="{{route('invoice.big-leave')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Klaim Tidak Ambil</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('invoice.big-leave-claim')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Info Klaim</p>
                </a>
              </li>			  
            </ul>
          </li>
	@endif		
	@else
              <li class="nav-item">
                <a href="{{route('my-day-of')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pengajuan Cuti  </p>
                </a>
              </li>		
              <li class="nav-item">
                <a href="{{route('my-permission')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pengajuan Izin  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('my-assignment')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pengajuan Tugas</p>
                </a>
              </li>				  
	@endif
	
		  <li class="nav-header">EXPORT</li>
		@if(Auth::user()->level=='administrator')
              <li class="nav-item">
                <a href="{{route('report-export')}}" class="nav-link">
                  <i class="fa fa-file-excel nav-icon"></i>
                  <p>Export Data</p>
                </a>
              </li>			
		@endif	
	
	
		  <li class="nav-header">USER</li>
		@if(Auth::user()->level=='administrator')		  
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-user-secret"></i>
              <p>
                Manajemen User
                <i class="fas fa-angle-left right"></i>
               
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('administrator')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Administrator</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('site-manager')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Project Manager</p>
                </a>
              </li>			  
              <li class="nav-item">
                <a href="{{route('department-head')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pimpinan Departemen</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('hr-head')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pimpinan GEA</p>
                </a>
              </li>			  
              <li class="nav-item">
                <a href="{{route('hr-admin')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Staff HR</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('employee.reset.password')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Karyawan</p>
                </a>
              </li>				  
            </ul>
          </li>
		@endif
			
          <li class="nav-item">
            <a href="{{route('my-account')}}" class="nav-link">
              <i class="nav-icon fas fa-user"></i>
              <p>
                Akun Saya
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="nav-link">
              <i class="nav-icon fas fa-sign-out-alt"></i>
              <p>
                Keluar
              </p>
            </a>
			                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
          </li>	  
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->