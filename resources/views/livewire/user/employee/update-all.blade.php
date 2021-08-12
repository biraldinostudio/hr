<div wire:ignore.self class="modal fade text-left" id="updateAllModal" tabindex="-1"role="dialog" aria-labelledby="myModalLabel335" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel335">Reset Kata Sandi </h4>
                <button type="button" class="close" wire:click="cancel" data-dismiss="modal" aria-label="Close"><i data-feather="x"></i></button>
            </div>
            <form wire:submit.prevent="resetPasswordAll">	
				<div wire:loading.remove>
					<div class="modal-body">
						<p>Kata sandi reset/default karyawan menggunakan format tanggal lahir ddmmyy. Misal 01 Januri 1994 maka kata sandi default = 010194</p>
						<p style="color:#ff0000;"><strong>Apakah kamu yakin? reset kata sandi semua karyawan?</strong></p>					
					</div>
				<div class="modal-footer justify-content-between">
					  <button wire:click="cancel" type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-window-close"></i> Batal</button>
					  <button type="submit" class="btn btn-primary"><i class="fa fa-lock"></i> Reset Kata Sandi</button>
				</div>
				</div>
				<div wire:loading.inline>
					<div class="modal-body">
						<p style="text-align:center;">
							<img src="{{asset('template/dist/img/progres.gif')}}"></p><br>
						<p style="color:#ff0000;">Mohon menunggu proses sedang berlangsung...Jangan tutup halaman ini tunggu sampai proses selesai!</p>
					<div class="modal-footer justify-content-between">
					  <button wire:click="cancel" type="button" class="btn btn-default" data-dismiss="modal" disabled="disabled"><i class="fa fa-window-close"></i> Batal</button>					
						  <button type="submit" class="btn btn-primary"><i class="fa fa-lock"></i> Reset Kata Sandi</button>
					</div>					
					</div>
				</div>
					
            </form>
        </div>
    </div>
</div>
@push('scripts')
@endpush