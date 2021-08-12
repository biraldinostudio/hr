<div wire:ignore.self class="modal fade" id="createModal" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Pengajuan Izin</h4>
          <button wire:click="cancel" onclick="clearSelect2()" type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
       
        <div class="modal-body">
		 <form wire:submit.prevent="store" name="crtForm">
		 @csrf
		 
			@if($latestPermissionOpen==0)

					  <div class="row">
						<div class="col-sm-12">
							<div wire:ignore class="form-group">
							<label>Jenis Izin</label>							
								<select wire:model="permissionCategory" id="permissionCategoryId" class="select2 form-control" onchange='Livewire.emit("selectPermissionCategory", this.value)' placeholder="Jenis Izin">
									<option value="" selected="selected">Pilih jenis izin</option>
									@foreach($permissionCategories as $item)
										<option value="{{$item->id}}">@if($item->official=='1') Resmi - @else Tidak Resmi -  @endif{{$item->name}}</option>
									@endforeach
								</select>
							</div>
						</div>
					</div>
					<div class="row">					
						<div class="col-sm-6">
							<div class="form-group">							
							<label>Tgl Mulai</label>
							  <div class="input-group date" data-provide="datepicker">
								<div class="input-group-prepend">
								  <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
								</div>
								<input wire:model="startDate" type="text" id="startDateId" class="form-control" onchange='Livewire.emit("selectStartDate", this.value)' placeholder="Tanggal mulai ..." autocomplete="off">
							  </div>
							</div>
						</div>
						<div class="col-sm-6">
							<div  class="form-group">
							<label>Tgl Selesai</label>					
							  <div class="input-group date" data-provide="datepicker">
								<div class="input-group-prepend">
								  <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
								</div>
								<input wire:model="endDate" type="text" id="endDateId" class="form-control" onchange='Livewire.emit("selectEndDate", this.value)' placeholder="Tanggal selesai ..." autocomplete="off">
							  </div>
							</div>
						</div>					
					  </div>
					<div class="row">
						<div class="col-sm-6">
							<div  class="form-group">
							<label>Tanggal On Site</label>
							  <div class="input-group date" data-provide="datepicker">
								<div class="input-group-prepend">
								  <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
								</div>
								<input wire:model="inDate" type="text" id="inDateId" class="form-control" onchange='Livewire.emit("selectInDate", this.value)' placeholder="Masuk bekerja ..." autocomplete="off" disabled="disabled">
							  </div>
							</div>
						</div>						
					</div>
			
				<div class="row">
				  <div class="col-12 col-sm-12">
					<div class="form-group">
					<label>Keperluan</label>
						<textarea wire:model="description" type="text" id="descriptionId" class="form-control" placeholder="Keperluan izin..."></textarea>
					</div>
				  </div>
				</div>
				{{--
					<div class="row">
						<div class="col-sm-6">
							<div  class="form-group">
							<label>Penginapan (Hari)</label>
								<input wire:model="lodging" type="text" class="form-control" placeholder="Jml hari..." maxlength="2">
							</div>
						</div>
					  <div class="col-sm-6">
						<div class="form-group">
							<label>Penginapan (Rp)</label>						
								<input wire:model="lodgingIDR" type="text" class="form-control" type-currency="IDR" placeholder="Rp penginapan..." maxlength="13">
						</div>
					  </div>						
					</div>

					<div class="row">
						<div class="col-sm-6">
							<div  class="form-group">
							<label>Transportasi (Hari)</label>
								<input wire:model="transportation" type="text" class="form-control" placeholder="Jml hari..." maxlength="2">
							</div>
						</div>
					  <div class="col-sm-6">
						<div class="form-group">
							<label>Transportasi (Rp)</label>						
								<input wire:model="transportationIDR" type="text" class="form-control" type-currency="IDR" placeholder="Rp transportasi..." maxlength="13">
						</div>
					  </div>						
					</div>
					<div class="row">
						<div class="col-sm-6">
							<div  class="form-group">
							<label>Uang Makan (Hari)</label>
								<input wire:model="mealAllowance" type="text" class="form-control" placeholder="Jml hari..." maxlength="2">
							</div>
						</div>
					  <div class="col-sm-6">
						<div class="form-group">
							<label>Uang Makan (Rp)</label>						
								<input wire:model="mealAllowanceIDR" type="text" class="form-control" type-currency="IDR" placeholder="Rp uang makan..." maxlength="13">
						</div>
					  </div>						
					</div>
					<div class="row">
						<div class="col-sm-6">
							<div  class="form-group">
							<label>Lain (Hari)</label>
								<input wire:model="etc" type="text" class="form-control" placeholder="Jml hari..." maxlength="2">
							</div>
						</div>
					  <div class="col-sm-6">
						<div class="form-group">
							<label>Lain-lain (Rp)</label>						
								<input wire:model="etcIDR" type="text" class="form-control" type-currency="IDR" placeholder="Rp lain-lain..." maxlength="13">
						</div>
					  </div>						
					</div>
				--}}
			
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
			<button type="submit" class="btn btn-primary"><i class="fa fa-tasks"></i> Mengajukan Izin</button>
        </div>
		@else
			Maaf Anda sudah melakukan pengajuan izin dengan nomor <strong>{{$latestPermissionOpenNumber}}</strong> Silahkan cek pengajuan izin tersebut.
			<br><br>Jika pengajuan izin tersebut tidak dilanjutkan, silahkan non aktifkan. Dengan cara non aktifkan melalui menu Edit <i class="fa fa-edit"></i>.
		    
			<br><br><p><strong>Terima kasih</strong>.</p>
        <div class="modal-footer justify-content-between">
			<button wire:click="cancel" onclick="clearSelect2()" type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
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
