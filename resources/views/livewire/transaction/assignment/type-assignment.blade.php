
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Lokasi Tugas</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Lokasi Tugas</li>
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
				Lokasi Tugas
              </div>
              <div class="card-body">
                <div class="tab-content">
					<form name="expFormDayOf"> 
                    <div class="post">
						<div class="row">
							<div class="col-sm-3">
								<div class="form-group">
									<button type="button" wire:click="$emitTo('transaction.assignment.create','createAssignmentJobSite')" class="btn btn-info btn-sm form-control"><i class="fa fa-map-marker"></i> Area Job Site</button>
								</div>
							</div>
							<div class="col-sm-3">
								<div class="form-group">
									<button type="button" dwire:click="$emitTo('transaction.assignment.create','createAssignmentRegional')" class="btn btn-warning btn-sm form-control"><i class="fa fa-map-marker"></i> Area Regional</button>
								</div>
							</div>
							<div class="col-sm-3">
								<divclass="form-group">
									<button type="button" data-toggle="modal" data-target="#createModal" class="btn btn-primary btn-sm form-control"><i class="fa fa-map-marker"></i> Luar Regional</button>
								</div>
							</div>						
						</div>
						<div class="row">
							<div class="col-sm-3">
								<div class="form-group">

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
	
	$('#exportBigLeaveClaim').click(function(){
        $('#siteBigLeaveClaimId').prop('selectedIndex',0);
    })

});
</script>
@endpush
