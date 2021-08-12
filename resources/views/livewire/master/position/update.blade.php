<div wire:ignore.self class="modal fade text-left" id="editModal" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">Ubah Data </h4>
                <button type="button" class="close" wire:click="cancel" onclick="clearSelect2()" data-dismiss="modal" aria-label="Close"><i data-feather="x"></i></button>
            </div>
            <form wire:submit.prevent="update" name="crtForm">
                <div class="modal-body" style="overflow: visible;">
                    <label>Departemen: </label>
                    <div wire:ignore class="form-group">
						<select wire:model="department" id="departmentId" class="form-control" style="width: 100%;" onchange='Livewire.emit("selectDepartment", this.value)'>
							<option value="" @if (old('department',$department)=='' or old('department',$department)==0) selected="selected" @endif > Pilih Departemen </option>
							@foreach ($departments as $cat)
								<option value="{{ $cat->id}}" @if (old('department',$department)==$cat->id)selected="selected" @endif> {{ $cat->name }} </option>
							@endforeach
						</select>						
                    </div>
                    <label>Jabatan: </label>
                    <div class="form-group">
                        <input wire:model="name" id="name" type="text" placeholder="Tuliskan Jabatan ..." class="form-control" maxlength="40">
                    </div>
                    <label>Status: </label>
                    <div class="form-group">
                        <select wire:model="status" class="form-control">
                            <option value="" @if (old('status')=='')selected="disabled"@endif> Pilih Status</option>
                            <option value="1" @if(old('status','status') == '1')selected="selected"@endif>Aktif</option>
                            <option value="0" @if(old('status','status') == '0')selected="selected"@endif>Non Aktif</option>												
                        </select>
                    </div>
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
					  <button wire:click="cancel" onclick="clearSelect2()" type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-window-close"></i> Batal</button>
					  <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Ubah Data</button>
				</div>	
            </form>
        </div>
    </div>
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
          $(document).on('change', '#departmentId', function (e) {
              @this.set('department', e.target.value);
           });		   		   	   
       });

       document.addEventListener('livewire:load', function (event) {
          @this.on('refreshDropdown', function () {
              $('.select2').select2();
          });  
     })
</script>
	 <script>
	 
	$('.select2Error').attr('style','display: block !important');
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
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>
@push('scripts')
	<script>
		$('#editModal').on('shown.bs.modal', function () {
			$('#name').focus();
		})
	</script>  
@endpush
@endpush
  