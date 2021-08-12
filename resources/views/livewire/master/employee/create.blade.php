<div wire:ignore.self class="modal fade" id="createModal" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
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
                <div class="form-group">
					<input wire:model="nrp" type="text" class="form-control" placeholder="NRP ..." maxlength="7">
                </div>
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
                <div class="form-group">
					<input wire:model="name" type="text" class="form-control" placeholder="Nama lengkap ..." maxlength="43">
                </div>
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
                <div class="form-group">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                    </div>
                    <input wire:model="join" type="text" id="datepicker" class="form-control" placeholder="Tanggal bergabung ...">
                  </div>
                </div>
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
                <div wire:ignore class="form-group">
					<select wire:model="site" id="siteId" class="form-control">
						<option value="" selected="selected">Pilih Site</option>
						@foreach($sites as $item)
							<option value="{{$item->id}}">{{$item->name}}</option>
						@endforeach
					</select>
                </div>
                  <div class="form-check">
					<input wire:model="staff" id="exampleCheck1" type="checkbox" class="form-check-input" value="1" {{ (old('staff')=='1') ? 'checked="checked"' : '' }}> 					
                    <label class="form-check-label" for="exampleCheck1">Staff</label>
                  </div>				
              </div>
            </div>
            <h5>Lain-lain</h5>
            <div class="row">
              <div class="col-12 col-sm-6">
                <div class="form-group">
					<input wire:model="ktp" type="text" class="form-control" placeholder="Nomor KTP ..." maxlength="16">
                </div>
              </div>
              <div class="col-12 col-sm-6">
                <div class="form-group">
                  <div wire:ignore class="select2-purple">
					<select wire:model="religion" class="form-control">
                    <option value="" data-type=""@if (request('religion')=='' or request('religion')=='')selected="selected" @endif>Pilih Agama</option>
                    <option value="Katolik" @if (old('religion') == 'Katolik') selected="selected" @endif>Katolik</option>
                    <option value="Protestan" @if (old('religion') == 'Protestan') selected="selected" @endif>Protestan</option>
                    <option value="Islam" @if (old('religion') == 'Islam') selected="selected" @endif>Islam</option>
                    <option value="Hindu" @if (old('religion') == 'Hindu') selected="selected" @endif>Hindu</option>
                    <option value="Buddha" @if (old('religion') == 'Buddha') selected="selected" @endif>Buddha</option>
					<option value="Khonghucu" @if (old('religion') == 'Khonghucu') selected="selected" @endif>Khonghucu</option>
					</select>				  
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12 col-sm-6">
                <div class="form-group">
					<input wire:model="blood" type="text" class="form-control" placeholder="Golongan Darah ..." maxlength="6">
                </div>
              </div>
              <div class="col-12 col-sm-6">
                <div class="form-group">
                  <div class="select2-purple">
					<input wire:model="address" type="text" class="form-control" placeholder="Alamat ..." maxlength="100">
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12 col-sm-6">
                <div class="form-group">
					 <input wire:model="birthplace" type="text" id="birthplace" class="form-control" placeholder="Tempat lahir ..." maxlength="39">
                </div>
              </div>
              <div class="col-12 col-sm-6">
                <div class="form-group">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                    </div>
                    <input wire:model="birthdate" type="text" id="birthdate" class="form-control" placeholder="Tanggal lahir ...">
                  </div>
                </div>
              </div>
            </div>
			
			
			
            <div class="row">
              <div class="col-12 col-sm-6">
                <div class="form-group">
					 <input wire:model="lumpsum" type="text" class="form-control" type-currency="IDR" placeholder="Rp Lumpsum" maxlength="13">
                </div>
              </div>
              <div class="col-12 col-sm-6">
                  <div class="form-check">
					<input wire:model="homeFacilities" id="exampleCheck1" type="checkbox" class="form-check-input" value="1" {{ (old('homeFacilities')=='1') ? 'checked="checked"' : '' }}> 					
                    <label class="form-check-label" for="exampleCheck1">Fasilitas Perumahan</label>
                  </div>
              </div>
			  
              <div class="col-12 col-sm-6">
                <div class="form-group">
					 <input wire:model="phone" type="text" class="form-control" placeholder="Nomor HP ..." maxlength="13">
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
  <link rel="stylesheet" type="text/css" href="{{asset('template/plugins/pikaday/pikaday.css')}}">
@endpush
@push('scripts')
<script src="{{asset('template/plugins/moment/moment.min.js')}}"></script>
<script src="{{asset('template/plugins/select2/js/select2.full.min.js')}}"></script>
<script src="{{asset('template/plugins/pikaday/pikaday.js')}}"></script>
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
          $(document).on('change', '#religionId', function (e) {
              @this.set('religion', e.target.value);
           });
          $(document).on('change', '#datepicker', function (e) {
              @this.set('join', e.target.value);
           });
          $(document).on('change', '#birthdate', function (e) {
              @this.set('birthdate', e.target.value);
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
<script>
    var picker = new Pikaday({
        field: document.getElementById('datepicker'),
        format: 'DD/MM/YYYY',
		yearRange: [2000, 3000],
        onSelect: function() {
            console.log(this.getMoment().format('Do MMMM YYYY'));
        }
    });
	
    var picker = new Pikaday({
        field: document.getElementById('birthdate'),
        format: 'DD/MM/YYYY',
		yearRange: [1968, 3000],
        onSelect: function() {
            console.log(this.getMoment().format('Do MMMM YYYY'));
        }
    });	
</script>
<script>
    $('#departmentId').change(function(){
		$.get('departments/' + this.value + '/positions.json', function(positions){
			var $subcategory = $('#positionId');
			$subcategory.find('option').remove().end();
			$("#positionId").append('<option>Pilih Jabatan</option>');
			$.each(positions, function(index, position) {
				$subcategory.append($('<option/>').attr('value', position.id).text(position.name)); 
			});
		});
    });
	$(document).ready(function() {
		$(".department option[value='0']").attr("disabled","disabled");
		$(".position option[value='0']").attr("disabled","disabled");
	});
</script>
@endpush