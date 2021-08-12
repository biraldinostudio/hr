<div wire:ignore.self class="modal fade text-left" id="editModalPermissionCategory" tabindex="-1"role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">Ubah Data </h4>
          <button wire:click="cancel" type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
            </div>
            <form wire:submit.prevent="update">
			@csrf
                <div class="modal-body">
                    <div wire:ignore class="form-group">
							<label>Jenis Izin</label>						
							<select wire:model="type" class="form-control" onchange='Livewire.emit("selectType", this.value)'>
								<option value="" data-type=""@if (request('type')=='' or request('type')=='')selected="selected" @endif>Pilih Jenis Izin</option>
								<option value="Official" @if (old('type',$type) == 'Official') selected="selected" @endif>Resmi</option>
								<option value="CutAnnualLeave" @if (old('type',$type) == 'CutAnnualLeave') selected="selected" @endif>Potong Cuti Tahunan</option>
								<option value="CutBasicSalary" @if (old('type',$type) == 'CutBasicSalary') selected="selected" @endif>Potong Gaji Pokok </option>
							</select>
                    </div>					
                    <label>Izin Resmi: </label>
                    <div class="form-group">
                        <input wire:model="name" type="text" placeholder="Izin resmi ..." class="form-control @error('name') is-invalid @enderror" maxlength="100">
                       @error('name')<span class="invalid-feedback" role="alert">{{ $message }}</span>@enderror
                    </div>
                    <label>Jml Hari: </label>
                    <div class="form-group">
                        <input wire:model="day" type="text" placeholder="Jml hari ..." class="form-control @error('day') is-invalid @enderror" maxlength="2">
                       @error('day')<span class="invalid-feedback" role="alert">{{ $message }}</span>@enderror
                    </div>
                </div>
				<div class="modal-footer justify-content-between">
					  <button wire:click="cancel" type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-window-close"></i> Batal</button>
					  <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Ubah Data</button>
				</div>
            </form>
        </div>
    </div>
</div>    