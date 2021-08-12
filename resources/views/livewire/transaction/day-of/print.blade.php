<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
 <link rel="stylesheet" href="{{asset('template/custom/single.css')}}">
<style>
body{
background-color: #F6F6F6;
}
.panel-footer p{
	 text-indent: 0px;
		 	 	 padding-top: 1px;
				  line-height: 1px;
				  font-size:13px;
}

.brandSection{
background-color: #3B99B3;
border:1px solid #417482;
}
.headerLeft h1{
color:#fff;
margin: 0px;
font-size:28px;
}
.header{
border-bottom: 2px solid #417482;
padding: 10px;
}
.headerRight p{
margin: 0px;
font-size:10px;
color:#88CFE3;
text-align: right;
}
.contentSection{
background-color: #fff;
padding: 0px;
}
.content{
background-color: #fff;
padding:20px;
}
.content h1{
font-size:22px;
margin:0px;
}
.content p{
margin: 0px;
font-size: 11px;
}
.content span{
font-size: 11px;
color:#F2635F;
}
.panelPart{
background-color: #fff;
}
.panel-body{
background-color: #3BA4C2;
color:#fff;
padding: 5px;
line-height:10px;
}
.panel-footer {
background-color:#fff;
padding-bottom:1px;
}
.panel-footer h1{
font-size: 20px;
padding:15px;
border:1px dotted #DDDDDD;
}
.panel-footer p{
font-size:13px;
background-color: #F6F6F6;
padding: 5px;
}
.tableSection{
background-color: #fff;
}
.tableSection h1{
font-size:18px;
margin:0px;
}
th{
background-color: #383C3D;
color:#fff;
}
.table{
padding-bottom: 10px;
margin:4px;
border:1px solid #DDDDDD;
}
#table th{
	line-height:7px;
	font-size:13px;
	/*border:1px solid red;*/
}

#table tr td{
	line-height:5px;
	font-size:13px;
	/*border:1px solid red;*/
}

td:nth-child(2){
text-align: left;
}
td {
height: 100%;
}
.bg {
background-color: #f00;
width: 100%;
height: 100%;
display: block;
}
.lastSectionleft{
background-color: #fff;
padding-top:20px;
}
.Sectionleft p{
border:1px solid #DDDDDD;
height:140px;
padding: 5px;
}
.Sectionleft span{
color:#42A5C5;
}
.lastPanel{
text-align:center;
}
.panelLastLeft p,.panelLastRight p{
font-size:11px;
padding:5px 2px 5px 10px;
}
.panel{
	margin:4px;
}

</style>
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
						<p>{{$dayOfs->number}}</p>
						<span>{{date('d M Y',strtotime($dayOfs->created_at))}}</span>
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
												@if($dayOfs->user->lumpsum!=0)<p>Lump Sum</p>@endif												
											</div>
											<div class="col-md-9 col-sm-9 col-xs-9">
												<p>{{$dayOfs->user->name}} / {{$dayOfs->user->nrp}}</p>
												<p>{{$dayOfs->user->position->name}} / {{$dayOfs->user->position->department->name}}</p>
												<p>{{$dayOfs->user->site->name}}</p>
												<p>{{$dayOfs->user->phone}}</p>
												<p>{{Str::limit($dayOfs->user->address,50)}}</p>
												@if($dayOfs->user->lumpsum!=0)<p>{{currency_IDR($dayOfs->user->lumpsum)}}</p>@endif												
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>					
					
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
												<p>{{$destinationGoTickets->from}} - {{$destinationGoTickets->to}} ({{date('d/m/Y',strtotime($dayOfs->ticket_from_go))}} {{date('H:i',strtotime($dayOfs->ticket_time_go))}})</p>
											</div>
										</div>
										<div class="row">
											<div class="col-md-3 col-sm-3 col-xs-3">
												<p>Kembali</p>
											</div>
											<div class="col-md-9 col-sm-9 col-xs-9">
												<p>{{$destinationBackTickets->from}} - {{$destinationBackTickets->to}} ({{date('d/m/Y',strtotime($dayOfs->ticket_from_back))}} {{date('H:i',strtotime($dayOfs->ticket_time_back))}})</p>
											</div>
										</div>										
									</div>
								</div>
							</div>

						</div>
					</div>
					
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
												<p>{{$destinationGoTravels->from}} - {{$destinationGoTravels->to}} ({{date('d/m/Y',strtotime($dayOfs->travel_from_go))}})</p>
											</div>
										</div>
										<div class="row">
											<div class="col-md-3 col-sm-3 col-xs-3">
												<p>Kembali</p>
											</div>
											<div class="col-md-9 col-sm-9 col-xs-9">
												<p>{{$destinationBackTravels->from}} - {{$destinationBackTravels->to}} ({{date('d/m/Y',strtotime($dayOfs->travel_from_back))}})</p>
											</div>
										</div>										
									</div>
								</div>
							</div>

						</div>
					</div>
					
					<div class="col-md-12 col-sm-12 tableSection">
						<h1>CUTI</h1>
						<table class="table text-left" id="table">
							<thead>
								<tr class="tableHead">
									<th style="width:27%;">Deskripsi</th>								
									<th style="width:73%;">Tanggal</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>Cuti Job Site</td>
									<td>{{date('d/m/Y',strtotime($dayOfs->start))}} s/d {{date('d/m/Y',strtotime($dayOfs->end))}}</td>
								</tr>
								@if($annualLeaves)
								<tr>
									<td>Cuti Tahunan</td>
									<td>
										@if($annualLeaves->start!=null)
											{{date('d/m/Y',strtotime($annualLeaves->start))}} s/d {{date('d/m/Y',strtotime($annualLeaves->end))}}
											@else
												Tidak diambil / belum ada cuti tahunan
										@endif										
									</td>
								</tr>
					@endif
					@if($bigLeaves)
								<tr>
									<td>Cuti Besar</td>
									<td>
										@if($bigLeaves->start!=null)
											{{date('d/m/Y',strtotime($bigLeaves->start))}} s/d {{date('d/m/Y',strtotime($bigLeaves->end))}}
											@else
												Tidak diambil / belum ada cuti besar
										@endif										
									
									</td>
								</tr>
								@endif
								<tr>
									<td>Masuk/ Induksi</td>
									<td>{{date('d/m/Y',strtotime($dayOfs->in))}}</td>
								</tr>							
							</tbody>
						</table>
					</div>
					
					
					
					<div class="col-md-12 col-sm-12 tableSection">
						<table class="table text-left" style="font-size:10px;">
							<thead>
								<tr class="tableHead" style="">
									<th style="width:20%;">Tgl On Site Sblumnya</th>								
									<th style="width:20%;">Jml Hari On Site</th>
									<th style="width:20%;">Sisa Cuti Tahunan</th>
									<th style="width:20%;">Jml Cuti Diambil</th>
									<th style="width:20%;">Sisa Cuti Tahun Skrg</th>
									<th style="width:20%;">Sisa Cuti Besar</th>										
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>{{date('d/m/Y',strtotime($dayOfs->in_before))}}</td>
									<td>{{$dayOfs->work_day}}</td>
									<td>@if($annualLeaves){{$annualLeaves->should}}@endif</td>
									<td>{{$dayOfs->day_of_sum}}</td>
									<td>@if($annualLeaves){{$annualLeaves->less}}@endif</td>
									<td>@if($bigLeaves){{$bigLeaves->less}}@endif</td>									
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
										@forelse ($approvalRecords as $approvItem)
											<div class="col-md-3 col-sm-3 col-xs-3">
												<p>{{qrCode($approvItem->nrp.'-'.$approvItem->approver)}}</p>
												<p><strong>{{$approvItem->approver}}</strong></p>
												@if($approvItem->level_approv=='site_manager' and $approvItem->hr_head=='0')
												
												<p>Project Manager</p><p><span id="approverDate">{{date('d/m/Y',strtotime($approvItem->created_at))}}</span></p>
												@endif

												@if($approvItem->level_approv=='department_head' and $approvItem->hr_head=='0')
												<p>Dept.Head </p><p><span id="approverDate">{{date('d/m/Y',strtotime($approvItem->created_at))}}</span></p>
												@endif

												@if($approvItem->level_approv=='department_head' and $approvItem->hr_head=='1')
												<p>GEA Dept.Head </p><p><span id="approverDate">{{date('d/m/Y',strtotime($approvItem->created_at))}}</span></p>
												@endif

												@if($approvItem->level_approv!='department_head' and $approvItem->hr_head=='1')
												<p>GEA Dept.Head </p><p><span id="approverDate">{{date('d/m/Y',strtotime($approvItem->created_at))}}</span></p>
												@endif
											</div>
										@empty
											<p>Belum Approv!</p>
										@endforelse	
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
  window.addEventListener("load", window.print());
</script>
</body>
</html>