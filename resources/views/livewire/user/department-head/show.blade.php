 <div class="content-wrapper">
 
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Peran Department Head</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('home')}}">Beranda</a></li>
              <li class="breadcrumb-item active">Peran Department Head</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <div class="left">
                <div class="card-tools">
                  <div class="input-group input-group-sm" style="width: 300px;">
                    <select wire:model="perPagination" class="form-control" style="max-width: 50px;">
                      <option value="5">5</option>
                      <option value="10">10</option>
                      <option value="15">15</option>
                      <option value="20">20</option>
                      <option value="25">25</option>												
                  </select> 
                    <input wire:model="search" type="text" class="form-control float-right" placeholder="Cari">
                    <div class="input-group-append input-group-sm">
                      <select wire:model="status" class="form-control" style="width: 60px;">
                        <option value="1">Aktif</option>
                        <option value="0">Non Aktif</option>												
                    </select> 
                    </div>
                  </div>
                </div>
              </div>
              <div class="right">
                <div class="card-tools">
                  <div class="input-group input-group-sm" style="width: 150px;">
					
					<button type="button" data-toggle="modal" data-target="#createModal" class="btn btn-info btn-sm">Tambah</button>
                  </div>
                </div>
              </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0" style="height: 460px;">
                <table class="table table-head-fixed text-nowrap">
                  <thead>
                    <tr>
                        <th wire:click="sortBy('nrp')" style="cursor:pointer;">NRP @include('partials._sort-icon',['field'=>'nrp'])</th>
                        <th wire:click="sortBy('name')" style="cursor:pointer;">Nama @include('partials._sort-icon',['field'=>'name'])</th>
                        <th wire:click="sortBy('position_id')" style="cursor:pointer;">Jabatan @include('partials._sort-icon',['field'=>'position_id'])</th>
						<th wire:click="sortBy('department_id')" style="cursor:pointer;">Departemen @include('partials._sort-icon',['field'=>'department_id'])</th>
                        <th wire:click="sortBy('site_id')" style="cursor:pointer;">Site @include('partials._sort-icon',['field'=>'site_id'])</th>
                        <th>Status</th>
						<th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
						@forelse ($employees as $item)
                            <tr>
								<td>{{$item->nrp}}</td>
								<td>{{$item->name}}</td>
								<td>{{$item->position}}</td>
								<td>{{$item->department}}</td>
								<td>{{$item->site}}</td>
								<td>
									@if ($item->active=='1')
										<span class="badge bg-success">Aktif</span>
									@else
										<span class="badge bg-danger">Non Aktif</span>
									@endif	
								</td>
								<td>
									<a type="button" wire:click="$emitTo('user.department-head.delete','deleteDepartmentHead',{{$item->id}})" title="Non Aktifkan"><i class="fa fa-ban"></i></a>
								</td>
                            </tr>
								@empty
									Data tidak ada!
								@endforelse
                  </tbody>
			   
                </table>
        <p>
            Showing {{$employees->firstItem()}} to {{$employees->lastItem()}} out of {{$employees->total()}} items
        </p>
        
				{{$employees->links()}}
              </div>
			  
              <!-- /.card-body -->
            </div> 
            <!-- /.card -->
          </div>
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
	
</div>

@push('styles')
<link rel="stylesheet" href="{{asset('template/custom/styles.css')}}">
@endpush
