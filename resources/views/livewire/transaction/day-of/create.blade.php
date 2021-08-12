<div wire:ignore.self class="modal fade" id="createModal" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Pengajuan Cuti</h4>
          <button wire:click="cancel" onclick="clearSelect2()" type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
       
        <div class="modal-body">
		 <form wire:submit.prevent="store" name="crtForm"> 
		@if($dayOfStandartDay=='' and $dayOfStandartDayTravel=='')
			Belum bisa pengajuan cuti karena parameter cuti untuk site: <b>{{$dayOfStandartSite}}</b> dan POH: <b>{{$dayOfStandartPoh}}</b> belum ditentukan oleh administrator.
		    Silahkan hubungi Administrator untuk melengkapi data tersebut!. <p><b>Terima kasih</b>.</p>
			
			<b>Kontak Administrator <i class="fa fa-phone"></i>:</b><br>
			<ul>
			@foreach($administrators as $item)
				<li>{{$item->name}}: {{$item->phone}}</li>
				@endforeach
			</ul>
			
		@elseif(Auth::user()->staff=='0' and $workDay<$dayOfPeriod)
			Maaf Anda belum bisa ambil cuti karena jumlah hari kerja Anda anda belum mencukupi <strong>{{$dayOfPeriod}}</strong> Hari.
			<br><br>Jika kebutuhan cuti Anda merupakan hal yang penting dan mendesak, maka silahkan hubung petugas HR untuk membuat pengajuan cuti Anda.
			
			<br><br><p><strong>Terima kasih</strong>.</p>
			
			<b>Kontak Administrator <i class="fa fa-phone"></i>:</b><br>
			<ul>
			@foreach($administrators as $item)
				<li>{{$item->name}}: {{$item->phone}}</li>
				@endforeach
			</ul>

		@elseif($latestDayOfOpen>0)
			Maaf Anda sudah melakukan pengajuan cuti dengan nomor <strong>{{$latestDayOfOpenNumber}}</strong> Silahkan cek pengajuan cuti tersebut.
			<br><br>Jika pengajuan cuti tersebut tidak dilanjutkan, silahkan non aktifkan. Dengan cara non aktifkan melalui menu Edit <i class="fa fa-edit"></i>.
		    
			<br><br><p><strong>Terima kasih</strong>.</p>
			
			<b>Kontak Administrator <i class="fa fa-phone"></i>:</b><br>
			<ul>
			@foreach($administrators as $item)
				<li>{{$item->name}}: {{$item->phone}}</li>
				@endforeach
			</ul>

			
		@else
				<div class="row">
					<p style="font-size:12px;color:#ff0000;">Harap diperhatikan, untuk memperlancar proses pengajuan cuti,  mohon diperhatikan dengan baik setiap kolom yang diisi. Sebelum klik tombol <strong>Mengajukan Cuti</strong> diharapkan periksa kembali isiannya.
				</p>
				</div>				
			
			<div class="row">
				<div class="col-md-12" style="font-size:12px">
				Jumlah hari kerja Anda: <strong>{{$workDay}}</strong> Hari | Hak Cuti Reguler Anda: <b>{{$dayOfStandartDay}}</b> | @if($this->workDayFirst>365) | @else @endif Hari keberangkatan <b>{{$dayOfStandartDayTravel+$dayOfStandartDayTicket}}</b> Hari, Hari Kembali Ke Site <b>{{$dayOfStandartDayTravel+$dayOfStandartDayTicket}}</b> Hari |  Lumpsum <b>{{currency_IDR($lumpsum)}}</b><br><br>
				</div>
			</div>		
            <div class="row">
				@if ($errors->any())
					  <div class="col-md-12">
					<span class="invalid-feedback select2Error" role="alert">
						<div class="alert alert-warning">
							   Kesalahan penginputan data! silahkan lihat pesan Error dibawah Form Pengajuan!
						</div>
					</span>	
					</div>
				@endif	
              <div class="col-md-6">
				  <label>Rencana:</label>			  
					<div class="form-group">
					  <div class="input-group date" data-provide="datepicker">
						<div class="input-group-prepend">
						  <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
						</div>
						<input wire:model="planDate" type="text" id="planDateId" class="form-control" onchange='Livewire.emit("selectPlanDate", this.value)' placeholder="Rencana cuti ..." autocomplete="off">
					  </div>
					</div>
              </div>
			</div>
		@if($dayOfStandartDayTicket>0 and $homeFacility!=1)			
			<div class="card card-default">
				<div class="card-header">
					<h3 class="card-title">Rute Tiket Keberangkatan</h3>
				</div>
				  <div class="card-body">
					  <div class="row">
						<div class="col-sm-6">
							<div wire:ignore class="form-group">
								<select wire:model="ticketDestiFromGo" id="ticketDestiFromGoId" class="select2 form-control" onchange='Livewire.emit("selectTicketDestiFromGo", this.value)' placeholder="Dari">
									<option value="" selected="selected">Pilih Keberangkatan</option>
									@foreach($destinations as $item)
										<option value="{{$item->id}}">{{$item->name}}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="col-sm-6">
							<div  wire:ignore class="form-group">
								<select wire:model="ticketDestiToGo" id="ticketDestiToGoId" class="select2 form-control" onchange='Livewire.emit("selectTicketDestiToGo", this.value)' placeholder="Tujuan">
									<option value="" selected="selected">Pilih Tujuan</option>
									@foreach($destinations as $item)
										<option value="{{$item->id}}">{{$item->name}}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<div class="input-group date" data-provide="datepicker">
									<div class="input-group-prepend">
									  <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
									</div>																
									<input wire:model="ticketDateFromGo" type="text" id="ticketDateFromGoId" class="form-control" onchange='Livewire.emit("selectTicketDateFromGo", this.value)' placeholder="Tanggal berangkat ..." autocomplete="off">
								</div>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="bootstrap-timepicker">
								<div class="form-group">								
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text"><i class="far fa-clock"></i></span>
										</div>										
										<input wire:model="ticketTimeGo" type="text" class="form-control time" onchange='Livewire.emit("selectTicketTimeGo", this.value)' placeholder="Jam berangkat ..." autocomplete="off">

									</div>
								</div>
							</div>
						</div>							
					  </div>
				  </div>
            </div>
			
			<div class="card card-default">
				<div class="card-header">
					<h3 class="card-title">Rute Tiket Kembali</h3>
				</div>
				  <div class="card-body">
					  <div class="row">
						<div class="col-sm-6">
							<div wire:ignore class="form-group">
								<select wire:model="ticketDestiFromBack" id="ticketDestiFromBackId" class="select2 form-control" onchange='Livewire.emit("selectTicketDestiFromBack", this.value)' placeholder="Dari">
									<option value="" selected="selected">Pilih Keberangkatan</option>
									@foreach($destinations as $item)
										<option value="{{$item->id}}">{{$item->name}}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="col-sm-6">
							<div  wire:ignore class="form-group">
								<select wire:model="ticketDestiToBack" id="ticketDestiToBackId" class="select2 form-control" onchange='Livewire.emit("selectTicketDestiToBack", this.value)' placeholder="Tujuan">
									<option value="" selected="selected">Pilih Tujuan</option>
									@foreach($destinations as $item)
										<option value="{{$item->id}}">{{$item->name}}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								  <div class="input-group date" data-provide="datepicker">
									<div class="input-group-prepend">
									  <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
									</div>
									<input wire:model="ticketDateFromBack" type="text" id="ticketDateFromBackId" class="form-control" onchange='Livewire.emit("selectTicketDateFromBack", this.value)' placeholder="Tanggal kembali ..." autocomplete="off">
								  </div>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text"><i class="far fa-clock"></i></span>
										</div>										
										<input wire:model="ticketTimeBack" type="text" class="form-control time" onchange='Livewire.emit("selectTicketTimeBack", this.value)' placeholder="Jam kembali ..." autocomplete="off">

									</div>
							</div>
						</div>							
					  </div>
				  </div>
            </div>
		@endif	
			<div class="card card-default">
				<div class="card-header">
					<h3 class="card-title">Cuti Job Site</h3>
				</div>
				  <div class="card-body">
					  <div class="row">
						<div class="col-sm-4">
							<div class="form-group">
							  <div class="input-group date" data-provide="datepicker">
								<div class="input-group-prepend">
								  <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
								</div>
								<input wire:model="startDate" type="text" id="startDateId" class="form-control" onchange='Livewire.emit("selectStartDate", this.value)' placeholder="Mulai cuti ..." disabled="disabled" autocomplete="off">
							  </div>
							</div>
						</div>
						<div class="col-sm-4">
							<div  class="form-group">
							  <div class="input-group date" data-provide="datepicker">
								<div class="input-group-prepend">
								  <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
								</div>
								<input wire:model="endDate" type="text" id="endDateId" class="form-control" onchange='Livewire.emit("selectEndDate", this.value)' placeholder="Selesai cuti ..." autocomplete="off">
							  </div>
							</div>
						</div>					
					  </div>
				  </div>
            </div>	
		@if($dayOfStandartDayTravel>0 and $homeFacility!=1)			
			<div class="card card-default">
				<div class="card-header">
					<h3 class="card-title">Rute Travel Berangkat</h3>
				</div>
				  <div class="card-body">
					  <div class="row">
						<div class="col-sm-4">
							<div wire:ignore class="form-group">
								<select wire:model="travelDestiFromGo" id="travelDestiFromGoId" class="select2 form-control" onchange='Livewire.emit("selectTravelDestiFromGo", this.value)' placeholder="Dari">
									<option value="" selected="selected">Pilih Keberangkatan</option>
									@foreach($destinations as $item)
										<option value="{{$item->id}}">{{$item->name}}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="col-sm-4">
							<div  wire:ignore class="form-group">
								<select wire:model="travelDestiToGo" id="travelDestiToGoId" class="select2 form-control" onchange='Livewire.emit("selectTravelDestiToGo", this.value)' placeholder="Tujuan">
									<option value="" selected="selected">Pilih Tujuan</option>
									@foreach($destinations as $item)
										<option value="{{$item->id}}">{{$item->name}}</option>
									@endforeach
								</select>
							</div>
						</div>					  
						<div class="col-sm-4">
							<div  class="form-group">
							  <div class="input-group date" data-provide="datepicker">
								<div class="input-group-prepend">
								  <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
								</div>
								<input wire:model="travelDateFromGo" type="text" id="travelDateFromGoId" class="form-control" onchange='Livewire.emit("selectTravelDateFromGo", this.value)' placeholder="Tanggal berangkat ..." autocomplete="off">
							  </div>
							</div>
						</div>					
					  </div>
				  </div>
            </div>				
			
			<div class="card card-default">
				<div class="card-header">
					<h3 class="card-title">Rute Travel Kembali</h3>
				</div>
				  <div class="card-body">
					  <div class="row">
						<div class="col-sm-4">
							<div wire:ignore class="form-group">
								<select wire:model="travelDestiFromBack" id="travelDestiFromBackId" class="select2 form-control" onchange='Livewire.emit("selectTravelDestiFromBack", this.value)' placeholder="Dari">
									<option value="" selected="selected">Pilih Keberangkatan</option>
									@foreach($destinations as $item)
										<option value="{{$item->id}}">{{$item->name}}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="col-sm-4">
							<div  wire:ignore class="form-group">
								<select wire:model="travelDestiToBack" id="travelDestiToBackId" class="select2 form-control" onchange='Livewire.emit("selectTravelDestiToBack", this.value)' placeholder="Tujuan">
									<option value="" selected="selected">Pilih Tujuan</option>
									@foreach($destinations as $item)
										<option value="{{$item->id}}">{{$item->name}}</option>
									@endforeach
								</select>
							</div>
						</div>					  
						<div class="col-sm-4">
							<div  class="form-group">
							  <div class="input-group date" data-provide="datepicker">
								<div class="input-group-prepend">
								  <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
								</div>
								<input wire:model="travelDateFromBack" type="text" id="travelDateFromBackId" class="form-control" onchange='Livewire.emit("selectTravelDateFromBack", this.value)' placeholder="Tanggal kembali ..." autocomplete="off">
							  </div>
							</div>
						</div>					
					  </div>
				  </div>
            </div>
		@endif	
			
            <div class="row">
              <div class="col-12 col-sm-8">
                <div class="form-group">
				<label>Keterangan Tambahan</label>
					<textarea wire:model="description" type="text" id="descriptionId" class="form-control" placeholder="Keterangan"></textarea>
                </div>
              </div>
						<div class="col-sm-4">
							<div  class="form-group">
							<label>Tanggal On Site</label>
							  <div class="input-group date" data-provide="datepicker">
								<div class="input-group-prepend">
								  <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
								</div>
								<input wire:model="onSiteDate" type="text" id="onSiteDateId" class="form-control" onchange='Livewire.emit("selectOnSiteDate", this.value)' placeholder="Mulai bekerja ..." autocomplete="off" disabled="disabled">
							  </div>
							</div>
						</div>				  
            </div>
			<span class="invalid-feedback select2Error" role="alert">
			@if ($errors->any())
				<div class="alert alert-danger">
					@foreach ($errors->all() as $error)
					   {{ $error }} , 
					@endforeach
				</div>
			@endif	
		</span>		
        </div>   
        <div class="modal-footer justify-content-between">
			<button wire:click="cancel" onclick="clearSelect2()" type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
			<button type="submit" class="btn btn-primary"><i class="fa fa-tasks"></i> Mengajukan Cuti</button>
        </div>
		@endif
		</form>
      </div>
    
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
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
    $('.select2').select2()

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
		field: document.getElementById('annualLeaveStartDateId'),
		format: 'DD/MM/YYYY',
	});
	
	var picker7 = new Pikaday({
		field: document.getElementById('annualLeaveEndDateId'),
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
