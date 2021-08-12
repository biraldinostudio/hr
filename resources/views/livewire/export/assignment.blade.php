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
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Export Data</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-9">
            <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Cuti</a></li>
                  <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Izin</a></li>
                  <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Tugas</a></li>
                  <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Training</a></li>				  
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="active tab-pane" id="activity">
                    <!-- Post -->
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
									<select wire:model="site" id="siteId" class="form-control" onchange='Livewire.emit("selectSite", this.value)' placeholder="Job Site">
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
									<button wire:click="exportDayOf" id="exportId" type="button" class="btn btn-info btn-sm"><i class="fa fa-file-excel"></i> Export Excel</button>
								</div>
							</div>						
						</div>
						
                    </div>

                    <!-- /.post -->
                  </div>
                  <!-- /.tab-pane -->
                  <div class="tab-pane" id="timeline">
                    <!-- The timeline -->
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
									<select wire:model="sitePermission" id="sitePermissionId" class="form-control" onchange='Livewire.emit("selectPermissionSite", this.value)' placeholder="Job Site">
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
									<button wire:click="exportPermission" id="exportId" type="button" class="btn btn-info btn-sm"><i class="fa fa-file-excel"></i> Export Excel</button>
								</div>
							</div>						
						</div>
					</div>
                  </div>
                  <!-- /.tab-pane -->

                  <div class="tab-pane" id="settings">
                    <form class="form-horizontal">
                      <div class="form-group row">
                        <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10">
                          <input type="email" class="form-control" id="inputName" placeholder="Name">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                          <input type="email" class="form-control" id="inputEmail" placeholder="Email">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputName2" class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="inputName2" placeholder="Name">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputExperience" class="col-sm-2 col-form-label">Experience</label>
                        <div class="col-sm-10">
                          <textarea class="form-control" id="inputExperience" placeholder="Experience"></textarea>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputSkills" class="col-sm-2 col-form-label">Skills</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="inputSkills" placeholder="Skills">
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          <div class="checkbox">
                            <label>
                              <input type="checkbox"> I agree to the <a href="#">terms and conditions</a>
                            </label>
                          </div>
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          <button type="submit" class="btn btn-danger">Submit</button>
                        </div>
                      </div>
                    </form>
                  </div>
                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
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
	

</script>
 <script>

 $(document).ready(function(){
    $('#exportId').click(function(){
        $('#siteId').prop('selectedIndex',0);
    })
});
</script>
@endpush
