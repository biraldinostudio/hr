<div wire:ignore.self class="modal fade" id="notApprovModal" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
      <div class="modal-content bg-warning">
        <div class="modal-header">
          <h4 class="modal-title">Tidak Menyetujui Pengajuan</h4>
          <button wire:click="cancel" type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form wire:submit.prevent="notApprovStore">
        <div class="modal-body" style="overflow: visible;">
            <p>Apakah Anda yakin? tidak menyetujui pengajuan cuti sodara <strong>{{$name}}</strong> dengan NRP: <strong>({{$nrp}})</strong> jabatan / departemen: <strong>{{$position}} / {{$department}}</strong> job site: <b>{{$site}}</b> ? <br><br> Persetujuan pengajuan cuti yang tidak disetujui tidak akan dibatalkan.<br><br> Jika Anda yakin, silahkan isi alasannya dan klik tombol <strong>Tidak Setuju</strong></p>		
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