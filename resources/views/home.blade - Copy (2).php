@extends('layouts.app')

@section('content')
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Halaman Beranda</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Halaman Beranda</li>
            </ol>
          </div>
        </div>
      </div>
    </section>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-6">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Cuti belum diapprov</h3>
              </div>
              <div class="card-body">
                <table class="table table-bordered table-sm">
                  <thead>
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>NRP / Nama</th>
                      <th style="width: 100px">Mulai</th>
                      <th style="width: 100px">Selesai</th>
                    </tr>
                  </thead>
                  <tbody>
				  @forelse($dayOfs as $index=> $item)
                    <tr>
                      <td>{{$index++}}</td>
                      <td><a type="button" wire:click="$emitTo('transaction.day-of.detail','detailDayOf',{{$item->id}})" title="Detail">{{trim(Str::limit($item->nrp,20))}} <strong>{{trim(Str::limit($item->name,20))}}</strong></a></td>
                      <td>
                        <div>
                          <div style="width: 100%">{{date('d/m/Y',strtotime($item->start))}}</div>
                        </div>
                      </td>
                      <td>{{date('d/m/Y',strtotime($item->end))}}</td>
                    </tr>
				@empty
                    <tr>
                      <td></td>
                      <td>Belum ada data</td>
                      <td>
                        <div class="progress progress-xs">
                          <div style="width: 55%"></div>
                        </div>
                      </td>
                      <td></td>
                    </tr>				
				@endforelse
                  </tbody>
                </table>
              </div>
              <div class="card-footer clearfix">
			  {{$dayOfs->render()}}
              </div>
            </div>

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Izin belum diapprov</h3>
              </div>
              <div class="card-body">
                <table class="table table-bordered table-sm">
                  <thead>
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>NRP / Nama</th>
                      <th style="width: 100px">Mulai</th>
                      <th style="width: 100px">Selesai</th>
                    </tr>
                  </thead>
                  <tbody>
				  @forelse($dayOfs as $index=> $item)
                    <tr>
                      <td>{{$index++}}</td>
                      <td>{{trim(Str::limit($item->nrp,20))}} <strong>{{trim(Str::limit($item->name,20))}}</strong></td>
                      <td>
                        <div>
                          <div style="width: 100%">{{date('d/m/Y',strtotime($item->start))}}</div>
                        </div>
                      </td>
                      <td>{{date('d/m/Y',strtotime($item->end))}}</td>
                    </tr>
				@empty
                    <tr>
                      <td></td>
                      <td>Belum ada data</td>
                      <td>
                        <div class="progress progress-xs">
                          <div style="width: 55%"></div>
                        </div>
                      </td>
                      <td></td>
                    </tr>				
				@endforelse
                  </tbody>
                </table>
              </div>
              <div class="card-footer clearfix">
			  {{$dayOfs->render()}}
              </div>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-md-6">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Dinas belum di approv</h3>
              </div>
              <div class="card-body">
                <table class="table table-bordered table-sm">
                  <thead>
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>NRP / Nama</th>
                      <th style="width: 100px">Mulai</th>
                      <th style="width: 100px">Selesai</th>
                    </tr>
                  </thead>
                  <tbody>
				  @forelse($dayOfs as $index=> $item)
                    <tr>
                      <td>{{$index++}}</td>
                      <td>{{trim(Str::limit($item->nrp,20))}} <strong>{{trim(Str::limit($item->name,20))}}</strong></td>
                      <td>
                        <div>
                          <div style="width: 100%">{{date('d/m/Y',strtotime($item->start))}}</div>
                        </div>
                      </td>
                      <td>{{date('d/m/Y',strtotime($item->end))}}</td>
                    </tr>
				@empty
                    <tr>
                      <td></td>
                      <td>Belum ada data</td>
                      <td>
                        <div class="progress progress-xs">
                          <div style="width: 55%"></div>
                        </div>
                      </td>
                      <td></td>
                    </tr>				
				@endforelse
                  </tbody>
                </table>
              </div>
              <div class="card-footer clearfix">
			  {{$dayOfs->render()}}
              </div>
            </div>

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">xxxx</h3>
              </div>
              <div class="card-body">
                <table class="table table-bordered table-sm">
                  <thead>
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>NRP / Nama</th>
                      <th style="width: 100px">Mulai</th>
                      <th style="width: 100px">Selesai</th>
                    </tr>
                  </thead>
                  <tbody>
				  @forelse($dayOfs as $index=> $item)
                    <tr>
                      <td>{{$index++}}</td>
                      <td>{{trim(Str::limit($item->nrp,20))}} <strong>{{trim(Str::limit($item->name,20))}}</strong></td>
                      <td>
                        <div>
                          <div style="width: 100%">{{date('d/m/Y',strtotime($item->start))}}</div>
                        </div>
                      </td>
                      <td>{{date('d/m/Y',strtotime($item->end))}}</td>
                    </tr>
				@empty
                    <tr>
                      <td></td>
                      <td>Belum ada data</td>
                      <td>
                        <div class="progress progress-xs">
                          <div style="width: 55%"></div>
                        </div>
                      </td>
                      <td></td>
                    </tr>				
				@endforelse
                  </tbody>
                </table>
              </div>
              <div class="card-footer clearfix">
			  {{$dayOfs->render()}}
              </div>
            </div>
          </div>

        </div>

      </div>
    </section>
  </div>
@endsection
@push('styles')
  <link rel="stylesheet" href="{{asset('template/custom/home.css')}}">
@endpush
@push('scripts')
<script>
</script>
@endpush
