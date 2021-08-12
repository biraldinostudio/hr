<div wire:ignore.self class="modal fade text-left" id="editModal" tabindex="-1"role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">Ubah Data </h4>
                <button type="button" class="close" wire:click="cancel" data-dismiss="modal" aria-label="Close"><i data-feather="x"></i></button>
            </div>
            <form wire:submit.prevent="update">
                <div class="modal-body">
                    <label>Kode Departemen: </label>
                    <div class="form-group">
                        <input wire:model="code" id="code" type="text" placeholder="Tuliskan kode site ..." class="form-control @error('code') is-invalid @enderror" maxlength="5">
                        @error('code')<span class="invalid-feedback" role="alert">{{ $message }}</span>@enderror
                    </div>
                    <label>Nama Departemen: </label>
                    <div class="form-group">
                        <input wire:model="name" type="text" placeholder="Tuliskan nama site ..." class="form-control @error('name') is-invalid @enderror" maxlength="40">
                        @error('name')<span class="invalid-feedback" role="alert">{{ $message }}</span>@enderror
                    </div>
                    <label>Status: </label>
                    <div class="form-group">
                        <select wire:model="status" class="form-control">
                            <option value="" @if (old('status')=='')selected="disabled"@endif> Pilih Status</option>
                            <option value="1" @if(old('status','status') == '1')selected="selected"@endif>Aktif</option>
                            <option value="0" @if(old('status','status') == '0')selected="selected"@endif>Non Aktif</option>												
                        </select>
                        @error('status') <span class="pesanError">{{$message}}</span>@enderror
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
@push('scripts')
	<script>
		$('#editModal').on('shown.bs.modal', function () {
			$('#code').focus();
		})
	</script>  
@endpush