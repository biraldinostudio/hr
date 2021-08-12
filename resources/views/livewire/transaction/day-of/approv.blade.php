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

						<tr><td><strong>Nama / NRP</strong></td><td>: {{$employee}} ({{$nrp}})</td></tr>
						<tr><td><strong>Jabatan / Departemen</strong></td><td>: {{$position}} /{{$department}}</td></tr>						
						<tr><td><strong>Tiket keberangkatan</strong></td><td>: {{$ticketDateFromGo}} ({{$ticketTimeGo}})</td></tr>
						<tr><td><strong>Tiket kembali</strong></td><td>: {{$ticketDateFromBack}} ({{$ticketTimeBack}}) </td></tr>
						<tr><td><strong>Travel Berangkat</strong></td><td>: {{$travelDateFromGo}}</td></tr>
						<tr><td><strong>Travel Kembali</strong></td><td>: {{$travelDateFromBack}}</td></tr>
						<tr><td><strong>Cuti Job Site</strong></td><td>: {{$startDate}}- {{$endDate}} ({{$dayOfSum}} hari)</td></tr>
						<tr><td><strong>Keterangan</strong></td><td>: {{Str::limit($description,200)}}</td></tr>						
						
						@if($annualLeaveStartDate!=null)
								<tr><td><strong>Cuti Tahunan</strong></td><td>: {{$annualLeaveStartDate}} - {{$annualLeaveEndDate}} </td></tr>	
						<tr><td><strong>Standart Cuti Tahunan</strong></td><td>: {{$annualLeaveStandartDay}} Hari</td></tr>						
						<tr><td><strong>Sisah Cuti Tahunan</strong></td><td>: {{$annualLeaveLess}} Hari</td></tr>					
						@endif
						@if($bigLeaveStartDate!=null)
								<tr><td><strong>Cuti Besar</strong></td><td>: {{$bigLeaveStartDate}} - {{$bigLeaveEndDate}} </td></tr>								
						<tr><td><strong>Standart Cuti Besar</strong></td><td>: {{$bigLeaveStandartDay}} Hari</td></tr>						
						
						<tr><td><strong>Sisah Cuti Besar</strong></td><td>: {{$bigLeaveLess}}  Hari</td></tr>	
						@endif
						<tr><td><strong>Tanggal Masuk/Induksi </strong></td><td>: {{$inDate}}</td></tr>
						<tr><td><strong>Jumlah Hari Tiket</strong></td><td>: Berangkat: {{$dayOfStandartDayTravel}} Hari | Kembali: {{$dayOfStandartDayTravel}} Hari</td></tr>	
						<tr><td><strong>Jumlah Hari Travel </strong></td><td>: Berangkat: {{$dayOfStandartDayTicket}} Hari | Kembali: {{$dayOfStandartDayTicket}} Hari</td></tr>							
					</table>
				</div>
			</div>		
		
		
		<br>
            <p style="font-size:13px;color:#ff0000;"> Persetujuan pengajuan cuti yang sudah Anda berikan tidak akan dibatalkan.</p>Jika Anda yakin, silahkan klik tombol <strong>Setuju</strong> untuk menyetujui</p>
        </div>
   
        <div class="modal-footer justify-content-between">
          <button wire:click="cancel" type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
		  
          <button data-toggle="modal" data-target="#notApprovModal" wire:click="showModalNotApprov({{ $dayOfId }})" type="button" class="btn btn-warning"><i class="fa fa-ban"></i> Tidak Setuju</button>&nbsp;&nbsp;&nbsp;		  
          <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Setuju</button>
        </div></form>
      </div>
    
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>