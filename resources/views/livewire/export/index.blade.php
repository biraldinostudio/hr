  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Export Data</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
              <li class="breadcrumb-item active">Export Data</li>
            </ol>
          </div>
        </div>
      </div>
    </section>
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-9">
            <div class="card">
              <div class="card-header p-2">
				Pengajuan Cuti
              </div>
              <div class="card-body">
                <div class="tab-content">
					<form name="expFormDayOf"> 
                    <div class="post">
						<div class="row">
							<div class="col-sm-4">
								<div class="form-group">
									<div class="input-group date" data-provide="datepicker">
										<div class="input-group-prepend">
										  <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
										</div>																
										<input wire:model="createStartDate" type="text" id="createStartDateId" class="form-control" onchange='Livewire.emit("selectCreateStartDate", this.value)' placeholder="Tanggal Awal ..." autocomplete="off">
									</div>
								</div>
							</div>
							<div class="col-sm-4">
								<div class="form-group">
									<div class="input-group date" data-provide="datepicker">
										<div class="input-group-prepend">
										  <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
										</div>																
										<input wire:model="createEndDate" type="text" id="createEndDateId" class="form-control" onchange='Livewire.emit("selectCreateEndDate", this.value)' placeholder="Tanggal Akhir ..." autocomplete="off">
									</div>
								</div>
							</div>
							<div class="col-sm-4">
								<div wire:ignore class="form-group">
									<select wire:model="site" id="siteId" class="select2 form-control" onchange='Livewire.emit("selectSite", this.value)' placeholder="Job Site">
										<option value="" selected="selected">Job Site</option>
										@foreach($sites as $item)
											<option value="{{$item->id}}">{{$item->name}}</option>
										@endforeach
									</select>
								</div>
							</div>						
						</div>
						<div class="row">
							<div class="col-sm-3">
								<div class="form-group">
									<button wire:click="exportDayOf" id="exportDayOfId" type="button" class="btn btn-info btn-sm"><i class="fa fa-file-excel"></i> Export Cuti</button>
								</div>
							</div>						
						</div>
                    </div>
					</form>
                </div>
              </div>
            </div>
			

            <div class="card">
              <div class="card-header p-2">
				Pengajuan Izin
              </div>
              <div class="card-body">
                <div class="tab-content">
					<form name="expFormPermission"> 
                    <div class="post">
						<div class="row">
							<div class="col-sm-4">
								<div class="form-group">
									<div class="input-group date" data-provide="datepicker">
										<div class="input-group-prepend">
										  <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
										</div>																
										<input wire:model="createPermissionStartDate" type="text" id="createPermissionStartDateId" class="form-control" onchange='Livewire.emit("selectCreatePermissionStartDate", this.value)' placeholder="Tanggal Awal ..." autocomplete="off">
									</div>
								</div>
							</div>
							<div class="col-sm-4">
								<div class="form-group">
									<div class="input-group date" data-provide="datepicker">
										<div class="input-group-prepend">
										  <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
										</div>																
										<input wire:model="createPermissionEndDate" type="text" id="createPermissionEndDateId" class="form-control" onchange='Livewire.emit("selectCreatePermissionEndDate", this.value)' placeholder="Tanggal Akhir ..." autocomplete="off">
									</div>
								</div>
							</div>
							<div class="col-sm-4">
								<div wire:ignore class="form-group">
									<select wire:model="sitePermission" id="sitePermissionId" class="form-control" onchange='Livewire.emit("selectSitePermission", this.value)' placeholder="Job site">
										<option value="" selected="selected">Job Site</option>
										@foreach($sites as $item)
											<option value="{{$item->id}}">{{$item->name}}</option>
										@endforeach
									</select>
								</div>
							</div>						
						</div>
						<div class="row">
							<div class="col-sm-3">
								<div class="form-group">
									<button wire:click="exportPermission" id="exportPermission" type="button" class="btn btn-info btn-sm"><i class="fa fa-file-excel"></i> Export Izin</button>
								</div>
							</div>						
						</div>
                    </div>
					</form>
                </div>
              </div>
            </div>
			
            <div class="card">
              <div class="card-header p-2">
				Pengajuan Dinas
              </div>
              <div class="card-body">
                <div class="tab-content">
					<form name="expFormAssignment"> 
                    <div class="post">
						<div class="row">
							<div class="col-sm-4">
								<div class="form-group">
									<div class="input-group date" data-provide="datepicker">
										<div class="input-group-prepend">
										  <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
										</div>																
										<input wire:model="createAssignmentStartDate" type="text" id="createAssignmentStartDateId" class="form-control" onchange='Livewire.emit("selectCreateAssignmentStartDate", this.value)' placeholder="Tanggal Awal ..." autocomplete="off">
									</div>
								</div>
							</div>
							<div class="col-sm-4">
								<div class="form-group">
									<div class="input-group date" data-provide="datepicker">
										<div class="input-group-prepend">
										  <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
										</div>																
										<input wire:model="createAssignmentEndDate" type="text" id="createAssignmentEndDateId" class="form-control" onchange='Livewire.emit("selectCreateAssignmentEndDate", this.value)' placeholder="Tanggal Akhir ..." autocomplete="off">
									</div>
								</div>
							</div>
							<div class="col-sm-4">
								<div wire:ignore class="form-group">
									<select wire:model="siteAssignment" id="siteAssignmentId" class="form-control" onchange='Livewire.emit("selectSiteAssignment", this.value)' placeholder="Job site">
										<option value="" selected="selected">Job Site</option>
										@foreach($sites as $item)
											<option value="{{$item->id}}">{{$item->name}}</option>
										@endforeach
									</select>
								</div>
							</div>						
						</div>
						<div class="row">
							<div class="col-sm-3">
								<div class="form-group">
									<button wire:click="exportAssignment" id="exportAssignment" type="button" class="btn btn-info btn-sm"><i class="fa fa-file-excel"></i> Export Izin</button>
								</div>
							</div>						
						</div>
                    </div>
					</form>
                </div>
              </div>
            </div>			
			
            <div class="card">
              <div class="card-header p-2">
				Klaim Cuti Besar
              </div>
              <div class="card-body">
                <div class="tab-content">
					<form name="expFormBigLeaveClaim"> 
                    <div class="post">
						<div class="row">
							<div class="col-sm-4">
								<div class="form-group">
									<div class="input-group date" data-provide="datepicker">
										<div class="input-group-prepend">
										  <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
										</div>																
										<input wire:model="createBigLeaveClaimStartDate" type="text" id="createBigLeaveClaimStartDateId" class="form-control" onchange='Livewire.emit("selectCreateBigLeaveClaimStartDate", this.value)' placeholder="Tanggal Awal ..." autocomplete="off">
									</div>
								</div>
							</div>
							<div class="col-sm-4">
								<div class="form-group">
									<div class="input-group date" data-provide="datepicker">
										<div class="input-group-prepend">
										  <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
										</div>																
										<input wire:model="createBigLeaveClaimEndDate" type="text" id="createBigLeaveClaimEndDateId" class="form-control" onchange='Livewire.emit("selectCreateBigLeaveClaimEndDate", this.value)' placeholder="Tanggal Akhir ..." autocomplete="off">
									</div>
								</div>
							</div>
							<div class="col-sm-4">
								<div wire:ignore class="form-group">
									<select wire:model="siteBigLeaveClaim" id="siteBigLeaveClaimId" class="form-control" onchange='Livewire.emit("selectSiteBigLeaveClaim", this.value)' placeholder="Job siteBigLeave">
										<option value="" selected="selected">Job Site</option>
										@foreach($sites as $item)
											<option value="{{$item->id}}">{{$item->name}}</option>
										@endforeach
									</select>
								</div>
							</div>						
						</div>
						<div class="row">
							<div class="col-sm-3">
								<div class="form-group">
									<button wire:click="exportBigLeaveClaim" id="exportBigLeaveClaim" type="button" class="btn btn-info btn-sm"><i class="fa fa-file-excel"></i> Export Klaim Cuti Besar</button>
								</div>
							</div>						
						</div>
                    </div>
					</form>
                </div>
              </div>
            </div>		
			
			
          </div>
        </div>
      </div>
    </section>
</div>
@push('styles')
  <link rel="stylesheet" type="text/css" href="{{asset('template/plugins/pikaday/pikaday.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('template/custom/single.css')}}">
	    <link rel="stylesheet" type="text/css" href="{{asset('template/plugins/timepicker/timepicker.modif.css')}}">
		<link rel="stylesheet" href="{{asset('template/custom/styles.css')}}">
@endpush
@push('scripts')
<script src="{{asset('template/plugins/moment/moment.min.js')}}"></script>
<script src="{{asset('template/plugins/pikaday/pikaday.js')}}"></script>
<script src="{{asset('template/plugins/timepicker/timepicker.modif.js')}}"></script>
<script>
    var picker4 = new Pikaday({
        field: document.getElementById('createStartDateId'),
        format: 'DD/MM/YYYY',
    });
	
	var picker5 = new Pikaday({
		field: document.getElementById('createEndDateId'),
		format: 'DD/MM/YYYY',
	});
	
	var picker4 = new Pikaday({
        field: document.getElementById('createPermissionStartDateId'),
        format: 'DD/MM/YYYY',
    });
		
	var picker5 = new Pikaday({
		field: document.getElementById('createPermissionEndDateId'),
		format: 'DD/MM/YYYY',
	});
	
	var picker4 = new Pikaday({
        field: document.getElementById('createAssignmentStartDateId'),
        format: 'DD/MM/YYYY',
    });
		
	var picker5 = new Pikaday({
		field: document.getElementById('createAssignmentEndDateId'),
		format: 'DD/MM/YYYY',
	});	
	
	var picker4 = new Pikaday({
        field: document.getElementById('createBigLeaveClaimStartDateId'),
        format: 'DD/MM/YYYY',
    });
		
	var picker5 = new Pikaday({
		field: document.getElementById('createBigLeaveClaimEndDateId'),
		format: 'DD/MM/YYYY',
	});
</script>
 <script>

 $(document).ready(function(){
    $('#exportDayOfId').click(function(){
        $('#siteId').prop('selectedIndex',0);
    })
	
	$('#exportPermission').click(function(){
        $('#sitePermissionId').prop('selectedIndex',0);
    })
	
	$('#exportAssignment').click(function(){
        $('#siteAssignmentId').prop('selectedIndex',0);
    })	
	
	$('#exportBigLeaveClaim').click(function(){
        $('#siteBigLeaveClaimId').prop('selectedIndex',0);
    })

});
</script>
@endpush
