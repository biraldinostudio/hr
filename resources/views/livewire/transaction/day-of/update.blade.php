
<div class="content-wrapper"> 
 <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Cuti Job Site</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('home')}}">Beranda</a></li>
              <li class="breadcrumb-item active">Cuti Job Site</li>
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
                <h3 class="card-title">Cuti Job Site</h3>
              </div>

              <form wire:submit.prevent="update" name="crtForm">
                <div class="card-body">
				<div class="row">
					<p style="font-size:12px;color:#ff0000;">Harap diperhatikan, setiap mengubah cuti job site, maka data pengajuan cuti tahunan dan cuti besar yang berkaitan dengan pengajuan cuti job site ini akan direset otomatis oleh sistem. Jadi Anda akan melakukan pengajuan ulang cuti tahunan dan cuti besar.
				</p>
				</div>
				<div class="card card-info">
				  <div class="card-body">
					  <div class="row">
						<div class="col-sm-6">
						  <div class="form-group">
							<label>Rencana</label>
					  <div class="input-group date" data-provide="datepicker">
						<div class="input-group-prepend">
						  <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
						</div>
						<input wire:model="planDate" type="text" id="planDateId" class="form-control" onchange='Livewire.emit("selectPlanDate", this.value)' placeholder="Rencana cuti ..." autocomplete="off">
					  </div>
						  </div>
						</div>						
					  </div>
				  </div>
				</div>
				<div class="card card-info">
				  <div class="card-header">
					<h3 class="card-title">Rute Tiket Keberangkatan</h3>
				  </div>
				  <div class="card-body">
					  <div class="row">
						<div class="col-sm-6">
						  <div wire:ignore class="form-group">
							<label>Keberangkatan</label>
								<select wire:model="ticketDestiFromGo" id="ticketDestiFromGoId" class="select2 form-control" onchange='Livewire.emit("selectTicketDestiFromGo", this.value)' placeholder="Dari">
									<option value="" @if (old('ticketDestiFromGo',$ticketDestiFromGo)=='' or old('ticketDestiFromGo',$ticketDestiFromGo)==0)selected="selected"@endif> Pilih Keberangkatan </option>
									@foreach ($destinations as $item)
										<option value="{{ $item->id}}"@if (old('ticketDestiFromGo',$ticketDestiFromGo)==$item->id)selected="selected" @endif> {{ $item->name }} </option>
									@endforeach
								</select>
						  </div>
						</div>
						<div class="col-sm-6">
						  <div wire:ignore class="form-group">
							<label>Tujuan</label>
								<select wire:model="ticketDestiToGo" id="ticketDestiToGoId" class="select2 form-control" onchange='Livewire.emit("selectTicketDestiToGo", this.value)' placeholder="Tujuan">
									<option value="" @if (old('ticketDestiToGo',$ticketDestiToGo)=='' or old('ticketDestiToGo',$ticketDestiToGo)==0)selected="selected"@endif> Pilih Tujuan </option>
									@foreach ($destinations as $item)
										<option value="{{ $item->id}}"@if (old('ticketDestiToGo',$ticketDestiToGo)==$item->id)selected="selected" @endif> {{ $item->name }} </option>
									@endforeach
								</select>
						  </div>
						</div>
					  </div>
					  <div class="row">
						<div class="col-sm-6">
						  <div class="form-group">
							<label>Tanggal</label>
								<div class="input-group date" data-provide="datepicker">
									<div class="input-group-prepend">
									  <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
									</div>																
									<input wire:model="ticketDateFromGo" type="text" id="ticketDateFromGoId" class="form-control" onchange='Livewire.emit("selectTicketDateFromGo", this.value)' placeholder="Tanggal berangkat ..." autocomplete="off">
								</div>
						  </div>
						</div>
						<div class="col-sm-6">
						  <div class="form-group">
							<label>Jam</label>
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
				
				<div class="card card-info">
				  <div class="card-header">
					<h3 class="card-title">Rute Tiket Kembali</h3>
				  </div>
				  <div class="card-body">
					  <div class="row">
						<div class="col-sm-6">
						  <div wire:ignore class="form-group">
							<label>Keberangkatan</label>
								<select wire:model="ticketDestiFromBack" id="ticketDestiFromBackId" class="select2 form-control" onchange='Livewire.emit("selectTicketDestiFromBack", this.value)' placeholder="Dari">
									<option value="" @if (old('ticketDestiFromBack',$ticketDestiFromBack)=='' or old('ticketDestiFromBack',$ticketDestiFromBack)==0)selected="selected"@endif> Pilih Keberangkatan </option>
									@foreach ($destinations as $item)
										<option value="{{ $item->id}}"@if (old('ticketDestiFromBack',$ticketDestiFromBack)==$item->id)selected="selected" @endif> {{ $item->name }} </option>
									@endforeach
								</select>
						  </div>
						</div>
						<div class="col-sm-6">
						  <div wire:ignore class="form-group">
							<label>Tujuan</label>
								<select wire:model="ticketDestiToBack" id="ticketDestiToBackId" class="select2 form-control" onchange='Livewire.emit("selectTicketDestiToBack", this.value)' placeholder="Tujuan">
									<option value="" @if (old('ticketDestiToBack',$ticketDestiToBack)=='' or old('ticketDestiToBack',$ticketDestiToBack)==0)selected="selected"@endif> Pilih Tujuan </option>
									@foreach ($destinations as $item)
										<option value="{{ $item->id}}"@if (old('ticketDestiToBack',$ticketDestiToBack)==$item->id)selected="selected" @endif> {{ $item->name }} </option>
									@endforeach
								</select>
						  </div>
						</div>
					  </div>
					  <div class="row">
						<div class="col-sm-6">
						  <div class="form-group">
							<label>Tanggal</label>
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
							<label>Jam</label>
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
				
				<div class="card card-info">
				  <div class="card-header">
					<h3 class="card-title">Cuti Job Site</h3>
				  </div>
				  <div class="card-body">
					  <div class="row">
						<div class="col-sm-6">
						  <div class="form-group">
							<label>Tanggal Mulai</label>
							  <div class="input-group date" data-provide="datepicker">
								<div class="input-group-prepend">
								  <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
								</div>
								<input wire:model="startDate" type="text" id="startDateId" class="form-control" onchange='Livewire.emit("selectStartDate", this.value)' placeholder="Mulai cuti ..." disabled="disabled" autocomplete="off">
							  </div>
						  </div>
						</div>
						<div class="col-sm-6">
						  <div class="form-group">
							<label>Tanggal Selesai</label>
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
				
				
				<div class="card card-info">
				  <div class="card-header">
					<h3 class="card-title">Rute Travel Keberangkatan</h3>
				  </div>
				  <div class="card-body">
					  <div class="row">
						<div class="col-sm-4">
						  <div wire:ignore class="form-group">
							<label>Keberangkatan</label>
								<select wire:model="travelDestiFromGo" id="travelDestiFromGoId" class="select2 form-control" onchange='Livewire.emit("selectTravelDestiFromGo", this.value)' placeholder="Dari">
									<option value="" @if (old('travelDestiFromGo',$travelDestiFromGo)=='' or old('travelDestiFromGo',$travelDestiFromGo)==0)selected="selected"@endif> Pilih Keberangkatan </option>
									@foreach ($destinations as $item)
										<option value="{{ $item->id}}"@if (old('travelDestiFromGo',$travelDestiFromGo)==$item->id)selected="selected" @endif> {{ $item->name }} </option>
									@endforeach
								</select>
						  </div>
						</div>
						<div class="col-sm-4">
						  <div wire:ignore class="form-group">
							<label>Tujuan</label>
								<select wire:model="travelDestiToGo" id="travelDestiToGoId" class="select2 form-control" onchange='Livewire.emit("selectTravelDestiToGo", this.value)' placeholder="Tujuan">
									<option value="" @if (old('travelDestiToGo',$travelDestiToGo)=='' or old('travelDestiToGo',$travelDestiToGo)==0)selected="selected"@endif> Pilih Tujuan </option>
									@foreach ($destinations as $item)
										<option value="{{ $item->id}}"@if (old('travelDestiToGo',$travelDestiToGo)==$item->id)selected="selected" @endif> {{ $item->name }} </option>
									@endforeach
								</select>
						  </div>
						</div>
						<div class="col-sm-4">
						  <!-- textarea -->
						  <div class="form-group">
							<label>Tanggal</label>
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
				<div class="card card-info">
				  <div class="card-header">
					<h3 class="card-title">Rute Travel Kembali</h3>
				  </div>
				  <div class="card-body">
					  <div class="row">
						<div class="col-sm-4">
						  <div wire:ignore class="form-group">
							<label>Keberangkatan</label>
								<select wire:model="travelDestiFromBack" id="travelDestiFromBackId" class="select2 form-control" onchange='Livewire.emit("selectTravelDestiFromBack", this.value)' placeholder="Dari">
									<option value="" @if (old('travelDestiFromBack',$travelDestiFromBack)=='' or old('travelDestiFromBack',$travelDestiFromBack)==0)selected="selected"@endif> Pilih Keberangkatan </option>
									@foreach ($destinations as $item)
										<option value="{{ $item->id}}"@if (old('travelDestiFromBack',$travelDestiFromBack)==$item->id)selected="selected" @endif> {{ $item->name }} </option>
									@endforeach
								</select>
						  </div>
						</div>
						<div class="col-sm-4">
						  <div wire:ignore class="form-group">
							<label>Tujuan</label>
								<select wire:model="travelDestiToBack" id="travelDestiToBackId" class="select2 form-control" onchange='Livewire.emit("selectTravelDestiToBack", this.value)' placeholder="Dari">
									<option value="" @if (old('travelDestiToBack',$travelDestiToBack)=='' or old('travelDestiToBack',$travelDestiToBack)==0)selected="selected"@endif> Pilih Tujuan </option>
									@foreach ($destinations as $item)
										<option value="{{ $item->id}}"@if (old('travelDestiToBack',$travelDestiToBack)==$item->id)selected="selected" @endif> {{ $item->name }} </option>
									@endforeach
								</select>	
						  </div>
						</div>
						<div class="col-sm-4">
						  <!-- textarea -->
						  <div class="form-group">
							<label>Tanggal</label>
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
				
				
				<div class="row">
					<div class="col-12 col-sm-8">
					  <div wire:ignore class="form-group">
						<label>Keterangan</label>
					<textarea wire:model="description" type="text" id="descriptionId" class="form-control" placeholder="Keterangan"></textarea>
					  </div>					
					</div>

					<div class="col-md-4">
						<div class="form-group">
						<label>Tanggal Bekerja/Induksi</label>
								<input wire:model="onSiteDate" type="text" id="onSiteDateId" class="form-control" onchange='Livewire.emit("selectOnSiteDate", this.value)' placeholder="Mulai bekerja ..." autocomplete="off" disabled="disabled">
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
				  <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan Data</button>
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