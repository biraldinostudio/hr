
 <div class="content-wrapper">
      @include('livewire.transaction.day-of.approv')
	  @include('livewire.transaction.day-of.not-approv')
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Pengajuan Cuti</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('home')}}">Beranda</a></li>
              <li class="breadcrumb-item active">Pengajuan Cuti</li>
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
                        <th wire:click="sortBy('travel_from_go')" style="cursor:pointer;">Berangkat @include('partials._sort-icon',['field'=>'travel_from_go'])</th>
                        <th wire:click="sortBy('start')" style="cursor:pointer;">Mulai @include('partials._sort-icon',['field'=>'start'])</th>
                        <th wire:click="sortBy('end')" style="cursor:pointer;">Selesai @include('partials._sort-icon',['field'=>'end'])</th>
			            <th wire:click="sortBy('travel_from_back')" style="cursor:pointer;">Kembali @include('partials._sort-icon',['field'=>'travel_from_back'])</th>			
                        <th wire:click="sortBy('in')" style="cursor:pointer;">On Site @include('partials._sort-icon',['field'=>'in'])</th>						
                        <th>Approv</th>
						<th>Status</th>
										<th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
								@forelse ($dayofs as $item)
                                    <tr>
                                        <td> {{$item->nrp}}</td>									
                                        <td>{{$item->name}}</td>
                                        <td>{{date('d/M/Y',strtotime($item->travel_from_go))}}</td>
                                        <td>{{date('d/M/Y',strtotime($item->start))}}</td>										
                                        <td>{{date('d/M/Y',strtotime($item->end))}}</td>
                                        <td>{{date('d/M/Y',strtotime($item->travel_from_back))}}</td>											
                                        <td>{{date('d/M/Y',strtotime($item->in))}}</td>										
                                        <td>
										@if($item->user->level=='department_head')
												@if ($item->approv=='1')
													<span class="badge bg-success">Approv</span>
												@elseif(Auth::user()->level=='department_head' and Auth::user()->hr_head=='1' and $item->hrd_approv=='1')
													<span class="badge bg-success">Approv</span>
												@elseif(Auth::user()->level=='site_manager' and $item->sm_approv=='1')
													<span class="badge bg-success">Approv</span>
												@elseif ($item->approv=='2')
												<span class="badge bg-danger">Not Approv</span>												
												@else
													<a href="#"><span class="badge bg-warning">Waiting</span></a>
												@endif												
										@endif	
										@if($item->user->level=='employee' or $item->user->level=='hrd_admin')
											@if($item->user->staff=='1')
												@if ($item->approv=='1')
													<span class="badge bg-success">Approv</span>
												@elseif(Auth::user()->level=='department_head' and $item->head_approv=='1' and Auth::user()->hr_head=='0')
													<span class="badge bg-success">Approv</span>
												@elseif(Auth::user()->hr_head=='1' and $item->hrd_approv=='1')
													<span class="badge bg-success">Approv</span>
												@elseif(Auth::user()->level=='site_manager' and $item->sm_approv=='1')
													<span class="badge bg-success">Approv</span>
												@elseif ($item->approv=='2')
												<span class="badge bg-danger">Not Approv</span>												
												@else
													<a href="#"><span class="badge bg-warning">Waiting</span></a>
												@endif													
													
											@else
												@if ($item->approv=='1')
													<span class="badge bg-success">Approv</span>
												@elseif(Auth::user()->level=='department_head' and $item->head_approv=='1')
													<span class="badge bg-success">Approv</span>
												@elseif(Auth::user()->hr_head=='1' and $item->hrd_approv=='1')
													<span class="badge bg-success">Approv</span>
												@elseif ($item->approv=='2')
												<span class="badge bg-danger">Not Approv</span>													
												@else
													<a href="#"><span class="badge bg-warning">Waiting</span></a>
												@endif												

											@endif	
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
	
										
										
										@if($item->user->level=='department_head')
											@if(Auth::user()->level=='department_head' and Auth::user()->hr_head=='1' and $item->hrd_approv=='0')
												<a type="button" data-toggle="modal" data-target="#approvModal" wire:click="showModalApprov({{ $item->id }})" title="Approv"><i class="fa fa-check-circle fa-lg"></i></a>&nbsp;&nbsp;&nbsp;									
											@endif
											@if(Auth::user()->level=='site_manager' and $item->sm_approv=='0' and $item->hrd_approv=='1')
												<a type="button" data-toggle="modal" data-target="#approvModal" wire:click="showModalApprov({{ $item->id }})" title="Approv"><i class="fa fa-check-circle fa-lg"></i></a>&nbsp;&nbsp;&nbsp;									
											@endif												
										@endif
										@if($item->user->level=='site_manager')
											@if(Auth::user()->level=='site_manager' and $item->sm_approv=='0')
												<a type="button" data-toggle="modal" data-target="#approvModal" wire:click="showModalApprov({{ $item->id }})" title="Approv"><i class="fa fa-check-circle fa-lg"></i></a>&nbsp;&nbsp;&nbsp;										
											@endif
										@endif		
										@if($item->user->level=='employee' or $item->user->level=='hrd_admin')
											@if(Auth::user()->level=='department_head' and $item->head_approv=='0' and Auth::user()->hr_head=='0')
												<a type="button" data-toggle="modal" data-target="#approvModal" wire:click="showModalApprov({{ $item->id }})" title="Approv"><i class="fa fa-check-circle fa-lg"></i></a>&nbsp;&nbsp;&nbsp;												

											@elseif(Auth::user()->hr_head=='1' and $item->head_approv=='1' and $item->hrd_approv=='0')
												<a type="button" data-toggle="modal" data-target="#approvModal" wire:click="showModalApprov({{ $item->id }})" title="Approv"><i class="fa fa-check-circle fa-lg"></i></a>&nbsp;&nbsp;&nbsp;		
										
											@elseif($item->user->staff=='1' And Auth::user()->level=='site_manager' and $item->head_approv=='1' and $item->hrd_approv=='1' and $item->sm_approv=='0')
												<a type="button" data-toggle="modal" data-target="#approvModal" wire:click="showModalApprov({{ $item->id }})" title="Approv"><i class="fa fa-check-circle fa-lg"></i></a>&nbsp;&nbsp;&nbsp;											
											@else
											@endif	
										@endif

										<a type="button" wire:click="$emitTo('transaction.day-of.detail','detailDayOf',{{$item->id}})" title="Detail"><i class="fa fa-info-circle fa-lg"></i></a>&nbsp;&nbsp;&nbsp; 
										@if($item->approv=='1')<a type="button" href="{{route('day-of.submission',$item->id)}}" title="Pengajuan Cuti"><i class="fa fa-file fa-lg"></i></a>@endif
									</td>
                                    </tr>
								@empty
									Data tidak ada!
								@endforelse
                  </tbody>
			   
                </table>
					 
        <p>
            Showing {{$dayofs->firstItem()}} to {{$dayofs->lastItem()}} out of {{$dayofs->total()}} items
        </p>
        <p>
				{{$dayofs->links()}}
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