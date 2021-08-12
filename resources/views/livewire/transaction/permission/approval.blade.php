<div wire:ignore.self class="modal fade" id="approvModal" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Approval Pengajuan</h4>
          <button wire:click="cancel" type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form wire:submit.prevent="approvStore">
        <div class="modal-body" style="overflow: visible;">
		
			<div class="row">
				<div class="col-md-12" style="font-size:13px">
					<table>
						<tr><td><strong>Nama / NRP</strong></td><td>: {{$name}} ({{$nrp}})</td></tr>
						<tr><td><strong>Jabatan / Departemen</strong></td><td>: {{$position}} /{{$department}}</td></tr>
						<tr><td><strong>Tanggal Izin</strong></td><td>: {{$startDate}} - {{$endDate}}</td></tr>
						<tr><td><strong>Jml Hari</strong></td><td @if($sumDay>$permissionCategoryDay)style="color:#ff0000;" @endif>: {{$sumDay}} Hari</td></tr>						
						<tr><td><strong>Tanggal Masuk</strong></td><td>: {{$inDate}}</td></tr>
						<tr><td><strong>Jenis Izin</strong></td><td>:  @if($permissionCategoryType=='Official') Resmi @elseif($permissionCategoryType=='CutAnnualLeave') Potong Cuti Tahunan @elseif($permissionCategoryType=='CutBasicSalary') Potong Gapok @else @endif</td></tr>						
						@if($permissionCategoryType=='Official')<tr><td><strong>Deskripsi Izin</strong></td><td>:  {{$permissionCategoryName}}</td></tr>
						<tr><td><strong>Hak Hari Izin</strong></td><td @if($sumDay>$permissionCategoryDay)style="color:#ff0000;" @endif>: {{$permissionCategoryDay}} Hari</td></tr>	@endif						
						<tr><td><strong>Keperluan</strong></td><td>: {{Str::limit($description,200)}}</td></tr>					
					</table>
				</div>
			</div>		
		
		
		<br>
            <p> Persetujuan pengajuan izin yang sudah Anda berikan tidak akan dibatalkan.<br><br> Jika Anda yakin, silahkan klik tombol <strong>Setuju</strong> untuk menyetujui</p>
        </div>
   
        <div class="modal-footer justify-content-between">
          <button wire:click="cancel" type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
		  
          <button data-toggle="modal" data-target="#notApprovModal" wire:click="showModalNotApprov({{ $permissionId }})" type="button" class="btn btn-warning"><i class="fa fa-ban"></i> Tidak Setuju</button>&nbsp;&nbsp;&nbsp;		  
          <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Setuju</button>
        </div></form>
      </div>
    
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>