<div wire:ignore.self class="modal fade" id="createModal" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Tambah Data</h4>
          <button wire:click="cancel" onclick="clearSelect2()" type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        
        <div class="modal-body">
		<form wire:submit.prevent="store" name="crtForm">
			<div class="row">
				<div class="col-md-6">
					<label>Site: </label>
					<div wire:ignore class="form-group">
						<select wire:model="site" id="siteId" class="select2 form-control @error('site') is-invalid @enderror">
						   <option value="" @if(old('site')=='') selected="selected" @endif>Pilih Site</option>
							@foreach($sites as $item)
								<option value="{{$item->id}}" @if(old('site')==$item->id) selected="selected" @endif>{{$item->name}}</option>
							@endforeach
						</select>
					</div>				
				</div>
				<div class="col-md-6">
					<label>POH: </label>
					<div wire:ignore class="form-group">
						<select wire:model="poh" id="pohId" class="select2 form-control @error('poh') is-invalid @enderror">
						   <option value="" @if(old('poh')=='') selected="selected" @endif>Pilih POH</option>
							@foreach($pohs as $item)
								<option value="{{$item->id}}" @if(old('poh')==$item->id) selected="selected" @endif>{{$item->name}}</option>
							@endforeach
						</select>			
					</div>				
				</div>
				<div class="col-md-6">
					<label>Hari Cuti: </label>
					<div class="form-group">
						<input wire:model="dayof" type="text" placeholder="Hari cuti ..." class="form-control" maxlength="2">
					</div>				
				</div>
				
				<div class="col-md-6">
					<label>Lumpsum: </label>
					<div wire:ignore class="form-group">
						<select wire:model="lumpsum" class="form-control">
							<option value="" data-type=""@if (request('lumpsum')=='' or request('jenis')=='')selected="selected" @endif>Fasilitas lumpsum</option>
							<option value="1" @if (old('lumpsum') == 'Dapat') selected="selected" @endif>Dapat</option>
							<option value="0" @if (old('lumpsum') == 'Tidak') selected="selected" @endif>Tidak</option>
						</select>		
					</div>				
				</div>				
				
			</div>
			<div class="row">
				<div class="col-md-6">	
					<label>Hari Travel (PP): </label>
					<div class="form-group">
						<input wire:model="travel" type="text" placeholder="Hari travel (PP) ..." class="form-control" maxlength="1">
					</div>				
				</div>
				<div class="col-md-6">
					<label>Hari Ticket (PP): </label>
					<div class="form-group">
						<input wire:model="travel_ticket" type="text" placeholder="Hari ticket (PP) ..." class="form-control" maxlength="1">
					</div>					
				</div>
				<div class="col-md-6">
				</div>
				<div class="col-md-6">
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
          <button type="submit" class="btn btn-primary">Simpan Data</button>
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