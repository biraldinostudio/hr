<div wire:ignore.self class="modal fade text-left" id="createModalPermissionCategory" tabindex="-1"role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">Tambah Data </h4>
          <button wire:click="cancel" type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
            </div>
            <form wire:submit.prevent="store">
			@csrf
                <div class="modal-body">
                    <div wire:ignore class="form-group">
							<label>Jenis Izin</label>						
							<select wire:model="type" class="form-control" onchange='Livewire.emit("selectType", this.value)'>
								<option value="" data-type=""@if (request('type')=='' or request('type')=='')selected="selected" @endif>Pilih Jenis Izin</option>
								<option value="Official" @if (old('type') == 'Official') selected="selected" @endif>Resmi</option>
								<option value="CutAnnualLeave" @if (old('type') == 'CutAnnualLeave') selected="selected" @endif>Potong Cuti Tahunan</option>
								<option value="CutBasicSalary" @if (old('type') == 'CutBasicSalary') selected="selected" @endif>Potong Gaji Pokok </option>
							</select>
                    </div>				
                    <label>Deskripsi Izin: </label>
                    <div class="form-group">
                        <input wire:model="name" type="text" placeholder="Deskripsi izin ..." class="form-control" maxlength="100">
                    </div>
                    <label>Jml Hari: </label>
                    <div class="form-group">
                        <input wire:model="day" type="text" placeholder="Jml hari ..." class="form-control" maxlength="2">
                    </div>
                </div>
				<div class="row">
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
					  <button wire:click="cancel" type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-window-close"></i> Batal</button>
					  <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan Data</button>
				</div>
            </form>
        </div>
    </div>
</div>    