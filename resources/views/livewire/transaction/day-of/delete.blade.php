<div wire:ignore.self class="modal fade" id="deleteModal" role="dialog" aria-labelledby="myModalLabel77" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
      <div class="modal-content bg-danger">
        <div class="modal-header">
          <h4 class="modal-title">Tidak Menyetujui Pengajuan</h4>
          <button wire:click="cancel" type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form wire:submit.prevent="deleteDayOf">
        <div class="modal-body" style="overflow: visible;">
		<p><strong>Data yang sudah dihapus tidak dapat dibatalkan atau dikembalikan!</strong></p>
			<p>Apakah Anda yakin menghapus dengan pengajuan cuti? <strong></strong> </p>
			<p>Jika Anda yakin, silahkan klik tombol <strong>Hapus Data</strong></p>
		</div>
   
        <div class="modal-footer justify-content-between">
          <button wire:click="cancel" type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
		 		  
          <button type="submit" class="btn btn-info"><i class="fa fa-trash"></i> Hapus</button>
        </div></form>
      </div>
    
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>