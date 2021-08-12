<div class="content-wrapper"> 
 <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Ubah Data</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('home')}}">Beranda</a></li>
              <li class="breadcrumb-item active">Pengajuan Izin</li>
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
                <h3 class="card-title">Pengajuan Izin</h3>
              </div>
              <form wire:submit.prevent="update" name="crtForm">
                <div class="card-body">
				<div class="row">
					<div class="col-md-12">
						<div wire:ignore class="form-group">
							<label>Jenis Izin</label>						
								<select wire:model="permissionCategory" id="permissionCategoryId" class="select2 form-control" onchange='Livewire.emit("selectPermissionCategory", this.value)' placeholder="Jenis Izin">
									<option value="" @if (old('permissionCategory',$permissionCategory)=='' or old('permissionCategory',$permissionCategory)==0)selected="selected"@endif> Pilih Jenis Izin </option>
									@foreach ($permissionCategories as $item)
										<option value="{{ $item->id}}"@if (old('permissionCategory',$permissionCategory)==$item->id)selected="selected" @endif> {{ $item->name }} </option>
									@endforeach
								</select>								
						</div>					
					</div>					
					<div class="col-md-6">
					  <div class="form-group">
						<label>Tanggal Mulai</label>
							  <div class="input-group date" data-provide="datepicker">
								<div class="input-group-prepend">
								  <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
								</div>
								<input wire:model="startDate" type="text" id="startDateId" class="form-control" onchange='Livewire.emit("selectStartDate", this.value)' placeholder="Tanggal mulai ..." autocomplete="off">
							  </div>
					  </div>					
					</div>
					<div class="col-md-6">
					  <div class="form-group">
						<label>Tanggal Selesai</label>
							  <div class="input-group date" data-provide="datepicker">
								<div class="input-group-prepend">
								  <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
								</div>
								<input wire:model="endDate" type="text" id="endDateId" class="form-control" onchange='Livewire.emit("selectEndDate", this.value)' placeholder="Tanggal selesai ..." autocomplete="off">
							  </div>
					  </div>					
					</div>
					<div class="col-md-12 col-sm-12">
						<div class="form-group">
						<label>Keterangan</label>
					<textarea wire:model="description" type="text" id="descriptionId" class="form-control" placeholder="Keterangan"></textarea>						
						</div>					
					</div>						
					<div class="col-md-6">
						<div class="form-group">
						<label>Masuk Kerja</label>
							  <div class="input-group date" data-provide="datepicker">
								<div class="input-group-prepend">
								  <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
								</div>
								<input wire:model="inDate" type="text" id="inDateId" class="form-control" onchange='Livewire.emit("selectInDate", this.value)' placeholder="Masuk bekerja ..." autocomplete="off" disabled="disabled">
							  </div>						
						</div>					
					</div>
									

					<div class="col-md-6">
						<div wire:ignore class="form-group">
						<label>Status</label>
				         <select wire:model="status" class="form-control">
                            <option value="" @if (old('status',$status)=='')selected="disabled"@endif> Pilih Status</option>
                            <option value="1" @if(old('status',$status) == '1')selected="selected"@endif>Aktif</option>
                            <option value="0" @if(old('status',$status) == '0')selected="selected"@endif>Non Aktif</option>												
                        </select>
						
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
                  <a href="{{route('my-permission')}}" type="button" class="btn btn-default" data-dismiss="modal">Tutup</a>&nbsp;&nbsp;&nbsp;&nbsp;
				  <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Ubah Data</button>
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
