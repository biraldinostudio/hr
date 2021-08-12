
<?php
if ($employees->position) {
    if ($employees->position->department_id == 0) {
        $empDeptID = $employees->position->department_id;
    } else {
        $empDeptID = $employees->position->department_id;
    }
} else {
    $empDeptID = 0;
}
?>
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
              <li class="breadcrumb-item active">Data Karyawan</li>
            </ol>
          </div>
        </div>
      </div>
    </section>

    <section class="content">
      <div class="container-fluid">
        <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Data Karyawan {{$department}} {{$position}}</h3>
          </div>
			<form wire:submit.prevent="update" name="crtForm">
          <div class="card-body">
		  
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
					<input wire:model="nrp" type="text" class="form-control" placeholder="NRP ..." maxlength="7">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
					<input wire:model="name" type="text" value="{{old('name')}}" class="form-control" placeholder="Nama lengkap ..." maxlength="43">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                    </div>
                    <input wire:model="join" type="text" id="datepicker" class="form-control" placeholder="Tanggal bergabung ...">
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div wire:ignore class="form-group">
					<select wire:model="department" id="departmentId" class="select2 form-control" style="width: 100%;">
						<option value="" @if (old('department','department')=='' or old('department','department')==0) selected="selected" @endif > Pilih Departemen </option>
						@foreach ($departments as $cat)
							<option value="{{ $cat->id}}" @if (old('department','department')==$cat->id)selected="selected" @endif> {{ $cat->name }} </option>
						@endforeach
					</select>	
                </div>
              </div>
              <div class="col-md-4">
                <div wire:ignore class="form-group">
					<select wire:model="position" id="positionId" class="select2 position form-control" style="width: 100%;">
						<option value="" @if (old('position','position')=='' or old('position','position')==0) selected="selected" @endif> Pilih Jabatan </option>
						@if(old('department',$empDeptID))
							@foreach ($positions as $c)
								@if(old('department',$empDeptID)==$c->department_id)
									<option value="{{ $c->id}}"
										@if($c->id==old('position','position'))      
											selected="selected"
										@endif >
										{{ $c->name }}
									</option>
								@endif
							@endforeach
						@endif
					</select>					
                </div>
              </div>
              <div class="col-md-4">
                <div wire:ignore class="form-group">
					<select wire:model="site" id="siteId" class="form-control" style="width: 100%;">
						<option value="" selected="selected">Pilih Site</option>
						@foreach($sites as $item)
							<option value="{{$item->id}}">{{$item->name}}</option>
						@endforeach
					</select>	
                </div>
              </div>
              <div class="col-md-4">
                <div wire:ignore class="form-group">
					<select wire:model="poh" id="pohId" class="select2 form-control" style="width: 100%;">
						<option value="" @if (old('poh','poh')=='' or old('poh','poh')==0)selected="selected"@endif> Pilih POH </option>
						@foreach ($pohs as $item)
							<option value="{{ $item->id}}"@if (old('poh','poh')==$item->id)selected="selected" @endif> {{ $item->name }} </option>
						@endforeach
					</select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
					<input wire:model="ktp" type="text" class="form-control" placeholder="Nomor KTP ..." maxlength="16">
                </div>
              </div>
              <div class="col-md-4">
                <div wire:ignore class="form-group">
					<select wire:model="staff" class="form-control">
						<option value="" data-type=""@if (request('staff')=='' or request('staff')=='')selected="selected" @endif>Pilih Status</option>
						<option value="1" @if (old('staff') == '1') selected="selected" @endif>Staff</option>
						<option value="0" @if (old('staff') == '0') selected="selected" @endif>Non Staff</option>
					</select>	
                </div>
              </div>
            </div>
		<h4>Lain-lain</h4>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
					<input wire:model="address" type="text" class="form-control" placeholder="Alamat ..." maxlength="100">
                </div>
              </div>
              <div class="col-md-4">
                <div wire:ignore class="form-group">
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
              <div class="col-md-4">
                <div class="form-group">
					<input wire:model="blood" type="text" class="form-control" placeholder="Golongan Darah ..." maxlength="6">	
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
					<input wire:model="birthplace" type="text" id="birthplace" class="form-control" placeholder="Tempat lahir ..." maxlength="39">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                    </div>
                    <input wire:model="birthdate" type="text" id="birthdate" class="form-control" placeholder="Tanggal lahir ...">
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
					<input wire:model="phone" type="text" class="form-control" placeholder="Nomor HP ..." maxlength="13">	
                </div>
              </div>			  
              <div class="col-md-4">
                <div class="form-group">
					 <input wire:model="lumpsum" type="text" class="form-control" type-currency="IDR" placeholder="Rp Lumpsum" maxlength="13">
                </div>
              </div>
              <div class="col-md-4">
                  <div class="form-check">
					<select wire:model="homeFacilities" class="form-control">
						<option value="" data-type=""@if (request('homeFacilities')=='' or request('homeFacilities')=='')selected="selected" @endif>Fasilitas Perumahan</option>
						<option value="1" @if (old('homeFacilities') == '1') selected="selected" @endif>Ada Fasilitas Perumahan</option>
						<option value="0" @if (old('homeFacilities') == '0') selected="selected" @endif>Tidak Ada Fasilitas Perumahan</option>
					</select>
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
			<div class="row">
				<div>
					<a href="{{route('employee')}}" type="button" class="btn btn-default" data-dismiss="modal">Tutup</a>
				</div>
				<div>&nbsp;&nbsp;&nbsp;</div>
				<div>
					<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan Data</button>			
				</div>
			</div>
          </div>
		</form>
        </div>
        </div>
    </section>
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
<script>
    var picker = new Pikaday({
        field: document.getElementById('datepicker'),
        format: 'DD/MM/YYYY',
		yearRange: [2000, 3000],
        onSelect: function() {
            console.log(this.getMoment().format('DD/MM/YYYY'));
        }
    });
	
    var picker = new Pikaday({
        field: document.getElementById('birthdate'),
        format: 'DD/MM/YYYY',
		yearRange: [1968, 3000],
        onSelect: function() {
            console.log(this.getMoment().format('DD/MM/YYYY'));
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
