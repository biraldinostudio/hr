<div wire:ignore.self class="modal fade" id="createModal" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Tambah Data</h4>
          <button wire:click="cancel" onclick="clearSelect2()" type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form wire:submit.prevent="store" name="crtForm">
        <div class="modal-body" style="overflow: visible;">
            <div class="row">
              <div class="col-md-6">
				  <label>Site</label>			  
					<div wire:ignore class="form-group">
						<select wire:model="site" id="siteId" class="form-control">
							<option value="" selected="selected">Pilih Site</option>
							@foreach($sites as $item)
								<option value="{{$item->id}}">{{$item->name}}</option>
							@endforeach
						</select>
					</div>
              </div>
              <div class="col-md-6">
				  <label>POH</label>			  
					<div wire:ignore class="form-group">
						<select wire:model="poh" id="pohId" class="select2 form-control">
							<option value="" selected="selected">Pilih POH</option>
							@foreach($pohs as $item)
								<option value="{{$item->id}}">{{$item->name}}</option>
							@endforeach
						</select>
					</div>		
              </div>			
              <div class="col-md-6">
			  <label>Department</label>
                <div wire:ignore class="form-group">
					<select wire:model="department" id="departmentId" class="select2 form-control">
						<option value="" selected="selected">Pilih Department</option>
						@foreach($departments as $item)
							<option value="{{$item->id}}">{{$item->name}}</option>
						@endforeach
					</select>
                </div>
              </div>
              <div class="col-md-6">
			  <label>Jabatan</label>			  
                <div wire:ignore class="form-group">
					<select wire:model="position" id="positionId" class="select2 form-control">
						<option value="" 
							@if (old('position')=='' or old('position')==0) selected="selected"@endif> Pilih Jabatan
						</option>
						@if(old('department'))
							@foreach ($positions as $item)
								@if(old('department')==$item->department_id)
									<option value="{{ $item->id}}"
										@if($item->id==old('position'))      
											selected="selected"
										@endif >
										{{ $item->name }}
									</option>
								@endif
							@endforeach
						@endif
					</select>
                </div>
              </div>
			   <div class="col-md-6">
					<label>IDR (Non Staff)</label>				
					<div class="form-group">
						<input wire:model="idr" type="text" class="form-control" type-currency="IDR" placeholder="Rp" maxlength="13">
					</div>			   
			   </div>
			   <div class="col-md-6">
					<label>IDR (Staff)</label>				
					<div class="form-group">
						<input wire:model="idrStaff" type="text" class="form-control" type-currency="IDR" placeholder="Rp" maxlength="13">
					</div>			   
			   </div>			   
            </div>
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
          $(document).on('change', '#departmentId', function (e) {
              @this.set('department', e.target.value);
           });		   
          $(document).on('change', '#positionId', function (e) {
              @this.set('position', e.target.value);
           });		   
          $(document).on('change', '#siteId', function (e) {
              @this.set('site', e.target.value);
           });
          $(document).on('change', '#pohId', function (e) {
              @this.set('poh', e.target.value);
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
@endpush