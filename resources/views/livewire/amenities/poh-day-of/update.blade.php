<div wire:ignore.self class="modal fade" id="editModal" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Ubah Data</h4>
          <button wire:click="cancel" onclick="clearSelect2()" type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
		 <form wire:submit.prevent="update">
            <div class="row">
              <div class="col-md-6">
					<label>Nama Site: </label>
					<div wire:ignore class="form-group">
						<select wire:model="site" id="siteId" class="form-control">

								@foreach ($sites as $prov)
									<option value="{{ $prov->id}}"@if (old('site','site')==$prov->id)selected="selected"@endif> {{ $prov->name }} </option>
								@endforeach
						</select>  
					</div>
              </div>
              <div class="col-md-6">
					<label>Nama POH: </label>
					<div wire:ignore class="form-group">
						<select wire:model="poh" id="pohId" class="form-control">
							<option value="" data-type=""@if (old('poh', 'poh')=='' or old('poh','poh')==0)selected="selected"@endif> Pilih poh</option>
								@foreach ($pohs as $item)
									<option value="{{ $item->id}}"@if (old('poh','poh')==$item->id)selected="selected"@endif> {{ $item->name }} </option>
								@endforeach
						</select> 
					</div>
              </div>
              <div class="col-md-6">
					<label>Hari Cuti: </label>
					<div class="form-group">
						<input wire:model="dayof" type="text" placeholder="Hari cuti ..." class="form-control">
					</div>
              </div>
              <div class="col-md-6">
				<label>Fasilitas Lumpsum: </label>
					<div wire:ignore class="form-group">
						<select wire:model="lumpsum" class="form-control">
							<option value="" @if (old('lumpsum')=='')selected="disabled"@endif> Fasilitas lumpsum</option>
							<option value="1" @if(old('lumpsum','lumpsum') == '1')selected="selected"@endif>Dapat</option>
							<option value="0" @if(old('lumpsum','lumpsum') == '0')selected="selected"@endif>Tidak</option>												
						</select>	
                </div>
              </div>			  
              <div class="col-md-4">
					<label>Hari Travel (PP): </label>
					<div class="form-group">
						<input wire:model="travel" type="text" placeholder="Hari Travel (PP) ..." class="form-control" maxlength="1">
					</div>
              </div>
              <div class="col-md-4">
					<label>Hari Ticket (PP): </label>
					<div class="form-group">
						<input wire:model="travel_ticket" type="text" placeholder="Hari Ticket (PP) ..." class="form-control" maxlength="1">
					</div>
              </div>			  
              <div class="col-md-4">
					<label>Status: </label>
					<div class="form-group">
						<select wire:model="status" class="form-control">
							<option value="" @if (old('status')=='')selected="disabled"@endif> Pilih Status</option>
							<option value="1" @if(old('status','status') == '1')selected="selected"@endif>Aktif</option>
							<option value="0" @if(old('status','status') == '0')selected="selected"@endif>Non Aktif</option>												
						</select>
					</div>
              </div>
              <div class="col-md-12">
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


        </div>
   
        <div class="modal-footer justify-content-between">
          <button wire:click="cancel" onclick="clearSelect2()" type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Ubah Data</button>
        </div></form>
      </div>
    
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>