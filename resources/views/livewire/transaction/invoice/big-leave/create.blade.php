<div wire:ignore.self class="modal fade" id="createModal" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Refrensi Klaim Cuti Besar</h4>
          <button wire:click="cancel" onclick="clearSelect2()" type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
		 <form wire:submit.prevent="store">
		 @if($workDay<1825)
			<p>Maaf Refrensi Klaim Cuti Besar untuk karyawan ini tidak bisa dilanjutkan karena masa kerja belum mencapai 5 tahun.</p>	 
		 @elseif($standartDayBigLeave=='' or $standartDayBigLeave==null)
			<p>Maaf Anda tidak bisa melanjutkan proses untuk karyawan ini, dikarenakan parameter cuti besar untuk POH <strong>{{$pohName}}</strong> job site <strong>{{$siteName}}</strong> belum diatur oleh administrator.<br><br>
			Pengaturan data ini ada di menu <a href="{{route('poh-big-leave')}}"><strong>Pengaturan Cuti Besar</strong></a><p>
		 @else
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
						<div wire:ignore class="input-group">
							<div class="input-group-prepend">
								  <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
							</div>
							<input wire:model="bigLeaveStartDate" type="text" id="bigLeaveStartDateIdx" class="form-control" onchange='Livewire.emit("selectBigLeaveStartDate", this.value)' placeholder="Mulai cuti ..." autocomplete="off">
						</div>
					</div>
				</div>
				<div class="col-sm-6">
					<div wire:ignore  class="form-group">
						<div class="input-group">
							<div class="input-group-prepend">
								  <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
							</div>
							<input wire:model="bigLeaveEndDate" type="text" id="bigLeaveEndDateIdx" class="form-control" onchange='Livewire.emit("selectBigLeaveEndDate", this.value)' placeholder="Selesai cuti ..." autocomplete="off">
						</div>
					</div>
				</div>					
			</div>
			
            <div class="row">
              <div class="col-12 col-sm-12">
                <div class="form-group">
				<label>Keterangan Tambahan</label>
					<textarea wire:model="description" type="text" id="descriptionId" class="form-control" placeholder="Keterangan"></textarea>
                </div>
              </div>			  
            </div>
			
			<script>
				var picker50 = new Pikaday({
					field: document.getElementById('bigLeaveStartDateIdx'),
					format: 'DD/MM/YYYY',
				});
				
				var picker51 = new Pikaday({
					field: document.getElementById('bigLeaveEndDateIdx'),
					format: 'DD/MM/YYYY',
				});		
			</script>			
			
			@endif
			<span class="invalid-feedback select2Error" role="alert">
			@if ($errors->any())
				<div class="alert alert-danger">
					@foreach ($errors->all() as $error)
					   {{ $error }} , 
					@endforeach
				</div>
			@endif	
		</span>		
        </div>   
        <div class="modal-footer justify-content-between">
			<button wire:click="cancel" type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
			<button type="submit" class="btn btn-primary"><i class="fa fa-tasks"></i> Release</button>
        </div>
		</form>
      </div>
    
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
@push('styles')
  <link rel="stylesheet" type="text/css" href="{{asset('template/plugins/pikaday/pikaday.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('template/custom/single.css')}}">
	    <link rel="stylesheet" type="text/css" href="{{asset('template/plugins/timepicker/timepicker.modif.css')}}">
@endpush
@push('scripts')
<script src="{{asset('template/plugins/moment/moment.min.js')}}"></script>
<script src="{{asset('template/plugins/pikaday/pikaday.js')}}"></script>
<script src="{{asset('template/plugins/timepicker/timepicker.modif.js')}}"></script>

@endpush