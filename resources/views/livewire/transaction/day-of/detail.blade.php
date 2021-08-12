<div wire:ignore.self class="modal fade" id="detailModal" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalScrollableTitle">Detail Data  </h5>
        <button wire:click="cancel" onclick="clearSelect2()" type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <div class="content">
			<div class="row">
			  <div class="col-12">
			<p><strong>NOMOR PENGAJAUAN:</strong> {{$number}}</p>
			</div>
			</div>
				<div class="card">
				  <div class="card-header">
					<h3 class="card-title">Karyawan</h3>
				  </div>
				  <div class="card-body">
					<div class="row">
					  <div class="col-4">
							Nama / NRP
					  </div>
					  <div class="col-8">
						: {{$name}} / ({{$nrp}})
					  </div>
					</div>
					<div class="row">
					  <div class="col-4">
							Jabatan / Departemen
					  </div>
					  <div class="col-8">
						: {{$position}} / {{$department}}
					  </div>
					</div>
					<div class="row">
					  <div class="col-4">
							Job Site
					  </div>
					  <div class="col-8">
						: {{$site}}
					  </div>
					</div>
					<div class="row">
					  <div class="col-4">
							NO. HP
					  </div>
					  <div class="col-8">
						: {{$phone}}
					  </div>
					</div>
					<div class="row">
					  <div class="col-4">
							Alamat
					  </div>
					  <div class="col-8">
						: {{Str::limit($address,50)}}
					  </div>
					</div>					
				  </div>
				</div>
			@if($dayOfStandartTicketDay>0)
				<div class="card">
				  <div class="card-header">
					<h3 class="card-title">Rute Tiket</h3>
				  </div>
				  <div class="card-body">
					<div class="row">
					  <div class="col-4">
							Keberangkatan
					  </div>
					  <div class="col-8">
						: {{$destinationFromGoTicket}} - {{$destinationToGoTicket}} ({{date('d/m/Y',strtotime($ticketDateFromGo))}} {{date('H:i',strtotime($ticketTimeFromGo))}})
					  </div>
					</div>
					<div class="row">
					  <div class="col-4">
							Kembali
					  </div>
					  <div class="col-8">
						: {{$destinationFromBackTicket}} - {{$destinationToBackTicket}} ({{date('d/m/Y',strtotime($ticketDateFromBack))}} {{date('H:i',strtotime($ticketTimeFromBack))}})
					  </div>
					</div>				
				  </div>
				</div>
			@endif
			
			@if($dayOfStandartTravelDay>0)
				<div class="card">
				  <div class="card-header">
					<h3 class="card-title">Rute Travel</h3>
				  </div>
				  <div class="card-body">
					<div class="row">
					  <div class="col-4">
							Keberangkatan
					  </div>
					  <div class="col-8">
						: {{$destinationFromGoTravel}} - {{$destinationToGoTravel}} ({{date('d/m/Y',strtotime($travelDateFromGo))}})
					  </div>
					</div>
					<div class="row">
					  <div class="col-4">
							Kembali
					  </div>
					  <div class="col-8">
						: {{$destinationFromBackTravel}} - {{$destinationToBackTravel}} ({{date('d/m/Y',strtotime($travelDateFromBack))}})
					  </div>
					</div>				
				  </div>
				</div>
			@endif

				<div class="card">
				  <div class="card-header">
					<h3 class="card-title">Jadwal Cuti</h3>
				  </div>
				  <div class="card-body">
					<div class="row">
					  <div class="col-4">
							Cuti Job Site
					  </div>
					  <div class="col-8">
						: {{date('d/m/Y',strtotime($start))}} - {{date('d/m/Y',strtotime($end))}}
					  </div>
					</div>
					
					@if($annualLeaveStart!='' or $annualLeaveStart=null)
					<div class="row">
					  <div class="col-4">
							Cuti Tahunan
					  </div>
					  <div class="col-8">
						: {{date('d/m/Y',strtotime($annualLeaveStart))}} - {{date('d/m/Y',strtotime($annualLeaveEnd))}}
					  </div>
					</div>
					@endif
					
					@if($bigLeaveStart!='' or $bigLeaveStart=null)
					<div class="row">
					  <div class="col-4">
							Cuti Besar
					  </div>
					  <div class="col-8">
						: {{date('d/m/Y',strtotime($bigLeaveStart))}} - {{date('d/m/Y',strtotime($bigLeaveEnd))}}
					  </div>
					</div>
					@endif
					<div class="row">
					  <div class="col-4">
							Kembali Bekerja / Induksi
					  </div>
					  <div class="col-8">
						: {{date('d/m/Y',strtotime($in))}}
					  </div>
					</div>					
				  </div>
				</div>

				<div class="card">
				  <div class="card-header">
					<h3 class="card-title">Electronic Approve</h3>
				  </div>
				  <div class="card-body">
				  
				 
					<div class="row">
					 @forelse ($approvalRecords as $approvItem)
					 @if($approvItem->employeeLevel=='department_head' or $approvItem->employeeLevel=='site_manager')
						<div class="col-4">
							@if($approvItem->employeeLevel=='department_head')							
								@if($approvItem->level_approv=='department_head' and $approvItem->hr_head=='1' and $approvItem->hrd_approv=='1')
									{{qrCode($approvItem->nrp.'-'.$approvItem->approver)}}<br><br>
									<strong>{{$approvItem->approver}}</strong><br>
									GEA Dept.Head<br><span id="approverDate">{{date('d/m/Y',strtotime($approvItem->created_at))}}</span>
									
								@elseif($approvItem->level_approv=='department_head' and $approvItem->hr_head=='1' and $approvItem->hrd_approv=='2')
									<i class="fa fa-ban fa-3x"></i><br><br>	
									<strong>{{$approvItem->approver}}</strong><br>
									GEA Dept.Head<br><span id="approverDate">{{date('d/m/Y',strtotime($approvItem->created_at))}}</span>								

								@elseif($approvItem->level_approv!='department_head' and $approvItem->hr_head=='1' and $approvItem->hrd_approv=='1')
									{{qrCode($approvItem->nrp.'-'.$approvItem->approver)}}<br><br>
									<strong>{{$approvItem->approver}}</strong><br>
									GEA Dept.Head<br><span id="approverDate">{{date('d/m/Y',strtotime($approvItem->created_at))}}</span>
									
								@elseif($approvItem->level_approv!='department_head' and $approvItem->hr_head=='1' and $approvItem->hrd_approv=='2')
									<i class="fa fa-ban fa-3x"></i><br><br>	
									<strong>{{$approvItem->approver}}</strong><br>
									GEA Dept.Head<br><span id="approverDate">{{date('d/m/Y',strtotime($approvItem->created_at))}}</span>

								@elseif($approvItem->level_approv=='site_manager' and $approvItem->hr_head=='0' and $approvItem->sm_approv=='1')
									{{qrCode($approvItem->nrp.'-'.$approvItem->approver)}}<br><br>
									<strong>{{$approvItem->approver}}</strong><br>
									Project Manager<br><span id="approverDate">{{date('d/m/Y',strtotime($approvItem->created_at))}}</span>
									
								@elseif($approvItem->level_approv=='site_manager' and $approvItem->hr_head=='0' and $approvItem->sm_approv=='2')
									<i class="fa fa-ban fa-3x"></i><br><br>	
									<strong>{{$approvItem->approver}}</strong><br>
									Project Manager<br><span id="approverDate">{{date('d/m/Y',strtotime($approvItem->created_at))}}</span>										
									
								@else
									Belum approv!
								@endif	
							@endif
							@if($approvItem->employeeLevel=='sm_manager')
								@if($approvItem->level_approv=='department_head' and $approvItem->hr_head=='1' and $approvItem->hrd_approv=='1')
									{{qrCode($approvItem->nrp.'-'.$approvItem->approver)}}<br><br>
									<strong>{{$approvItem->approver}}</strong><br>
									GEA Dept.Head<br><span id="approverDate">{{date('d/m/Y',strtotime($approvItem->created_at))}}</span>
									
								@elseif($approvItem->level_approv=='department_head' and $approvItem->hr_head=='1' and $approvItem->hrd_approv=='2')
									<i class="fa fa-ban fa-3x"></i><br><br>	
									<strong>{{$approvItem->approver}}</strong><br>
									GEA Dept.Head<br><span id="approverDate">{{date('d/m/Y',strtotime($approvItem->created_at))}}</span>								

								@elseif($approvItem->level_approv!='department_head' and $approvItem->hr_head=='1' and $approvItem->hrd_approv=='1')
									{{qrCode($approvItem->nrp.'-'.$approvItem->approver)}}<br><br>
									<strong>{{$approvItem->approver}}</strong><br>
									GEA Dept.Head<br><span id="approverDate">{{date('d/m/Y',strtotime($approvItem->created_at))}}</span>
									
								@elseif($approvItem->level_approv!='department_head' and $approvItem->hr_head=='1' and $approvItem->hrd_approv=='2')
									<i class="fa fa-ban fa-3x"></i><br><br>	
									<strong>{{$approvItem->approver}}</strong><br>
									GEA Dept.Head<br><span id="approverDate">{{date('d/m/Y',strtotime($approvItem->created_at))}}</span>

								@elseif($approvItem->level_approv=='site_manager' and $approvItem->hr_head=='0' and $approvItem->sm_approv=='1')
									{{qrCode($approvItem->nrp.'-'.$approvItem->approver)}}<br><br>
									<strong>{{$approvItem->approver}}</strong><br>
									Project Manager<br><span id="approverDate">{{date('d/m/Y',strtotime($approvItem->created_at))}}</span>
									
								@elseif($approvItem->level_approv=='site_manager' and $approvItem->hr_head=='0' and $approvItem->sm_approv=='2')
									<i class="fa fa-ban fa-3x"></i><br><br>	
									<strong>{{$approvItem->approver}}</strong><br>
									Project Manager<br><span id="approverDate">{{date('d/m/Y',strtotime($approvItem->created_at))}}</span>										
									
								@else
									Belum approv!
								@endif									
							@endif							
						</div>
					 @endif
					 @if($approvItem->employeeLevel=='employee' or $approvItem->employeeLevel=='hrd_admin')
					  <div class="col-4">
							@if($approvItem->level_approv=='site_manager' and $approvItem->hr_head=='0' and $approvItem->sm_approv=='1')
								{{qrCode($approvItem->nrp.'-'.$approvItem->approver)}}<br><br>
								<strong>{{$approvItem->approver}}</strong><br>
								Project Manager<br><span id="approverDate">{{date('d/m/Y',strtotime($approvItem->created_at))}}</span>
								
							@elseif($approvItem->level_approv=='site_manager' and $approvItem->hr_head=='0' and $approvItem->sm_approv=='2')
								<i class="fa fa-ban fa-3x"></i><br><br>	
								<strong>{{$approvItem->approver}}</strong><br>
								Project Manager<br><span id="approverDate">{{date('d/m/Y',strtotime($approvItem->created_at))}}</span>								

							@elseif($approvItem->level_approv=='department_head' and $approvItem->hr_head=='0' and $approvItem->head_approv=='1')
								{{qrCode($approvItem->nrp.'-'.$approvItem->approver)}}<br><br>
								<strong>{{$approvItem->approver}}</strong><br>
								Dept.Head<br><span id="approverDate">{{date('d/m/Y',strtotime($approvItem->created_at))}}</span>
								
							@elseif($approvItem->level_approv=='department_head' and $approvItem->hr_head=='0' and $approvItem->head_approv=='2')
								<i class="fa fa-ban fa-3x"></i><br><br>	
								<strong>{{$approvItem->approver}}</strong><br>
								Dept.Head<br><span id="approverDate">{{date('d/m/Y',strtotime($approvItem->created_at))}}</span>
								
							@elseif($approvItem->level_approv=='department_head' and $approvItem->hr_head=='1' and $approvItem->head_approv=='1')
								{{qrCode($approvItem->nrp.'-'.$approvItem->approver)}}<br><br>
								<strong>{{$approvItem->approver}}</strong><br>
								GEA Dept.Head<br><span id="approverDate">{{date('d/m/Y',strtotime($approvItem->created_at))}}</span>
								
							@elseif($approvItem->level_approv=='department_head' and $approvItem->hr_head=='1' and $approvItem->head_approv=='2')
								<i class="fa fa-ban fa-3x"></i><br><br>	
								<strong>{{$approvItem->approver}}</strong><br>
								GEA Dept.Head<br><span id="approverDate">{{date('d/m/Y',strtotime($approvItem->created_at))}}</span>								


							@elseif($approvItem->level_approv!='department_head' and $approvItem->hr_head=='1' and $approvItem->head_approv=='1')
								{{qrCode($approvItem->nrp.'-'.$approvItem->approver)}}<br><br>
								<strong>{{$approvItem->approver}}</strong><br>
								GEA Dept.Head<br><span id="approverDate">{{date('d/m/Y',strtotime($approvItem->created_at))}}</span>
								
							@elseif($approvItem->level_approv!='department_head' and $approvItem->hr_head=='1' and $approvItem->head_approv=='2')
								<i class="fa fa-ban fa-3x"></i><br><br>	
								<strong>{{$approvItem->approver}}</strong><br>
								GEA Dept.Head<br><span id="approverDate">{{date('d/m/Y',strtotime($approvItem->created_at))}}</span>	
								
							@else
								Belum ada approval
							@endif	
							
					  </div>  
					@endif
					  
					@if($approvItem->approv=='2')
						  <div class="col-12">
						  <br>
						  <p style="color:#ff0000;"><strong>Tidak Disetujui Karena:</strong> {{$approvItem->reason}}</p>
						  </div>
					@endif					  
					@empty
					   Belum ada approval!
					@endforelse
					</div>

				  </div>
				</div>
				<div class="card">
				  <div class="card-header">
					<h3 class="card-title">Summary</h3>
				  </div>
				  <div class="card-body">
					<div class="row">
					  <div class="col-3">
							Tgl On Site Sblumnya
					  </div>
					  <div class="col-3">
						: {{date('d/m/Y',strtotime($inBefore))}}
					  </div>
					  <div class="col-3">
							Standart Cuti Tahunan
					  </div>
					  <div class="col-3">
						: {{$annualLeaveShould}}
					  </div>
					</div>
					<div class="row">
					  <div class="col-3">
							Jml Hari On Site
					  </div>
					  <div class="col-3">
						: {{$workDay}}
					  </div>

					  <div class="col-3">
							Sisa Cuti Tahun Skrg
					  </div>
					  <div class="col-3">
						: {{$annualLeaveLess}}
					  </div>
					  
					  <div class="col-3">
							Sisa Cuti Besar
					  </div>
					  <div class="col-3">
						: {{$bigLeaveLess}}
					  </div>					  
					  
					</div>
					<div class="row">
					  <div class="col-3">
							Jml Cuti yg diambil
					  </div>
					  <div class="col-3">
						: {{$dayOfSum}}
					  </div>
					</div>						
				  </div>
				</div>
			</div>	  
      </div>
        <div class="modal-footer justify-content-between">
			<button wire:click="cancel" onclick="clearSelect2()" type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
			@if($employeeId==Auth::user()->id)
				@if($headApprov=='0' and $annualLeaveStart=='' and $employeeLevel=='employee')
					<a type="button" href="{{url('transaction/day-of/add/annual-leave',$dayOfId)}}" class="btn btn-info" title="Cuti Tahunan"><i class="fa fa-tasks"></i> Ajukan Cuti Tahunan</a>
				@elseif($headApprov=='0' and $annualLeaveStart=='' and $employeeLevel=='hrd_admin')
					<a type="button" href="{{url('transaction/day-of/add/annual-leave',$dayOfId)}}" class="btn btn-info" title="Cuti Tahunan"><i class="fa fa-tasks"></i> Ajukan Cuti Tahunan</a>			
				@elseif($hrdApprov=='0' and $annualLeaveStart=='' and $employeeLevel=='department_head')
					<a type="button" href="{{url('transaction/day-of/add/annual-leave',$dayOfId)}}" class="btn btn-info" title="Cuti Tahunan"><i class="fa fa-tasks"></i> Ajukan Cuti Tahunan</a>
				@elseif($hrdApprov=='0' and $annualLeaveStart=='' and $employeeLevel=='site_manager')
					<a type="button" href="{{url('transaction/day-of/add/annual-leave',$dayOfId)}}" class="btn btn-info" title="Cuti Tahunan"><i class="fa fa-tasks"></i> Ajukan Cuti Tahunan</a>			
				@else			
				
				@endif				
				
				@if($headApprov=='0' and $annualLeaveStart!='' and $bigLeaveStart=='' and $employeeLevel=='employee')
					<a type="button" href="{{url('transaction/day-of/add/annual-leave',$dayOfId)}}" class="btn btn-info" title="Cuti Tahunan"><i class="fa fa-tasks"></i> Ajukan Cuti Tahunan</a>
				@elseif($headApprov=='0' and $annualLeaveStart!='' and $bigLeaveStart=='' and $employeeLevel=='hrd_admin')
					<a type="button" href="{{url('transaction/day-of/add/annual-leave',$dayOfId)}}" class="btn btn-info" title="Cuti Tahunan"><i class="fa fa-tasks"></i> Ajukan Cuti Tahunan</a>			
				@elseif($hrdApprov=='0' and $annualLeaveStart!='' and $bigLeaveStart=='' and $employeeLevel=='department_head')
					<a type="button" href="{{url('transaction/day-of/add/annual-leave',$dayOfId)}}" class="btn btn-info" title="Cuti Tahunan"><i class="fa fa-tasks"></i> Ajukan Cuti Tahunan</a>
				@elseif($hrdApprov=='0' and $annualLeaveStart!='' and $bigLeaveStart=='' and $employeeLevel=='site_manager')
					<a type="button" href="{{url('transaction/day-of/add/annual-leave',$dayOfId)}}" class="btn btn-info" title="Cuti Tahunan"><i class="fa fa-tasks"></i> Ajukan Cuti Tahunan</a>			
				@else			
				
				@endif				
				
				
			@endif
		</div></form>	
    </div>
  </div>
</div>

@push('styles')
<link rel="stylesheet" href="{{asset('template/custom/detail-modal.css')}}">
@endpush
