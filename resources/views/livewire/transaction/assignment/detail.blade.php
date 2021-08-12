<div class="content-wrapper"> 
 <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Detail Data</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('home')}}">Beranda</a></li>
              <li class="breadcrumb-item active">Pengajuan Tugas</li>
            </ol>
          </div>
        </div>
      </div>
    </section>
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-8">
            <div class="card card-default">
              <div class="card-header">
                <h3 class="card-title">Pengajuan Tugas/Training</h3>
              </div>
              <form wire:submit.prevent="update" name="crtForm">
				  <div class="card-body">
            <div class="content">
			<div class="row">
			  <div class="col-12">
			<p><strong>NOMOR PENGAJUAN:</strong> {{$number}}</p>
			</div>
			</div>
				<div class="card">
				  <div class="card-header">
					<h3 class="card-title">Karyawan</h3>
				  </div>
				  <div class="card-body">
					<div class="row">
					  <div class="col-4">
							Nama / NRP
					  </div>
					  <div class="col-8">
						: {{$name}} / ({{$nrp}})
					  </div>
					</div>
					<div class="row">
					  <div class="col-4">
							Jabatan / Departemen
					  </div>
					  <div class="col-8">
						: {{$position}} / {{$department}}
					  </div>
					</div>
					<div class="row">
					  <div class="col-4">
							Job Site
					  </div>
					  <div class="col-8">
						: {{$site}}
					  </div>
					</div>
					<div class="row">
					  <div class="col-4">
							NO. HP
					  </div>
					  <div class="col-8">
						: {{$phone}}
					  </div>
					</div>
					<div class="row">
					  <div class="col-4">
							Alamat
					  </div>
					  <div class="col-8">
						: {{Str::limit($address,50)}}
					  </div>
					</div>					
				  </div>
				</div>


				<div class="card">
				  <div class="card-header">
					<h3 class="card-title">Tanggal Tugas / Training</h3>
				  </div>
				  <div class="card-body">
					<div class="row">
					  <div class="col-4">
							Tanggal Tugas
					  </div>
					  <div class="col-8">
						: {{$startDate}} - {{$endDate}} 
					  </div>
					</div>					
					<div class="row">
					  <div class="col-4">
							Jml Hari
					  </div>
					  <div class="col-8">
						: {{$sumDay}} Hari
					  </div>
					  <div class="col-4">
							Tanggal Masuk
					  </div>
					  <div class="col-8">
						: {{$inDate}}
					  </div>
					  <div class="col-4">
							Area Tugas
					  </div>
					  <div class="col-8">
						: @if($location=='inSite') Area Job Site @endif @if($location=='inRegional') Area Regional @endif @if($location=='outRegional') Luar Regional @endif
					  </div>					  
					  <div class="col-4">
							Keperluan
					  </div>
					  <div class="col-8">
						: {{Str::limit($description,200)}}
					  </div>					  
					</div>				
				  </div>
				</div>
			@if($location=='outRegional')
				
				<div class="card">
				  <div class="card-header">
					<h3 class="card-title">Rute Tiket</h3>
				  </div>
				  <div class="card-body">
					<div class="row">
					  <div class="col-4">
							Berangkat
					  </div>
					  <div class="col-8">
						: {{$destinationFromGoTicket}} - {{$destinationToGoTicket}} ({{$ticketDateFromGo}} {{$ticketTimeGo}})
					  </div>
					</div>					
					<div class="row">
					  <div class="col-4">
							Kembali
					  </div>
					  <div class="col-8">
						: {{$destinationFromBackTicket}} - {{$destinationToBackTicket}} ({{$ticketDateFromBack}} {{$ticketTimeBack}})
					  </div>					  
					</div>				
				  </div>
				</div>

			@endif
			@if($location=='inRegional' or $location=='outRegional')
				<div class="card">
				  <div class="card-header">
					<h3 class="card-title">Rute Travel</h3>
				  </div>
				  <div class="card-body">
					<div class="row">
					  <div class="col-4">
							Berangkat
					  </div>
					  <div class="col-8">
						: {{$destinationFromGoTravel}} - {{$destinationToGoTravel}} ({{$travelDateFromGo}})
					  </div>
					</div>					
					<div class="row">
					  <div class="col-4">
							Kembali
					  </div>
					  <div class="col-8">
						: {{$destinationFromBackTravel}} - {{$destinationToBackTravel}} ({{$travelDateFromBack}})
					  </div>					  
					</div>				
				  </div>
				</div>				
			@endif
	@if($location=='inSite')
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Akomodasi</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>Deskripsi</th>
                      <th>Hari</th>
                      <th>Biaya</th>
                      <th>Total</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>Makan</td>
					 <td>{{$mealDay}}</td>
					 <td>{{$mealCost}}</td>
					 <td>{{$mealCostTotal}}</td>
                    </tr>
                    <tr>
                     <td>Lain-lain</td>
					 <td>{{$otherDay}}</td>
					 <td>{{$otherCost}}</td>
					 <td>{{$otherCostTotal}}</td>
                    </tr>
					<tr><td></td><td></td><td><strong>Grand Total</strong></td><td><strong>{{$costGrandTotal}}</strong></td></tr>
					<tr><td>Terbilang</td><td colspan="3"><strong>{{ucfirst($countedGrandTotal)}} </strong>Rupiah</td></tr>						
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
	@else		
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Akomodasi</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>Deskripsi</th>
                      <th>Hari</th>
                      <th>Biaya</th>
                      <th>Total</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>Penginapan</td>
					 <td>{{$lodgingDay}}</td>
					 <td>{{$lodgingCost}}</td>
					 <td>{{$lodgingCostTotal}}</td>
                    </tr>
                    <tr>
                      <td>Transportasi</td>
					 <td>{{$transportDay}}</td>
					 <td>{{$transportCost}}</td>
					 <td>{{$transportCostTotal}}</td>
                    </tr>
                    <tr>
                      <td>Makan</td>
					 <td>{{$mealDay}}</td>
					 <td>{{$mealCost}}</td>
					 <td>{{$mealCostTotal}}</td>
                    </tr>
                    <tr>
                     <td>Lain-lain</td>
					 <td>{{$otherDay}}</td>
					 <td>{{$otherCost}}</td>
					 <td>{{$otherCostTotal}}</td>
                    </tr>
					<tr><td></td><td></td><td><strong>Grand Total</strong></td><td><strong>{{$costGrandTotal}}</strong></td></tr>
					<tr><td>Terbilang</td><td colspan="3"><strong>{{ucfirst($countedGrandTotal)}} </strong>Rupiah</td></tr>						
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
	@endif			
				<div class="card">
				  <div class="card-header">
					<h3 class="card-title">Electronic Approve</h3>
				  </div>
				  <div class="card-body">
					<div class="row">
					 @forelse ($approvalRecords as $approvItem)
					 
					 @if($approvItem->employeeLevel=='department_head' or $approvItem->employeeLevel=='site_manager')
						 <div class="col-4">
							@if($approvItem->employeeLevel=='department_head')
								@if($approvItem->level_approv=='site_manager' and $approvItem->hr_head=='0' and $approvItem->sm_approv=='1')
									{{qrCode($approvItem->nrp.'-'.$approvItem->approver)}}<br><br>
									<strong>{{$approvItem->approver}}</strong> <br>
									Project Manager<br><span id="approverDate">{{date('d/m/Y',strtotime($approvItem->created_at))}}</span>
																	
									
								@elseif($approvItem->level_approv=='site_manager' and $approvItem->hr_head=='0' and $approvItem->sm_approv=='2')
									<i class="fa fa-ban fa-3x"></i><br><br>	
									<strong>{{$approvItem->approver}}</strong><br>
									Project Manager<br><span id="approverDate">{{date('d/m/Y',strtotime($approvItem->created_at))}}</span>
								@else
									Belum ada approval
								@endif
							@endif
							
							@if($approvItem->employeeLevel=='site_manager')
								@if($approvItem->level_approv=='site_manager' and $approvItem->hr_head=='0' and $approvItem->sm_approv=='1')
									{{qrCode($approvItem->nrp.'-'.$approvItem->approver)}}<br><br>
									<strong>{{$approvItem->approver}}</strong> <br>
									Project Manager<br><span id="approverDate">{{date('d/m/Y',strtotime($approvItem->created_at))}}</span>
																	
									
								@elseif($approvItem->level_approv=='site_manager' and $approvItem->hr_head=='0' and $approvItem->sm_approv=='2')
									<i class="fa fa-ban fa-3x"></i><br><br>	
									<strong>{{$approvItem->approver}}</strong><br>
									Project Manager<br><span id="approverDate">{{date('d/m/Y',strtotime($approvItem->created_at))}}</span>
								@else
									Belum ada approval
								@endif
							@endif							
							
						 </div>
					 
					 @endif
					 @if($approvItem->employeeLevel=='employee' or $approvItem->employeeLevel=='hrd_admin')
					  <div class="col-4">
						
							@if($approvItem->employeeLevel=='employee' or $approvItem->employeeLevel=='hrd_admin')
								
								@if($approvItem->level_approv=='site_manager' and $approvItem->hr_head=='0' and $approvItem->sm_approv=='1')
									{{qrCode($approvItem->nrp.'-'.$approvItem->approver)}}<br><br>
									<strong>{{$approvItem->approver}}</strong><br>
									Project Manager<br><span id="approverDate">{{date('d/m/Y',strtotime($approvItem->created_at))}}</span>
									
								@elseif($approvItem->level_approv=='site_manager' and $approvItem->hr_head=='0' and $approvItem->sm_approv=='2')
									<i class="fa fa-ban fa-3x"></i><br><br>	
									<strong>{{$approvItem->approver}}</strong><br>
									Project Manager<br><span id="approverDate">{{date('d/m/Y',strtotime($approvItem->created_at))}}</span>								

								@elseif($approvItem->level_approv=='department_head' and $approvItem->hr_head=='0' and $approvItem->head_approv=='1')
									{{qrCode($approvItem->nrp.'-'.$approvItem->approver)}}<br><br>
									<strong>{{$approvItem->approver}}</strong><br>
									Dept.Head<br><span id="approverDate">{{date('d/m/Y',strtotime($approvItem->created_at))}}</span>
									
								@elseif($approvItem->level_approv=='department_head' and $approvItem->hr_head=='0' and $approvItem->head_approv=='2')
									<i class="fa fa-ban fa-3x"></i><br><br>	
									<strong>{{$approvItem->approver}}</strong><br>
									Dept.Head<br><span id="approverDate">{{date('d/m/Y',strtotime($approvItem->created_at))}}</span>
									
								@elseif($approvItem->level_approv=='department_head' and $approvItem->hr_head=='1' and $approvItem->head_approv=='1')
									{{qrCode($approvItem->nrp.'-'.$approvItem->approver)}}<br><br>
									<strong>{{$approvItem->approver}}</strong><br>
									Dept.Head<br><span id="approverDate">{{date('d/m/Y',strtotime($approvItem->created_at))}}</span>
									
								@elseif($approvItem->level_approv=='department_head' and $approvItem->hr_head=='1' and $approvItem->head_approv=='2')
									<i class="fa fa-ban fa-3x"></i><br><br>	
									<strong>{{$approvItem->approver}}</strong><br>
									Dept.Head<br><span id="approverDate">{{date('d/m/Y',strtotime($approvItem->created_at))}}</span>
									
								@else
									Belum ada approval
								@endif							
							
							
							@endif	
					  
	
							
					  </div>
					  @endif
					@if($approvItem->approv=='2')
						  <div class="col-12">
						  <br>
						  <p style="color:#ff0000;"><strong>Tidak Disetujui Karena:</strong> {{$approvItem->reason}}</p>
						  </div>
					@endif					  

					@empty
					   Belum ada approval!
					@endforelse
					</div>
	
				  </div>
				</div>
			</div>						
				  </div>
                <div class="card-footer">
                  <a href="{{ url()->previous() }}" type="button" class="btn btn-warning" data-dismiss="modal">Tutup</a>&nbsp;&nbsp;&nbsp;&nbsp;
				  </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>
</div>
@push('styles')
  <link rel="stylesheet" type="text/css" href="{{asset('template/plugins/pikaday/pikaday.css')}}">
   <link rel="stylesheet" href="{{asset('template/plugins/select2/css/select2.min.css')}}">
  <link rel="stylesheet" href="{{asset('template/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}"> 
    <link rel="stylesheet" type="text/css" href="{{asset('template/custom/single.css')}}">
	    <link rel="stylesheet" type="text/css" href="{{asset('template/plugins/timepicker/timepicker.modif.css')}}">
		 <link rel="stylesheet" href="{{asset('template/custom/table.css')}}">
@endpush
@push('scripts')
<script src="{{asset('template/plugins/moment/moment.min.js')}}"></script>
<script src="{{asset('template/plugins/pikaday/pikaday.js')}}"></script>
<script src="{{asset('template/plugins/select2/js/select2.full.min.js')}}"></script>
<script src="{{asset('template/plugins/timepicker/timepicker.modif.js')}}"></script>
<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })

  })
</script>
  <script>
       $(document).ready(function () {
          $(document).on('change', '#permissionCategoryId', function (e) {
              @this.set('permissionCategory', e.target.value);
           });	   
       });

       document.addEventListener('livewire:load', function (event) {
          @this.on('refreshDropdown', function () {
              $('.select2').select2();
          });  
     })
	 
	 </script>
<script>

    var picker4 = new Pikaday({
        field: document.getElementById('startDateId'),
        format: 'DD/MM/YYYY',
    });
	
	
	var picker5 = new Pikaday({
		field: document.getElementById('endDateId'),
		format: 'DD/MM/YYYY',
	});
	
		var picker5 = new Pikaday({
		field: document.getElementById('inDateId'),
		format: 'DD/MM/YYYY',
	});
</script>
@endpush
