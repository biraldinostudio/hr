
<div class="content-wrapper"> 
 <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Ubah Data</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('home')}}">Beranda</a></li>
              <li class="breadcrumb-item active">Periode Cuti</li>
            </ol>
          </div>
        </div>
      </div>
    </section>
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-8">
            <div class="card card-default">
              <div class="card-header">
                <h3 class="card-title">Standart Periode Cuti</h3>
              </div>
                <div class="card-body">
				@forelse($dayofperiods as $key=>$item)
				<div class="row">
					<div class="col-md-6">
					  <div class="form-group">
						<p>@if($item->staff=='1') Staff: <strong>{{$item->day}} Hari</strong> @endif @if($item->staff=='0') Non Staff: <strong>{{$item->day}} Hari</strong> @endif </p>
					  </div>					
					</div>
					<a type="button" wire:click="$emitTo('amenities.day-of-period.update','updateDayOfPeriod',{{$item->id}})"  title="Ubah"><i class="fa fa-edit"></i></a>					
				</div>
				@empty
				<form wire:submit.prevent="store" novalidate>
				<div class="row">
					<div class="col-md-4">
					  <div class="form-group">
						<label>Staff (Hari)</label>
						<input wire:model="staff" type="text" class="form-control @error('staff') is-invalid @enderror" value="{{old('staff')}}" maxlength="2" required>
						@error('staff')
							<span class="invalid-feedback" role="alert">
								{{ $message }}
							</span>
						@enderror
					  </div>					
					</div>
					<div class="col-md-4">
					  <div class="form-group">
						<label>Non Staff (Hari)</label>
						<input wire:model="nonstaff" type="text" class="form-control @error('nonstaff') is-invalid @enderror" value="{{old('nonstaff')}}" maxlength="2" required>
						@error('nonstaff')
							<span class="invalid-feedback" role="alert">
								{{ $message }}
							</span>
						@enderror
					  </div>					
					</div>				
				</div>
                </div>
                <div class="card-footer">
                  <a href="{{route('day-of-period')}}" type="button" class="btn btn-default" data-dismiss="modal">Tutup</a>&nbsp;&nbsp;&nbsp;&nbsp;
				  <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan Data</button>
                </div>
              </form>				
				@endforelse

            </div>
          </div>
        </div>
      </div>
    </section>
</div>