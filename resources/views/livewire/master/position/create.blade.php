<div wire:ignore.self class="modal fade text-left" id="createModal" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">Tambah Data </h4>
                <button type="button" class="close" wire:click="cancel" onclick="clearSelect2()" data-dismiss="modal" aria-label="Close"><i data-feather="x"></i></button>
            </div>
            <form wire:submit.prevent="store" name="crtForm">
                <div class="modal-body" style="overflow: visible;">
                    <label>Departemen: </label>
                    <div wire:ignore class="form-group">
                        <select wire:model="department" id="departmentId" class="select2 form-control" onchange='Livewire.emit("selectDepartment", this.value)'>
                           <option value="" @if(old('department')=='') selected="selected" @endif>Pilih Departemen</option>
                            @foreach($departments as $item)
                                <option value="{{$item->id}}" @if(old('department')==$item->id) selected="selected" @endif>{{$item->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <label>Jabatan: </label>
                    <div class="form-group">
                        <input wire:model="name" id="name" type="text" placeholder="Tuliskan nama site ..." class="form-control" maxlength="40">
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
					  <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan Data</button>
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
function clearSelect2() {
   var frm = document.getElementsByName('crtForm')[0];
   frm.submit();
   frm.reset();
   return false;
}
$('#createModal').on('show.bs.modal', function (e) {
  $(this)
    .find("select")
       .val("")
       .end()
    .find("input[type=checkbox], input[type=radio]")
       .prop("checked", "")
       .end();
})
</script>
<script>
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>
@push('scripts')
	<script>
		$('#createModal').on('shown.bs.modal', function () {
			$('#name').focus();
		})
	</script>  
@endpush
@endpush
