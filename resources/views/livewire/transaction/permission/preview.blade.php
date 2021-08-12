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
						<h1>Izin Meninggalkan Site</h1>
						<p>{{$permissions->number}}</p>
						<span>{{date('d M Y',strtotime($permissions->created_at))}}</span>
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
												<p>Nama</p>
												<p>NRP</p>
												<p>Jabatan</p>
												<p>Departemen</p>												
												<p>Site</p>
												<p>No HP</p>
												<p>Alamat</p>												
											</div>
											<div class="col-md-9 col-sm-9 col-xs-9">
												<p>{{$permissions->user->name}}</p>
												<p>{{$permissions->user->nrp}}</p>
												<p>{{$permissions->user->position->name}}</p>
												<p>{{$permissions->user->position->department->name}}</p>
												<p>{{$permissions->user->site->name}}</p>
												<p>{{$permissions->user->phone}}</p>
												<p>{{Str::limit($permissions->user->address,50)}}</p>												
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>					
					


					
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
									<td>Tanggal Izin</td>
									<td>{{date('d/m/Y',strtotime($permissions->start_date))}} s/d {{date('d/m/Y',strtotime($permissions->end_date))}}</td>
								</tr>
								<tr>
									<td>Jml Hari</td>
									<td>{{$permissions->sum_day}} Hari</td>
								</tr>
								<tr>
									<td>Jenis Izin</td>
									<td>@if($permissionCategories->type=='Official') Resmi @elseif($permissionCategories->type=='CutAnnualLeave') Potong Cuti Tahunan @elseif($permissionCategories->type=='CutBasicSalary') @else @endif</td>
								</tr>
								@if($permissionCategories->type=='Official')
								<tr>
									<td>Deskripsi Izin</td>
									<td>{{$permissionCategories->name}}</td>
								</tr>
								@endif								
								<tr>
									<td>Masuk/ Induksi</td>
									<td>{{date('d/m/Y',strtotime($permissions->in_date))}}</td>
								</tr>
								<tr>
									<td>Keperluan</td>
									<td>{{ Str::limit($permissions->description,200) }}</td>
								</tr>								
							</tbody>
						</table>
					</div>

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
												<div class="row">GEA Dept.Head </div><div class="row"><span id="approverDate">{{date('d/m/Y',strtotime($approvItem->created_at))}}</span></div>
												@endif

												@if($approvItem->level_approv!='department_head' and $approvItem->hr_head=='1')
												<div class="row">GEA Dept.Head </div><div class="row"><span id="approverDate">{{date('d/m/Y',strtotime($approvItem->created_at))}}</span></div>
												@endif										
											</div>
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
										<a href="{{route('permission.print',$permissions->id)}}" rel="noopener" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a>
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