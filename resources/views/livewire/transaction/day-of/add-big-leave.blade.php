
<div class="content-wrapper"> 
 <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Pengajuan Cuti Besar</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('home')}}">Beranda</a></li>
              <li class="breadcrumb-item active">Pengajuan Cuti Besar</li>
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
                <h3 class="card-title">Pengajuan Cuti Besar </h3>
              </div>
              <form wire:submit.prevent="store" name="crtForm">
                <div class="card-body">
				@if($dayOfId=='' or $dayOfId==null)
				Maaf, harus mangajukan cuti Job Site terlebih dahulu!.<br>
			 <a href="{{route('my-day-of')}}" type="button" class="btn btn-default" data-dismiss="modal">Tutup</a>&nbsp;&nbsp;&nbsp;&nbsp;				
			@elseif($bigLeaveStandartDay==null or $bigLeaveStandartDay=='')
				Maaf, parameter cuti besar untuk POH <strong>{{$pohName}}</strong> Jobsite <strong>{{$siteName}}</strong> belum diatur oleh Administrator !.
				<p><b>Terima kasih</b>.</p>
			
			<b>Kontak Administrator <i class="fa fa-phone"></i>:</b><br>
			<ul>
			@foreach($administrators as $item)
				<li>{{$item->name}}: {{$item->phone}}</li>
				@endforeach
			</ul>
			 <a href="{{route('my-day-of')}}" type="button" class="btn btn-default" data-dismiss="modal">Tutup</a>&nbsp;&nbsp;&nbsp;&nbsp;			
			@else			
			<div class="row">
				<div class="col-md-12" style="font-size:13px">
					<table>
						<tr><td><strong>Nomor Cuti</strong></td><td>: {{$number}}</td></tr>
						<tr><td><strong>Tiket keberangkatan</strong></td><td>: {{$ticketDateFromGo}} ({{$ticketTimeGo}})</td></tr>
						<tr><td><strong>Tiket kembali</strong></td><td style="color:#ff0000;">: {{$ticketDateFromBack}} ({{$ticketTimeBack}}) </td></tr>
						<tr><td><strong>Travel Berangkat</strong></td><td>: {{$travelDateFromGo}}</td></tr>
						<tr><td><strong>Travel Kembali</strong></td><td style="color:#ff0000;">: {{$travelDateFromBack}}</td></tr>
						<tr><td><strong>Cuti Job Site</strong></td><td>: {{$startDate}}- {{$endDate}} ({{$dayOfSum}} hari)</td></tr>
						<tr><td><strong>Cuti Tahunan</strong></td><td>: {{$annualLeaveStartDate}} - {{$annualLeaveEndDate}} ({{$annualLeaveSum}} hari)</td></tr>						
						<tr><td><strong>Standart Cuti Besar</strong></td><td>: {{$bigLeaveStandartDay}} Hari</td></tr>						
						<tr><td><strong>Sisah Cuti Besar</strong></td><td>:@if($bigLeaveLess==null) 0 @else{{$bigLeaveLess}} @endif Hari</td></tr>	
						<tr><td><strong>Tanggal Masuk/Induksi </strong></td><td style="color:#ff0000;">: {{$inDate}}</td></tr>
						<tr><td><strong>Jumlah Hari Tiket</strong></td><td>: Berangkat: {{$dayOfStandartDayTravel}} Hari | Kembali: {{$dayOfStandartDayTravel}} Hari</td></tr>	
						<tr><td><strong>Jumlah Hari Travel </strong></td><td>: Berangkat: {{$dayOfStandartDayTicket}} Hari | Kembali: {{$dayOfStandartDayTicket}} Hari</td></tr>							
					</table>
					Tanggal Tiket & Travel Kembali serta Tanggal Masuk Bekerja/Induksi yang beri tanda warna merah akan disesuaikan kembali berdasarkan tanggal mulai dan tanggal akhir cuti tahunan. Penyesuaian ini akan berubah secara otomatis by sistem.<br><br>
				</div>
			</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
						<label>Mulai Cuti Besar</label>
							  <div class="input-group date" data-provide="datepicker">
								<div class="input-group-prepend">
								  <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
								</div>
								<input wire:model="bigLeaveStartDate" type="text" id="bigLeaveStartDateId" class="form-control" onchange='Livewire.emit("selectBigLeaveStartDate", this.value)' placeholder="Mulai cuti ..." autocomplete="off" disabled="disabled">
							  </div>
						</div>					
					</div>
					<div class="col-md-6">
						<div class="form-group">
						<label>Selesai Cuti Besar</label>
							  <div class="input-group date" data-provide="datepicker">
								<div class="input-group-prepend">
								  <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
								</div>
								<input wire:model="bigLeaveEndDate" type="text" id="bigLeaveEndDateId" class="form-control" onchange='Livewire.emit("selectBigLeaveEndDate", this.value)' placeholder="Selesai cuti ..." autocomplete="off">
							  </div>
						</div>					
					</div>						
				</div>
				
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
						<label>Tanggal Tiket Kembali</label>
								  <div class="input-group date" data-provide="datepicker">
									<div class="input-group-prepend">
									  <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
									</div>
									<input wire:model="ticketDateFromBack" type="text" id="ticketDateFromBackId" class="form-control" onchange='Livewire.emit("selectTicketDateFromBack", this.value)' placeholder="Tanggal kembali ..." autocomplete="off">
								  </div>
						</div>					
					</div>
					<div class="col-md-6">
						<div class="form-group">
						<label>Tanggal Travel Kembali</label>
							  <div class="input-group date" data-provide="datepicker">
								<div class="input-group-prepend">
								  <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
								</div>
								<input wire:model="travelDateFromBack" type="text" id="travelDateFromBackId" class="form-control" onchange='Livewire.emit("selectTravelDateFromBack", this.value)' placeholder="Tanggal kembali ..." autocomplete="off">
							  </div>
						</div>					
					</div>						
				</div>				
				<div class="row">
				@if ($errors->any())
					<div class="alert alert-danger" style="font-size:12px;">
						@foreach ($errors->all() as $error)
						   {{ $error }} , 
						@endforeach
					</div>
				@endif			
				</div>				
				
                </div>
                <div class="card-footer">
                  <a href="{{route('my-day-of')}}" type="button" class="btn btn-default" data-dismiss="modal">Tutup</a>&nbsp;&nbsp;&nbsp;&nbsp;
				  <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Ajukan</button>
                </div>
              </form>@endif
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
		   $(".time").timepicker();
          $(document).on('change', '#ticketDestiFromGoId', function (e) {
              @this.set('ticketDestiFromGo', e.target.value);
           });		   
          $(document).on('change', '#ticketDestiToGoId', function (e) {
              @this.set('ticketDestiToGo', e.target.value);
           });

          $(document).on('change', '#ticketDestiFromBackId', function (e) {
              @this.set('ticketDestiFromBack', e.target.value);
           });		   
          $(document).on('change', '#ticketDestiToBackId', function (e) {
              @this.set('ticketDestiToBack', e.target.value);
           });

          $(document).on('change', '#travelDestiFromGoId', function (e) {
              @this.set('travelDestiFromGo', e.target.value);
           });		   
          $(document).on('change', '#travelDestiToGoId', function (e) {
              @this.set('travelDestiToGo', e.target.value);
           });
		   
          $(document).on('change', '#travelDestiFromBackId', function (e) {
              @this.set('travelDestiFromBack', e.target.value);
           });		   
          $(document).on('change', '#travelDestiToBackId', function (e) {
              @this.set('travelDestiToBack', e.target.value);
           });
       });

       document.addEventListener('livewire:load', function (event) {
          @this.on('refreshDropdown', function () {
              $('.select2').select2();
          });  
     })
</script>
<script>
    var picker1 = new Pikaday({
        field: document.getElementById('planDateId'),
        format: 'DD/MM/YYYY',
    });
	
    var picker2 = new Pikaday({
        field: document.getElementById('ticketDateFromGoId'),
        format: 'DD/MM/YYYY',
    });	
	
    var picker3 = new Pikaday({
        field: document.getElementById('travelDateFromGoId'),
        format: 'DD/MM/YYYY',
    });

    var picker4 = new Pikaday({
        field: document.getElementById('startDateId'),
        format: 'DD/MM/YYYY',
    });
	
	
	var picker5 = new Pikaday({
		field: document.getElementById('endDateId'),
		format: 'DD/MM/YYYY',
	});
	
	var picker6 = new Pikaday({
		field: document.getElementById('bigLeaveStartDateId'),
		format: 'DD/MM/YYYY',
	});
	
	var picker7 = new Pikaday({
		field: document.getElementById('bigLeaveEndDateId'),
		format: 'DD/MM/YYYY',
	});
	
	var picker6 = new Pikaday({
		field: document.getElementById('bigLeaveStartDateId'),
		format: 'DD/MM/YYYY',
	});
	
	var picker7 = new Pikaday({
		field: document.getElementById('bigLeaveEndDateId'),
		format: 'DD/MM/YYYY',
	});		

	var picker8 = new Pikaday({
        field: document.getElementById('ticketDateFromBackId'),
        format: 'DD/MM/YYYY',
    });	
	
    var picker9 = new Pikaday({
        field: document.getElementById('travelDateFromBackId'),
        format: 'DD/MM/YYYY',
    });	
</script>

 <script>
function clearSelect2() {
   var frm = document.getElementsByName('crtForm')[0];
   frm.submit();
   frm.reset();
   return false;
}
</script>
@endpush
