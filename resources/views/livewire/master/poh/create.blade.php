<div wire:ignore.self class="modal fade" id="createModal" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Tambah Data</h4>
          <button wire:click="cancel" type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form wire:submit.prevent="store">
        <div class="modal-body" style="overflow: visible;">
            <label>POH: </label>
            <div class="form-group">
                <input wire:model="name" id="name" type="text" placeholder="Tuliskan nama POH ..." class="form-control @error('name') is-invalid @enderror">
                @error('name')<span class="invalid-feedback" role="alert">{{ $message }}</span>@enderror
            </div>
        </div>
   
        <div class="modal-footer justify-content-between">
          <button wire:click="cancel" type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan Data</button>
        </div></form>
      </div>
    
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
@push('scripts')
	<script>
		$('#createModal').on('shown.bs.modal', function () {
			$('#name').focus();
		})
	</script>  
@endpush