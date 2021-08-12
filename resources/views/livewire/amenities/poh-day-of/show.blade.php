 <div class="content-wrapper">
 
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Pengaturan Cuti</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('home')}}">Beranda</a></li>
              <li class="breadcrumb-item active">Pengaturan Cuti</li>
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
                       <th wire:click="sortBy('poh_id')" style="cursor:pointer;">POH @include('partials._sort-icon',['field'=>'poh_id'])</th>
                        <th wire:click="sortBy('site_id')" style="cursor:pointer;">JobSite @include('partials._sort-icon',['field'=>'site_id'])</th>
						<th>Hari Cuti</th>
						<th>Hari Travel</th>
						<th>Hari Ticket</th>
						<th>Lumpsum</th>
                       <th wire:click="sortBy('created_at')" style="cursor:pointer;">Dibuat @include('partials._sort-icon',['field'=>'created_at'])</th>
                        <th>Status</th>
						<th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
								@forelse ($pohdayofs as $item)
                                    <tr>
                                        <td>{{$item->poh->name}}</td>									
                                        <td>{{$item->site->name}}</td>
                                        <td>{{$item->day_of}}</td>
                                        <td>{{$item->travel_day}}</td>
                                        <td>{{$item->travel_day_ticket}}</td>
										<td>@if($item->lumpsum_facilities=='1') Dapat @else Tidak @endif</td>										
                                        <td>{{date('d M Y',strtotime($item->created_at))}}</td>
                                        <td>
										 @if ($item->active=='1')
                                            <span class="badge bg-success">Aktif</span>
										@else
											<span class="badge bg-danger">Non Aktif</span>
										@endif	
                                        </td>
										<td><a type="button" wire:click="$emitTo('amenities.poh-day-of.update','updatePohDayOf',{{$item->id}})"  title="Ubah"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;&nbsp; 
									        <a type="button" wire:click="$emitTo('amenities.poh-day-of.delete','deletePohDayOf',{{$item->id}})" title="Hapus"><i class="fa fa-trash"></i></a>
									</td>
                                    </tr>
								@empty
									Data tidak ada!
								@endforelse
                  </tbody>
			   
                </table>
        <p>
            Showing {{$pohdayofs->firstItem()}} to {{$pohdayofs->lastItem()}} out of {{$pohdayofs->total()}} items
        </p>
        <p>
				{{$pohdayofs->links()}}
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