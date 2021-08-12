
<div wire:ignore.self class="modal fade" id="approvModal" role="dialog" aria-labelledby="myModalLabel95" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Approval Pengajuan Tugas/Training {{$employeeLevel}}</h4>
          <button wire:click="cancel" onclick="clearSelect2()" type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        
        <div class="modal-body">
		<form wire:submit.prevent="approvStore" name="crtForm">
			<div class="row">
				<div class="col-md-6" style="font-size:13px">
					<table>
						<tr><td><strong>Nama / NRP</strong></td><td>: {{$name}} ({{$nrp}})</td></tr>
						<tr><td><strong>Jabatan / Departemen</strong></td><td>: {{$position}} /{{$department}}</td></tr>
						<tr><td><strong>Tanggal Izin</strong></td><td>: {{$startDate}} - {{$endDate}}</td></tr>
						<tr><td><strong>Jml Hari</strong></td><td>: {{$sumDay}} Hari</td></tr>							
						<tr><td><strong>Tanggal Masuk</strong></td><td>: {{$inDate}}</td></tr>										
						<tr><td><strong>Keperluan</strong></td><td>: {{Str::limit($description,200)}}</td></tr>
						<tr><td><strong>Area Tugas</strong></td><td>: @if($location=='inSite') Area Site @endif @if($location=='inRegional') Area Regional @endif @if($location=='outRegional') Luar Regional @endif</td></tr>						
						@if($location=='inSite')
						<tr><td><strong>Biaya Makan</strong></td><td>: {{$mealCostTotal}}</td></tr>
						<tr><td><strong>Biaya Lain2</strong></td><td>: {{$otherCostTotal}}</td></tr>
						<tr><td><strong>Total Biaya</strong></td><td>: <strong>{{$costGrandTotal}}</strong></td></tr>
						@endif						
						@if($location!='inSite')
						<tr><td><strong>Biaya Penginapan</strong></td><td>: {{$lodgingCostTotal}} </td></tr>
						<tr><td><strong>Biaya Transport</strong></td><td>: {{$transportCostTotal}}</td></tr>
						<tr><td><strong>Biaya Makan</strong></td><td>: {{$mealCostTotal}}</td></tr>
						<tr><td><strong>Biaya Lain2</strong></td><td>: {{$otherCostTotal}}</td></tr>
						<tr><td><strong>Total Biaya</strong></td><td>: <strong>{{$costGrandTotal}}</strong></td></tr>
						@endif
						
						@if($location=='outRegional')
						<tr><td><strong>Tiket Keberangkatan</strong></td><td>: {{$destinationFromGoTicket}} - {{$destinationToGoTicket}} ({{$ticketDateFromGo}} {{$ticketTimeGo}})</td></tr>
						<tr><td><strong>Tiket Kembali</strong></td><td>: {{$destinationFromBackTicket}} - {{$destinationToBackTicket}} ({{$ticketDateFromBack}} {{$ticketTimeBack}})</td></tr>
						@endif
						@if($location=='inRegional' or $location=='outRegional')
						<tr><td><strong>Travel Keberangkatan</strong></td><td>: {{$destinationFromGoTravel}} - {{$destinationToGoTravel}} ({{$travelDateFromGo}})</td></tr>
						<tr><td><strong>Travel Kembali</strong></td><td>: {{$destinationFromBackTravel}} - {{$destinationToBackTravel}} ({{$travelDateFromBack}})</td></tr>
						@endif							
					</table>
				</div>
		@if($location!='inSite')
					
			<div class="col-md-6" style="font-size:13px">
                    <div class="form-group clearfix">
                      <div class="icheck-success d-inline">
                        <input wire:model="change" name="change"  type="checkbox" id="checkboxSuccess1" value="change">
                        <label for="checkboxSuccess1">
							Ubah biaya akomodasi?
                        </label>
                      </div>

                    </div>
		@if($employeeLevel=='employee' and Auth::user()->position->department->id==$departmentId or $employeeLevel=='hrd_admin' and Auth::user()->position->department->id==$departmentId or $employeeLevel=='department_head' and Auth::user()->level=='site_manager' or $employeeLevel=='site_manager' and Auth::user()->level=='site_manager')
			
          <div wire:ignore  id="dvPassport"class="col-sm-6 col-md-12 row change box" style="display:none;">
				  <div class="row">
					   <div class="col-6">
							<div class="form-group">
								<label>Jml Hari Penginapan:</label>	
								<input wire:model="lodgingDay" class="form-control" type="text" placeholder="Jml hari penginapan..." maxlength="2">
							</div>
						</div>
					   <div class="col-6">
							<div class="form-group">
								<label>(Rp)Perhari Penginapan:</label>
								<input wire:model="lodgingCost" type="text" class="form-control" type-currency="IDR" placeholder="Rp Biaya penginapan ..." maxlength="13">
							</div>
						</div>					
					</div>
				  <div class="row">
					   <div class="col-6">
							<div class="form-group">
								<label>Jml Hari Transportasi:</label>	
								<input wire:model="transportDay" class="form-control" type="text" placeholder="Jml hari transportasi..." maxlength="2">
							</div>
						</div>
					   <div class="col-6">
							<div class="form-group">
								<label>(Rp)Perhari Transportasi:</label>
								<input wire:model="transportCost" type="text" class="form-control" type-currency="IDR" placeholder="Rp Biaya transportasi ..." maxlength="13">
							</div>
						</div>					
					</div>
				  <div class="row">
					   <div class="col-6">
							<div class="form-group">
								<label>Jml Hari Makan:</label>	
								<input wire:model="mealDay" class="form-control" type="text" placeholder="Jml hari makan..." maxlength="2">
							</div>
						</div>
					   <div class="col-6">
							<div class="form-group">
								<label>(Rp)Perhari Makan:</label>
								<input wire:model="mealCost" type="text" class="form-control" type-currency="IDR" placeholder="Rp Biaya makan ..." maxlength="13">
							</div>
						</div>					
					</div>
				  <div class="row">
					   <div class="col-6">
							<div class="form-group">
								<label>Jml Hari Lain2:</label>	
								<input wire:model="otherDay" class="form-control" type="text" placeholder="Jml hari lain2..." maxlength="2">
							</div>
						</div>
					   <div class="col-6">
							<div class="form-group">
								<label>(Rp)Perhari Lain:</label>
								<input wire:model="otherCost" type="text" class="form-control" type-currency="IDR" placeholder="Rp Biaya lain2 ..." maxlength="13">
							</div>
						</div>					
					</div>			
          </div>					
				
				<div class="row">
					<div class="col-sm-12">
				
						<span class="invalid-feedback select2Error" role="alert">
					
							@error('lodgingDay')
								<div class="alert alert-danger">
									{{ $message }},
								</div>	
							@enderror
							@error('lodgingCost')
							<div class="alert alert-danger">
									{{ $message }},
							</div>	
							@enderror
							@error('transportDay')
							<div class="alert alert-danger">
									{{ $message }},
							</div>	
							@enderror
							@error('transportCost')
								<div class="alert alert-danger">
									{{ $message }},
								</div>	
							@enderror
							@error('mealDay')
							<div class="alert alert-danger">
									{{ $message }},
								</div>	
							@enderror
							@error('mealCost')
							<div class="alert alert-danger">
									{{ $message }},
							</div>	
							@enderror
							@error('otherDay')
						<div class="alert alert-danger">
									{{ $message }},
								</div>	
							@enderror
							@error('otherCost')
								<div class="alert alert-danger">
									{{ $message }},
								</div>	
							@enderror	
						
						</span>	
						
					
					</div>
				</div>				
					
			@endif	
					
				</div>
@endif				
			</div>		
		
		
		<br>
            <p> Persetujuan pengajuan tugas/training yang sudah Anda berikan tidak akan dibatalkan.<br><br> Jika Anda yakin, silahkan klik tombol <strong>Setuju</strong> untuk menyetujui</p>
        </div>
   
        <div class="modal-footer justify-content-between">
          <button wire:click="cancel" onclick="clearSelect2()" type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    <button data-toggle="modal" data-target="#notApprovModal" wire:click="showModalNotApprov({{ $assignmentId }})" type="button" class="btn btn-warning"><i class="fa fa-ban"></i> Tidak Setuju</button>&nbsp;&nbsp;&nbsp;		  
          <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Setuju</button>
        </div></form>
      </div>
    
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
 @push('scripts')
 <script>
$(function () {
        $("#checkboxSuccess1").click(function () {
            if ($(this).is(":checked")) {
                $("#dvPassport").show();
                $("#AddPassport").hide();
            } else {
                $("#dvPassport").hide();
                $("#AddPassport").show();
            }
        });
    });
</script>
<script>
$(document).ready(function(){
	if(document.getElementById('checkboxSuccess1').checked) {
		$("#dvPassport").show('slow');
	}
});
</script>
 <script>
function clearSelect2() {
   var frm = document.getElementsByName('crtForm')[0];
   frm.submit();
   frm.reset();
   return false;
}
</script>
 @endpush