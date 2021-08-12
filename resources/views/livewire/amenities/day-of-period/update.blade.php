<div wire:ignore.self class="modal fade" id="editModal" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Ubah Data</h4>
          <button wire:click="cancel" onclick="clearSelect2()" type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form wire:submit.prevent="update">
        <div class="modal-body" style="overflow: visible;">
            <div class="row">
              <div class="col-md-12">
					<label>Period @if($staff=='1') Staff (Hari) @else Non Staff (Hari): @endif </label>
					<div class="form-group">
						<input wire:model="day" type="text" placeholder="Haru ..." class="form-control" maxlength="2">
					</div>
              </div>
            </div>


        </div>
   
        <div class="modal-footer justify-content-between">
          <button wire:click="cancel" onclick="clearSelect2()" type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Ubah Data</button>
        </div></form>
      </div>
    
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>