<div wire:ignore.self class="modal fade" id="notApprovModal" role="dialog" aria-labelledby="myModalLabel77" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
      <div class="modal-content bg-warning">
        <div class="modal-header">
          <h4 class="modal-title">Tidak Menyetujui Pengajuan</h4>
          <button wire:click="cancel" type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        
        <div class="modal-body">
		<form wire:submit.prevent="notApprovStore">
            <p>Apakah Anda yakin?  tidak menyetujui pengajuan tugas/training sodara <strong>{{$name}} </strong> dengan NRP:<strong>{{$nrp}}</strong> Jabatan/Departemen <strong>{{$position}} / {{$department}}</strong></p>		
			
			<p>Jika Anda tidak melanjutkan proses ini, silahkan klik tombol <strong>Batal</strong></p>
			
			<p>Jika Anda yakin, silahkan klik tombol <strong>Tidak setuju</strong></p>
			<textarea wire:model="reason" class="form-control @error('reason') is-invalid @enderror" placeholder="Isi alasan tidak menyetujui ..." ></textarea>
			@error('reason')
				<span class="invalid-feedback" role="alert">
					{{ $message }}
				</span>
			@enderror	
		</div>
   
        <div class="modal-footer justify-content-between">
          <button wire:click="cancel" type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
		 		  
          <button type="submit" class="btn btn-info"><i class="fa fa-ban"></i> Tidak Setuju</button>
        </div></form>
      </div>
    
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>