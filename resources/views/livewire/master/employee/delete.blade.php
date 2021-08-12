<div wire:ignore.self class="modal fade" id="deleteModal" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Hapus Data</h4>
          <button wire:click="cancel" type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form wire:submit.prevent="delete">
        <div class="modal-body" style="overflow: visible;">
            <p>Apakah kamu yakin? hapus Karyawan "<strong>{{$name}}</strong>"" ?</p>
        </div>
   
        <div class="modal-footer justify-content-between">
          <button wire:click="cancel" type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Hapus Data</button>
        </div></form>
      </div>
    
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>