
 <div class="content-wrapper">
      @include('livewire.transaction.permission.approval')
	  @include('livewire.transaction.permission.not-approv')
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Pengajuan Izin</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('home')}}">Beranda</a></li>
              <li class="breadcrumb-item active">Pengajuan Izin</li>
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
                        <th wire:click="sortBy('start_date')" style="cursor:pointer;">Mulai @include('partials._sort-icon',['field'=>'start_date'])</th>
                        <th wire:click="sortBy('end_date')" style="cursor:pointer;">Selesai @include('partials._sort-icon',['field'=>'end_date'])</th>		
                        <th wire:click="sortBy('in_date')" style="cursor:pointer;">On Site @include('partials._sort-icon',['field'=>'in_date'])</th>
						<th>Jml Hari</th>
                        <th>Approv</th>
						<th>Status</th>
										<th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
								@forelse ($permissions as $item)
                                    <tr>
                                        <td> {{$item->nrp}}</td>									
                                        <td>{{$item->name}}</td>
                                        <td>{{date('d/M/Y',strtotime($item->start_date))}}</td>										
                                        <td>{{date('d/M/Y',strtotime($item->end_date))}}</td>										
                                        <td>{{date('d/M/Y',strtotime($item->in_date))}}</td>
										<td>{{$item->sum_day}}</td>										
                                        <td>
											@if ($item->approv=='1')
												<span class="badge bg-success">Approv</span>
											@elseif(Auth::user()->level=='department_head' and $item->head_approv=='1' and Auth::user()->hr_head=='0')
												<span class="badge bg-success">Approv</span>
											@elseif(Auth::user()->hr_head=='1' and $item->hrd_approv=='1')
												<span class="badge bg-success">Approv</span>
											@elseif ($item->approv=='2')
											<span class="badge bg-danger">Not Approv</span>													
											@elseif($item->head_approv=='0' and $item->hrd_approv=='0')
												<a href="#"><span class="badge bg-warning">Waiting</span></a>
											@else
												<a href="#"><span class="badge bg-warning">Waiting</span></a>												
											@endif
                                        </td>										
                                        <td>
										 @if ($item->active=='1')
                                            <span class="badge bg-success">Aktif</span>
										@else
											<span class="badge bg-danger">Non Aktif</span>
										@endif	
                                        </td>
										<td>
										
										@if($item->employeeLevel=='employee' or $item->employeeLevel=='hrd_admin')
											@if(Auth::user()->level=='department_head' and $item->head_approv=='0' and Auth::user()->hr_head=='0')
												<a type="button" data-toggle="modal" data-target="#approvModal" wire:click="showModalApprov({{ $item->id }})" title="Approv"><i class="fa fa-check-circle fa-lg"></i></a>&nbsp;&nbsp;&nbsp;										

											@elseif(Auth::user()->hr_head=='1' and $item->head_approv=='1' and $item->hrd_approv=='0')
												<a type="button" data-toggle="modal" data-target="#approvModal" wire:click="showModalApprov({{ $item->id }})" title="Approv"><i class="fa fa-check-circle fa-lg"></i></a>&nbsp;&nbsp;&nbsp;								
											@else
											@endif	
										@endif
										
										@if($item->employeeLevel=='department_head')
											@if(Auth::user()->level=='department_head' and Auth::user()->hr_head=='1' and $item->hrd_approv=='0')
												<a type="button" data-toggle="modal" data-target="#approvModal" wire:click="showModalApprov({{ $item->id }})" title="Approv"><i class="fa fa-check-circle fa-lg"></i></a>&nbsp;&nbsp;&nbsp;									
											@endif
											@if(Auth::user()->level=='site_manager' and $item->sm_approv=='0' and $item->hrd_approv=='1')
												<a type="button" data-toggle="modal" data-target="#approvModal" wire:click="showModalApprov({{ $item->id }})" title="Approv"><i class="fa fa-check-circle fa-lg"></i></a>&nbsp;&nbsp;&nbsp;									
											@endif											
										@endif

										@if($item->employeeLevel=='site_manager')
											@if(Auth::user()->level=='department_head' and Auth::user()->hr_head=='1' and $item->hrd_approv=='0')
												<a type="button" data-toggle="modal" data-target="#approvModal" wire:click="showModalApprov({{ $item->id }})" title="Approv"><i class="fa fa-check-circle fa-lg"></i></a>&nbsp;&nbsp;&nbsp;									
											@endif
											@if(Auth::user()->level=='site_manager' and $item->sm_approv=='0' and $item->hrd_approv=='1')
												<a type="button" data-toggle="modal" data-target="#approvModal" wire:click="showModalApprov({{ $item->id }})" title="Approv"><i class="fa fa-check-circle fa-lg"></i></a>&nbsp;&nbsp;&nbsp;									
											@endif											
										@endif											
										
										<a type="button" href="{{route('permission.detail',$item->id)}}" title="Detail"><i class="fa fa-info-circle fa-lg"></i></a>&nbsp;&nbsp;&nbsp; 
										@if($item->approv=='1')<a type="button" href="{{route('permission.preview',$item->id)}}" title="Pengajuan Cuti"><i class="fa fa-file fa-lg"></i></a>@endif								
										
									</td>
                                    </tr>
								@empty
									Data tidak ada!
								@endforelse
                  </tbody>
			   
                </table>
					 
        <p>
            Showing {{$permissions->firstItem()}} to {{$permissions->lastItem()}} out of {{$permissions->total()}} items
        </p>
        <p>
				{{$permissions->links()}}
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