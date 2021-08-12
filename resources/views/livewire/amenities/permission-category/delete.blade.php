<div wire:ignore.self class="modal fade text-left" id="deleteModalPermissionCategory" tabindex="-1"role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">Hapus Data </h4>
                <button type="button" class="close" wire:click="cancel" data-dismiss="modal" aria-label="Close"><i data-feather="x"></i></button>
            </div>
            <form wire:submit.prevent="delete">
                <div class="modal-body">
                    <p>Apakah kamu yakin? hapus izn resmi <strong>{{$name}}</strong> ?</p>
                </div>
				<div class="modal-footer justify-content-between">
					  <button wire:click="cancel" type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-window-close"></i> Batal</button>
					  <button type="submit" class="btn btn-primary"><i class="fa fa-trash"></i> Hapus Data</button>
				</div>
            </form>
        </div>
    </div>
</div>    