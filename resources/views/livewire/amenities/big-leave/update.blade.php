
<div class="content-wrapper"> 
 <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Ubah Data</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Beranda</a></li>
              <li class="breadcrumb-item active">Cuti Besar</li>
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
                <h3 class="card-title">Parameter Cuti Besar</h3>
              </div>
              <form wire:submit.prevent="update" name="crtForm">
                <div class="card-body">
				<div class="row">
					<div class="col-md-6">
					  <div wire:ignore class="form-group">
						<label>Site</label>
						<select wire:model="site" id="siteId" class="form-control">
							<option value="" selected="selected">Pilih Site</option>
							@foreach($sites as $item)
								<option value="{{$item->id}}">{{$item->name}}</option>
							@endforeach
						</select>
					  </div>					
					</div>
					<div class="col-md-6">
					  <div wire:ignore class="form-group">
						<label>POH</label>
						<select wire:model="poh" id="pohId" class="select2 form-control">
							<option value="" @if (old('poh','poh')=='' or old('poh','poh')==0)selected="selected"@endif> Pilih POH </option>
							@foreach ($pohs as $item)
								<option value="{{ $item->id}}"@if (old('poh','poh')==$item->id)selected="selected" @endif> {{ $item->name }} </option>
							@endforeach
						</select>
					  </div>					
					</div>
					<div class="col-md-6">
						<div class="form-group">
						<label>Hari Cuti</label>
							<input wire:model="dayof" type="text" class="form-control" placeholder="Hari cuti ..." maxlength="2">	
						</div>					
					</div>					
				</div>
				<div class="row">
				@if ($errors->any())
					<div class="alert alert-danger" style="font-size:12px;">
						@foreach ($errors->all() as $error)
						   {{ $error }} , 
						@endforeach
					</div>
				@endif			
				</div>				
				
                </div>
                <div class="card-footer">
                  <a href="{{route('big-leave')}}" type="button" class="btn btn-default" data-dismiss="modal">Tutup</a>&nbsp;&nbsp;&nbsp;&nbsp;
				  <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan Data</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>
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
/*$('#createModal').on('show.bs.modal', function (e) {
  $(this)
    .find("select")
       .val("")
       .end()
    .find("input[type=checkbox], input[type=radio]")
       .prop("checked", "")
       .end();
})*/
</script>
<script>
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>
@endpush
