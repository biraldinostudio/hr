<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
 <link rel="stylesheet" href="{{asset('template/custom/single.css')}}">
   <link rel="stylesheet" href="{{asset('template/plugins/fontawesome-free/css/all.min.css')}}">
 <link rel="stylesheet" href="{{asset('template/custom/preview.css')}}">

</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2 col-xs-12 brandSection">
				<div class="row">
					<div class="col-md-12 col-sm-12 header">
						<div class="col-md-3 col-sm-3 headerLeft">
							<img src="{{asset('template/dist/img/logo/logo-invoice.png')}}" style="height:35px;">
						</div>
						<div class="col-md-9 col-sm-9 headerRight">
							<p>FRM-HRGA-021</p>
						</div>
					</div>
					<div class="col-md-12 col-sm-12 content">
						<h1>Surat Tugas</h1>
						<p>{{$assignments->number}}</p>
						<span>{{date('d M Y',strtotime($assignments->created_at))}}</span>
					</div>
					
					<div class="col-md-12 col-sm-12 panelPart">
						<div class="row">
							<div class="col-md-12 col-sm-12 panelPart">
								<div class="panel panel-default">
									<div class="panel-body">
										<strong>KARYAWAN</strong>
									</div>
									<div class="panel-footer">
										<div class="row">
											<div class="col-md-3 col-sm-3 col-xs-3">
												<p>Nama / NRP</p>
												<p>Jabatan / Departemen</p>
												<p>Site</p>
												<p>No HP</p>
												<p>Alamat</p>											
											</div>
											<div class="col-md-9 col-sm-9 col-xs-9">
												<p>{{$assignments->user->name}} / {{$assignments->user->nrp}}</p>
												<p>{{$assignments->user->position->name}} / {{$assignments->user->position->department->name}}</p>
												<p>{{$assignments->user->site->name}}</p>
												<p>{{$assignments->user->phone}}</p>
												<p>{{Str::limit($assignments->user->address,50)}}</p>												
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>					
					@if($assignments->location=='outRegional')
					<div class="col-md-12 col-sm-12 panelPart">
						<div class="row">
							<div class="col-md-12 col-sm-12 panelPart">
								<div class="panel panel-default">
									<div class="panel-body">
										<strong>RUTE & TANGGAL TIKET</strong>
									</div>
									<div class="panel-footer">
										<div class="row">
											<div class="col-md-3 col-sm-3 col-xs-3">
												<p>Berangkat</p>
											</div>
											<div class="col-md-9 col-sm-9 col-xs-9">
												<p>{{$destinationGoTickets->from}} - {{$destinationGoTickets->to}} ({{date('d/m/Y',strtotime($assignments->ticket_date_from_go))}} {{date('H:i',strtotime($assignments->ticket_time_from_go))}})</p>
											</div>
										</div>
										<div class="row">
											<div class="col-md-3 col-sm-3 col-xs-3">
												<p>Kembali</p>
											</div>
											<div class="col-md-9 col-sm-9 col-xs-9">
												<p>{{$destinationBackTickets->from}} - {{$destinationBackTickets->to}} ({{date('d/m/Y',strtotime($assignments->ticket_date_from_back))}} {{date('H:i',strtotime($assignments->ticket_time_from_back))}})</p>
											</div>
										</div>										
									</div>
								</div>
							</div>

						</div>
					</div>
					@endif
					@if($assignments->location=='inRegional' or $assignments->location=='outRegional')
					<div class="col-md-12 col-sm-12 panelPart">
						<div class="row">
							<div class="col-md-12 col-sm-12 panelPart">
								<div class="panel panel-default">
									<div class="panel-body">
										<strong>RUTE & TANGGAL TRAVEL</strong>
									</div>
									<div class="panel-footer">
										<div class="row">
											<div class="col-md-3 col-sm-3 col-xs-3">
												<p>Berangkat</p>
											</div>
											<div class="col-md-9 col-sm-9 col-xs-9">
												<p>{{$destinationGoTravels->from}} - {{$destinationGoTravels->to}} ({{date('d/m/Y',strtotime($assignments->travel_date_from_go))}})</p>
											</div>
										</div>
										<div class="row">
											<div class="col-md-3 col-sm-3 col-xs-3">
												<p>Kembali</p>
											</div>
											<div class="col-md-9 col-sm-9 col-xs-9">
												<p>{{$destinationBackTravels->from}} - {{$destinationBackTravels->to}} ({{date('d/m/Y',strtotime($assignments->travel_date_from_back))}})</p>
											</div>
										</div>										
									</div>
								</div>
							</div>

						</div>
					</div>
					@endif
					<div class="col-md-12 col-sm-12 tableSection">

						<table class="table text-left" id="table">
							<thead>
								<tr class="tableHead">
									<th style="width:27%;">Deskripsi</th>								
									<th style="width:73%;">Tanggal</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>Tanggal Tugas</td>
									<td>{{date('d/m/Y',strtotime($assignments->start_date))}} s/d {{date('d/m/Y',strtotime($assignments->end_date))}}</td>
								</tr>
								<tr>
									<td>Masuk/ Induksi</td>
									<td>{{date('d/m/Y',strtotime($assignments->in_date))}}</td>
								</tr>
								<tr>
									<td>Jml Hari</td>
									<td>{{$assignments->sum_day}} Hari</td>
								</tr>								
								<tr>
									<td>Lokasi Tugas</td>
									<td>@if($assignments->location=='inSite') Area Job Site @endif @if($assignments->location=='inRegional') Area Regional @endif @if($assignments->location=='outRegional') Luar Regional @endif</td>
								</tr>
								<tr>
									<td>Keperluan</td>
									<td>{{Str::limit($assignments->description,100)}}</td>
								</tr>								
							</tbody>
						</table>
					</div>
					
				@if($assignments->location=='inSite')
					<div class="col-md-12 col-sm-12 tableSection">

						<table class="table text-left" id="table">
							<thead>
								<tr class="tableHead">
									<th style="width:27%;">Akomodasi</th>	
									<th style="width:8%;">Hari</th>
									<th style="width:30%;">Biaya</th>									
									<th style="width:35%;">Total</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>Makan</td>
									<td>{{$assignments->meal_day}}</td>
									<td>{{currency_IDR($assignments->meal_cost)}}</td>
									<td>{{currency_IDR($assignments->meal_cost * $assignments->meal_day)}}</td>									
								</tr>
								<tr>
									<td>Lain-lain</td>
									<td>{{$assignments->other_day}}</td>
									<td>{{currency_IDR($assignments->other_cost)}}</td>
									<td>{{currency_IDR($assignments->other_cost * $assignments->other_day)}}</td>									
								</tr>
								<tr>
									<td></td>
									<td></td>
									<td><strong>Grand Total</strong></td>
									<td><strong>{{currency_IDR(($assignments->meal_cost * $assignments->meal_day)+($assignments->other_cost * $assignments->other_day))}}</strong></td>									
								</tr>
								<tr>
									<td><strong>Terbilang</strong></td>
									<td colspan="3"><strong>{($assignments->meal_cost * $assignments->meal_day)+($assignments->other_cost * $assignments->other_day)))}}</strong> Rupiah</td>									
								</tr>								
							</tbody>
						</table>
					</div>					
				@endif					
					
				@if($assignments->location=='inRegional' or $assignments->location=='outRegional')					
					<div class="col-md-12 col-sm-12 tableSection">

						<table class="table text-left" id="table">
							<thead>
								<tr class="tableHead">
									<th style="width:27%;">Akomodasi</th>	
									<th style="width:8%;">Hari</th>
									<th style="width:30%;">Biaya</th>									
									<th style="width:35%;">Total</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>Penginapan</td>
									<td>{{$assignments->lodging_day}}</td>
									<td>{{currency_IDR($assignments->lodging_cost)}}</td>
									<td>{{currency_IDR($assignments->lodging_cost * $assignments->lodging_day)}}</td>									
								</tr>
								<tr>
									<td>Transportasi</td>
									<td>{{$assignments->transportation_day}}</td>
									<td>{{currency_IDR($assignments->transportation_cost)}}</td>
									<td>{{currency_IDR($assignments->transportation_cost * $assignments->transportation_day)}}</td>									
								</tr>
								<tr>
									<td>Makan</td>
									<td>{{$assignments->meal_day}}</td>
									<td>{{currency_IDR($assignments->meal_cost)}}</td>
									<td>{{currency_IDR($assignments->meal_cost * $assignments->meal_day)}}</td>									
								</tr>
								<tr>
									<td>Lain-lain</td>
									<td>{{$assignments->other_day}}</td>
									<td>{{currency_IDR($assignments->other_cost)}}</td>
									<td>{{currency_IDR($assignments->other_cost * $assignments->other_day)}}</td>									
								</tr>
								<tr>
									<td></td>
									<td></td>
									<td><strong>Grand Total</strong></td>
									<td><strong>{{currency_IDR(($assignments->lodging_cost * $assignments->lodging_day)+($assignments->transportation_cost * $assignments->transportation_day)+($assignments->meal_cost * $assignments->meal_day)+($assignments->other_cost * $assignments->other_day))}}</strong></td>									
								</tr>
								<tr>
									<td><strong>Terbilang</strong></td>
									<td colspan="3"><strong>{{ucfirst(terbilang(($assignments->lodging_cost * $assignments->lodging_day)+($assignments->transportation_cost * $assignments->transportation_day)+($assignments->meal_cost * $assignments->meal_day)+($assignments->other_cost * $assignments->other_day)))}}</strong> Rupiah</td>									
								</tr>								
							</tbody>
						</table>
					</div>
				@endif		
					
					<div class="col-md-12 col-sm-12 panelPart">
						<div class="row">
							<div class="col-md-12 col-sm-12 panelPart">
								<div class="panel panel-default">
									<div class="panel-body">
										<strong>ELECTRONIC APPROVE</strong>
									</div>
									<div class="panel-footer">

									
						<div class="row">
							<div class="col-md-8 col-sm-6 Sectionleft">

								<div class="panel">
									<div class="panel-footer lastFooter">
										<div class="row">
										@forelse ($approvalRecords as $approvItem)
											@if($assignments->user->level=='department_head' or $assignments->user->level=='site_manager')
												
												<div class="col-md-4 col-sm-4 col-xs-4 panelLastLeft">
													<div class="row">
														{{qrCode($approvItem->nrp.'-'.$approvItem->approver)}}
													</div>
													<div class="row">
														<strong>{{$approvItem->approver}}</strong>
													</div>
														@if($approvItem->level_approv=='site_manager' and $approvItem->hr_head=='0')
														
														<div class="row">Project Manager</div><div class="row"><span id="approverDate">{{date('d/m/Y',strtotime($approvItem->created_at))}}</span></div>
														@endif									
												</div>

											@endif

											@if($assignments->user->level=='employee' or $assignments->user->level=='hrd_admin')
												<div class="col-md-4 col-sm-4 col-xs-4 panelLastLeft">
													<div class="row">
														{{qrCode($approvItem->nrp.'-'.$approvItem->approver)}}
													</div>
													<div class="row">
														<strong>{{$approvItem->approver}}</strong>
													</div>
														@if($approvItem->level_approv=='site_manager' and $approvItem->hr_head=='0')
														
															<div class="row">Project Manager</div><div class="row"><span id="approverDate">{{date('d/m/Y',strtotime($approvItem->created_at))}}</span></div>
														@endif

														@if($approvItem->level_approv=='department_head' and $approvItem->hr_head=='0')
															<div class="row">Dept.Head </div><div class="row"><span id="approverDate">{{date('d/m/Y',strtotime($approvItem->created_at))}}</span></div>
														@endif

														@if($approvItem->level_approv=='department_head' and $approvItem->hr_head=='1')
															<div class="row">Dept.Head </div><div class="row"><span id="approverDate">{{date('d/m/Y',strtotime($approvItem->created_at))}}</span></div>
														@endif														
												</div>												
											@endif										
										@empty
											<p>Belum Approv!</p>
										@endforelse	
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-4 col-sm-6">
								<div class="panel">
									<div class="lastPanel">
										<a href="{{route('assignment.print',$assignments->id)}}" rel="noopener" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a>
									</div><br>
									<div class="lastPanel">
										<a href="{{ url()->previous() }}" rel="noopener" class="btn btn-default"><i class="fa fa-times"></i> Tutup</a>
									
									</div>
								</div>
							</div>
						</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
var myWindow;


function closeWin() {
  myWindow.close();
}
</script>
</body>
</html>