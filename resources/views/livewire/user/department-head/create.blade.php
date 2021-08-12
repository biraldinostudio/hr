
<div wire:ignore.self class="modal fade" id="createModal" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Tambah Data </h4>
          <button wire:click="cancel" onclick="clearSelect2()" type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form wire:submit.prevent="store" name="crtForm">
        <div class="modal-body" style="overflow: visible;">
		<p style="font-size:11px;"> Hanya karyawan dengan status <b>Staff</b> dan Status <b>Aktif</b> yang bisa dipilih peran sebagai Department Head</p>
            <label>Site: </label>
            <div wire:ignore class="form-group">
                <select wire:model="site" id="siteId" class="select2 form-control" onchange='Livewire.emit("selectSite", this.value)'>
                   <option value="" @if(old('site')=='') selected="selected" @endif>Pilih Site </option>
                    @foreach($sites as $item)
                        <option value="{{$item->id}}" @if(old('site')==$item->id) selected="selected" @endif>{{$item->name}}</option>
                    @endforeach
                </select>
            </div>
			
            <label>Department Head: </label>
            <div wire:ignore class="form-group">
					<select wire:model="employee" id="employeeId" class="select2 form-control" onchange='Livewire.emit("selectEmployee", this.value)'>
						<option value="" 
							@if (old('employee')=='' or old('employee')==0) selected="selected"@endif> Pilih Department Head
						</option>
						@if(old('site'))
							@foreach ($employees as $item)
								@if(old('site')==$item->site_id)
									<option value="{{ $item->id}}"
										@if($item->id==old('employee'))      
											selected="selected"
										@endif >
										{{ $item->nrp }} 
									</option>
								@endif
							@endforeach
						@endif
					</select>
            </div>
			@if($employee!='')
				<div class="form-group">
					Anda akan menjadikan <b>{{$getSuggestName}}</b> dengan NRP: <b>{{$getSuggestNRP}} </b> jabatan: <b>{{$getSuggestPosition}}</b> berperan sebagai Pimpinan departemen: <b>{{$getSuggestDepartment}}</b>
				</div>
			@else
			@endif		
		<div class="form-group">
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
        </div>

        <div class="modal-footer justify-content-between">
          <button wire:click="cancel" onclick="clearSelect2()" type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan Data</button>
        </div></form>
      </div>
    
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  @push('styles')
  <link rel="stylesheet" href="{{asset('template/plugins/select2/css/select2.min.css')}}">
  <link rel="stylesheet" href="{{asset('template/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
@endpush
@push('scripts')
<script src="{{asset('template/plugins/moment/moment.min.js')}}"></script>
<script src="{{asset('template/plugins/select2/js/select2.full.min.js')}}"></script>
<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })

  })
</script>
<script>
       $(document).ready(function () {
          $(document).on('change', '#employeeId', function (e) {
              @this.set('employee', e.target.value);
           });		   	   
       });

       document.addEventListener('livewire:load', function (event) {
          @this.on('refreshDropdown', function () {
              $('.select2').select2();
          });  
     })
</script>

 <script>
function clearSelect2() {
   var frm = document.getElementsByName('crtForm')[0];
   frm.submit();
   frm.reset();
   return false;
}
</script>
<script>
    $('#siteId').change(function(){
		$.get('sites/' + this.value + '/employees.json', function(employees){
			var $subemployee = $('#employeeId');
			$subemployee.find('option').remove().end();
			$("#employeeId").append('<option value="">Pilih Department Head</option>');
			$.each(employees, function(index, employee) {
				$subemployee.append($('<option/>').attr('value', employee.id).text([employee.nrp,employee.name])); 
			});
		});
    });
	$(document).ready(function() {
		$(".site option[value='0']").attr("disabled","disabled");
		$(".employee option[value='0']").attr("disabled","disabled");
	});
</script>
@endpush
