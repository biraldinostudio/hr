<div wire:ignore.self class="modal fade" id="deleteModal" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Non Aktifkan Data</h4>
          <button wire:click="cancel" type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form wire:submit.prevent="delete">
        <div class="modal-body" style="overflow: visible;">
            <p>Apakah kamu yakin? non aktifkan <strong>({{$nrp}}) {{$employee}}</strong> sebagai <b>Administrator </b> di aplikasi ini ? <br><br> Jika melanjutkan proses ini, maka peran yang bersangkutan di aplikasi ini level user akan berubah menjadi level karyawan biasa tanpa merubah jabatannya.</p>
        </div>
   
        <div class="modal-footer justify-content-between">
          <button wire:click="cancel" type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary"><i class="fa fa-ban"></i> Non Aktifkan</button>
        </div></form>
      </div>
    
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>