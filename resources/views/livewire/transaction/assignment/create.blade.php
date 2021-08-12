<div wire:ignore.self class="modal fade" id="modal_create_assignment" role="dialog" aria-labelledby="myModalLabe137" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Pengajuan Tugas/Training</h4>
          <button wire:click="cancel" onclick="clearSelect2()" type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
       
        <div class="modal-body">
		

		 <form wire:submit.prevent="store" name="crtForm">
		 @csrf
			@if($latestAssignmentOpen>0)
				Maaf Anda sudah melakukan pengajuan izin dengan nomor <strong>{{$latestAssignmentOpenNumber}}</strong> Silahkan cek pengajuan izin tersebut.
			<br><br>Jika pengajuan izin tersebut tidak dilanjutkan, silahkan non aktifkan. Dengan cara non aktifkan melalui menu Edit <i class="fa fa-edit"></i>.
		    
			<br><br><p><strong>Terima kasih</strong>.</p>
        <div class="modal-footer justify-content-between">
			<button wire:click="cancel" onclick="clearSelect2()" type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
        </div>	
		@else		
				<div class="row">	
                  <div class="col-sm-12">
				  <label>Lokasi Tugas/Training:</label>
                    <div class="form-group clearfix">
                      <div class="icheck-primary d-inline">
                        <input wire:model="location" name="location" type="radio" id="radioPrimary1" value="inSite">
                        <label for="radioPrimary1">
							In Site
                        </label>
                      </div>&nbsp;&nbsp;&nbsp;&nbsp;
                      <div class="icheck-primary d-inline">
                        <input wire:model="location" name="location" type="radio" id="radioPrimary2" value="inRegional">
                        <label for="radioPrimary2">
						Regional
                        </label>
							
                      </div>&nbsp;&nbsp;&nbsp;&nbsp;
                      <div class="icheck-primary d-inline">
                        <input wire:model="location" name="location" type="radio" id="radioPrimary3" value="outRegional">
                        <label for="radioPrimary3">
                          Luar Regional
                        </label>
                      </div>
                    </div>
                  </div>				
				</div>
				
					<div wire:ignore class="row inSite box" style="display:none;">					
						<div class="col-sm-6">
							<div class="form-group">							
							<label>Tgl Mulai:</label>
							  <div class="input-group date" data-provide="datepicker">
								<div class="input-group-prepend">
								  <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
								</div>
								<input wire:model="startDateInSite" type="text" id="startDateInSiteId" class="form-control" onchange='Livewire.emit("selectStartDateInSite", this.value)' placeholder="Tanggal mulai ..." autocomplete="off">
							  </div>
							</div>
						</div>
						<div class="col-sm-6">
							<div  class="form-group">
							<label>Tgl Selesai:</label>					
							  <div class="input-group date" data-provide="datepicker">
								<div class="input-group-prepend">
								  <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
								</div>
								<input wire:model="endDateInSite" type="text" id="endDateInSiteId" class="form-control" onchange='Livewire.emit("selectEndDateInSite", this.value)' placeholder="Tanggal selesai ..." autocomplete="off">
							  </div>
							</div>
						</div>					
					  </div>
			
				<div wire:ignore class="row inSite box" style="display:none;">
				  <div class="col-12 col-sm-12">
					<div class="form-group">
					<label>Keperluan</label>
						<textarea wire:model="descriptionInSite" type="text" id="descriptionInSiteId" class="form-control" placeholder="Keperluan tugas/training..."></textarea>
					</div>
				  </div>
				</div>


			<div wire:ignore class="card card-default inSite box" style="display:none;">
				<div class="card-header">
					<h3 class="card-title">Akomodasi</h3>
				</div>
				  <div class="card-body">
					  <div class="row">
						<div class="col-sm-4">
							<div class="form-group">
								<label>Jml Hari Makan:</label>	
								<input wire:model="mealInSiteDay" class="form-control" type="text" placeholder="Jml hari makan..." maxlength="2">
							</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group">
							<label>(Rp)Perhari Makan:</label>
								<input wire:model="mealInSiteCost" type="text" class="form-control" type-currency="IDR" placeholder="Rp Biaya makan ..." maxlength="13">
							</div>
						</div>		
					  </div>
					  <div class="row">
						<div class="col-sm-4">
							<div class="form-group">
								<label>Jml Hari Lain2:</label>	
								<input wire:model="otherInSiteDay" class="form-control" type="text" placeholder="Jml hari lain2..." maxlength="2">
							</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group">
							<label>(Rp)Perhari Lain:</label>
								<input wire:model="otherInSiteCost" type="text" class="form-control" type-currency="IDR" placeholder="Rp Biaya lain2 ..." maxlength="13">
							</div>
						</div>		
					  </div>					  
				  </div>
            </div>					
					  
				
				
	<!--BAGIAN IN REGIONAL-->
					<div wire:ignore class="row inRegional box" style="display:none;">					
						<div class="col-sm-6">
							<div class="form-group">							
							<label>Tgl Mulai:</label>
							  <div class="input-group date" data-provide="datepicker">
								<div class="input-group-prepend">
								  <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
								</div>
								<input wire:model="startDateInReg" type="text" id="startDateInRegId" class="form-control" onchange='Livewire.emit("selectStartDateInReg", this.value)' placeholder="Tanggal mulai ..." autocomplete="off">
							  </div>
							</div>
						</div>
						<div class="col-sm-6">
							<div  class="form-group">
							<label>Tgl Selesai:</label>					
							  <div class="input-group date" data-provide="datepicker">
								<div class="input-group-prepend">
								  <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
								</div>
								<input wire:model="endDateInReg" type="text" id="endDateInRegId" class="form-control" onchange='Livewire.emit("selectEndDateInReg", this.value)' placeholder="Tanggal selesai ..." autocomplete="off">
							  </div>
							</div>
						</div>					
					  </div>
			
				<div wire:ignore class="row inRegional box" style="display:none;">
				  <div class="col-12 col-sm-12">
					<div class="form-group">
					<label>Keperluan</label>
						<textarea wire:model="descriptionInReg" type="text" id="descriptionInRegId" class="form-control" placeholder="Keperluan tugas/training..."></textarea>
					</div>
				  </div>
				</div>	
	
			<div wire:ignore class="card card-default inRegional box" style="display:none;">
				<div class="card-header">
					<h3 class="card-title">Rute Travel Berangkat</h3>
				</div>
				  <div class="card-body">
					  <div class="row">
						<div class="col-sm-4">
							<div class="form-group">
								<select wire:model="travelDestiInRegFromGo" id="travelDestiInRegFromGoId" class="select2 form-control" onchange='Livewire.emit("selectTravelDestiInRegFromGo", this.value)' placeholder="Dari">
									<option value="" selected="selected">Pilih Keberangkatan</option>
									@foreach($destinations as $item)
										<option value="{{$item->id}}">{{$item->name}}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="col-sm-4">
							<div wire:ignore class="form-group">
								<select wire:model="travelDestiInRegToGo" id="travelDestiInRegToGoId" class="select2 form-control" onchange='Livewire.emit("selectTravelDestiInRegToGo", this.value)' placeholder="Tujuan">
									<option value="" selected="selected">Pilih Tujuan</option>
									@foreach($destinations as $item)
										<option value="{{$item->id}}">{{$item->name}}</option>
									@endforeach
								</select>
							</div>
						</div>					  
						<div class="col-sm-4">
							<div  class="form-group">
							  <div class="input-group date" data-provide="datepicker">
								<div class="input-group-prepend">
								  <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
								</div>
								<input wire:model="travelDateInRegFromGo" type="text" id="travelDateInRegFromGoId" class="form-control" onchange='Livewire.emit("selectTravelDateInRegFromGo", this.value)' placeholder="Tanggal berangkat ..." autocomplete="off" disabled="disabled">
							  </div>
							</div>
						</div>					
					  </div>
				  </div>
            </div>				
			
			<div wire:ignore class="card card-default inRegional box" style="display:none;">
				<div class="card-header">
					<h3 class="card-title">Rute Travel Kembali</h3>
				</div>
				  <div class="card-body">
					  <div class="row">
						<div class="col-sm-4">
							<div class="form-group">
								<select wire:model="travelDestiInRegFromBack" id="travelDestiInRegFromBackId" class="select2 form-control" onchange='Livewire.emit("selectTravelDestiInRegFromBack", this.value)' placeholder="Dari">
									<option value="" selected="selected">Pilih Keberangkatan</option>
									@foreach($destinations as $item)
										<option value="{{$item->id}}">{{$item->name}}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group">
								<select wire:model="travelDestiInRegToBack" id="travelDestiInRegToBackId" class="select2 form-control" onchange='Livewire.emit("selectTravelDestiInRegToBack", this.value)' placeholder="Tujuan">
									<option value="" selected="selected">Pilih Tujuan</option>
									@foreach($destinations as $item)
										<option value="{{$item->id}}">{{$item->name}}</option>
									@endforeach
								</select>
							</div>
						</div>					  
						<div class="col-sm-4">
							<div  class="form-group">
							  <div class="input-group date" data-provide="datepicker">
								<div class="input-group-prepend">
								  <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
								</div>
								<input wire:model="travelDateInRegFromBack" type="text" id="travelDateInRegFromBackId" class="form-control" onchange='Livewire.emit("selectTravelDateInRegFromBack", this.value)' placeholder="Tanggal kembali ..." autocomplete="off" disabled="disabled">
							  </div>
							</div>
						</div>					
					  </div>
				  </div>
            </div>
			<div wire:ignore class="card card-default inRegional box" style="display:none;">
				<div class="card-header">
					<h3 class="card-title">Akomodasi</h3>
				</div>
				  <div class="card-body">
					  <div class="row">
						<div class="col-sm-4">
							<div class="form-group">
								<label>Jml Hari Penginapan:</label>	
								<input wire:model="lodgingInRegDay" class="form-control" type="text" placeholder="Jml hari penginapan..." maxlength="2">
							</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group">
							<label>(Rp)Perhari Penginapan:</label>
								<input wire:model="lodgingInRegCost" type="text" class="form-control" type-currency="IDR" placeholder="Rp Biaya penginapan ..." maxlength="13">
							</div>
						</div>		
					  </div>
					  <div class="row">
						<div class="col-sm-4">
							<div class="form-group">
								<label>Jml Hari Transportasi:</label>	
								<input wire:model="transportInRegDay" class="form-control" type="text" placeholder="Jml hari transportasi..." maxlength="2">
							</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group">
							<label>(Rp)Perhari Transportasi:</label>
								<input wire:model="transportInRegCost" type="text" class="form-control" type-currency="IDR" placeholder="Rp Biaya transportasi ..." maxlength="13">
							</div>
						</div>		
					  </div>
					  <div class="row">
						<div class="col-sm-4">
							<div class="form-group">
								<label>Jml Hari Makan:</label>	
								<input wire:model="mealInRegDay" class="form-control" type="text" placeholder="Jml hari makan..." maxlength="2">
							</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group">
							<label>(Rp)Perhari Makan:</label>
								<input wire:model="mealInRegCost" type="text" class="form-control" type-currency="IDR" placeholder="Rp Biaya makan ..." maxlength="13">
							</div>
						</div>		
					  </div>
					  <div class="row">
						<div class="col-sm-4">
							<div class="form-group">
								<label>Jml Hari Lain2:</label>	
								<input wire:model="otherInRegDay" class="form-control" type="text" placeholder="Jml hari lain2..." maxlength="2">
							</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group">
							<label>(Rp)Perhari Lain:</label>
								<input wire:model="otherInRegCost" type="text" class="form-control" type-currency="IDR" placeholder="Rp Biaya lain2 ..." maxlength="13">
							</div>
						</div>		
					  </div>					  
				  </div>
            </div>	
			
				
			<!--BAGIAN OUT REGIONAL-->
					<div wire:ignore class="row outRegional box" style="display:none;">					
						<div class="col-sm-6">
							<div class="form-group">							
							<label>Tgl Mulai:</label>
							  <div class="input-group date" data-provide="datepicker">
								<div class="input-group-prepend">
								  <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
								</div>
								<input wire:model="startDateOutReg" type="text" id="startDateOutRegId" class="form-control" onchange='Livewire.emit("selectStartDateOutReg", this.value)' placeholder="Tanggal mulai ..." autocomplete="off">
							  </div>
							</div>
						</div>
						<div class="col-sm-6">
							<div  class="form-group">
							<label>Tgl Selesai:</label>					
							  <div class="input-group date" data-provide="datepicker">
								<div class="input-group-prepend">
								  <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
								</div>
								<input wire:model="endDateOutReg" type="text" id="endDateOutRegId" class="form-control" onchange='Livewire.emit("selectEndDateOutReg", this.value)' placeholder="Tanggal selesai ..." autocomplete="off">
							  </div>
							</div>
						</div>					
					  </div>
			
				<div wire:ignore class="row outRegional box" style="display:none;">
				  <div class="col-12 col-sm-12">
					<div class="form-group">
					<label>Keperluan</label>
						<textarea wire:model="descriptionOutReg" type="text" id="descriptionOutRegId" class="form-control" placeholder="Keperluan tugas/training..."></textarea>
					</div>
				  </div>
				</div>					
				
				
				
			<div wire:ignore class="card card-default outRegional box" style="display:none;">
				<div class="card-header">
					<h3 class="card-title">Rute Tiket Keberangkatan</h3>
				</div>
				  <div class="card-body">
					  <div class="row">
						<div class="col-sm-6">
							<div wire:ignore class="form-group">
								<select wire:model="ticketDestiOutRegFromGo" id="ticketDestiOutRegFromGoId" class="select2 form-control" onchange='Livewire.emit("selectTicketDestiOutRegFromGo", this.value)' placeholder="Dari">
									<option value="" selected="selected">Pilih Keberangkatan</option>
									@foreach($destinations as $item)
										<option value="{{$item->id}}">{{$item->name}}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="col-sm-6">
							<div  wire:ignore class="form-group">
								<select wire:model="ticketDestiOutRegToGo" id="ticketDestiOutRegToGoId" class="select2 form-control" onchange='Livewire.emit("selectTicketDestiOutRegToGo", this.value)' placeholder="Tujuan">
									<option value="" selected="selected">Pilih Tujuan</option>
									@foreach($destinations as $item)
										<option value="{{$item->id}}">{{$item->name}}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<div class="input-group date" data-provide="datepicker">
									<div class="input-group-prepend">
									  <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
									</div>																
									<input wire:model="ticketDateOutRegFromGo" type="text" id="ticketDateOutRegFromGoId" class="form-control" onchange='Livewire.emit("selectTicketDateOutRegFromGo", this.value)' placeholder="Tanggal berangkat ..." autocomplete="off" disabled="disabled">
								</div>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="bootstrap-timepicker">
								<div class="form-group">								
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text"><i class="far fa-clock"></i></span>
										</div>										
										<input wire:model="ticketTimeOutRegGo" type="text" class="form-control time" onchange='Livewire.emit("selectTicketTimeOutRegGo", this.value)' placeholder="Jam berangkat ..." autocomplete="off">

									</div>
								</div>
							</div>
						</div>							
					  </div>
				  </div>
            </div>
			
			<div wire:ignore class="card card-default outRegional box" style="display:none;">
				<div class="card-header">
					<h3 class="card-title">Rute Tiket Kembali</h3>
				</div>
				  <div class="card-body">
					  <div class="row">
						<div class="col-sm-6">
							<div wire:ignore class="form-group">
								<select wire:model="ticketDestiOutRegFromBack" id="ticketDestiOutRegFromBackId" class="select2 form-control" onchange='Livewire.emit("selectTicketDestiOutRegFromBack", this.value)' placeholder="Dari">
									<option value="" selected="selected">Pilih Keberangkatan</option>
									@foreach($destinations as $item)
										<option value="{{$item->id}}">{{$item->name}}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="col-sm-6">
							<div  wire:ignore class="form-group">
								<select wire:model="ticketDestiOutRegToBack" id="ticketDestiOutRegToBackId" class="select2 form-control" onchange='Livewire.emit("selectTicketDestiOutRegToBack", this.value)' placeholder="Tujuan">
									<option value="" selected="selected">Pilih Tujuan</option>
									@foreach($destinations as $item)
										<option value="{{$item->id}}">{{$item->name}}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								  <div class="input-group date" data-provide="datepicker">
									<div class="input-group-prepend">
									  <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
									</div>
									<input wire:model="ticketDateOutRegFromBack" type="text" id="ticketDateOutRegFromBackId" class="form-control" onchange='Livewire.emit("selectTicketDateOutRegFromBack", this.value)' placeholder="Tanggal kembali ..." autocomplete="off" disabled="disabled">
								  </div>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text"><i class="far fa-clock"></i></span>
										</div>										
										<input wire:model="ticketTimeOutRegBack" type="text" class="form-control time" onchange='Livewire.emit("selectTicketTimeOutRegBack", this.value)' placeholder="Jam kembali ..." autocomplete="off">

									</div>
							</div>
						</div>							
					  </div>
				  </div>
            </div>				
				
			<div wire:ignore class="card card-default outRegional box" style="display:none;">
				<div class="card-header">
					<h3 class="card-title">Rute Travel Berangkat</h3>
				</div>
				  <div class="card-body">
					  <div class="row">
						<div class="col-sm-4">
							<div wire:ignore class="form-group">
								<select wire:model="travelDestiOutRegFromGo" id="travelDestiOutRegFromGoId" class="select2 form-control" onchange='Livewire.emit("selecttravelDestiOutRegFromGo", this.value)' placeholder="Dari">
									<option value="" selected="selected">Pilih Keberangkatan</option>
									@foreach($destinations as $item)
										<option value="{{$item->id}}">{{$item->name}}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="col-sm-4">
							<div  wire:ignore class="form-group">
								<select wire:model="travelDestiOutRegToGo" id="travelDestiOutRegToGoId" class="select2 form-control" onchange='Livewire.emit("selecttravelDestiOutRegToGo", this.value)' placeholder="Tujuan">
									<option value="" selected="selected">Pilih Tujuan</option>
									@foreach($destinations as $item)
										<option value="{{$item->id}}">{{$item->name}}</option>
									@endforeach
								</select>
							</div>
						</div>					  
						<div class="col-sm-4">
							<div  class="form-group">
							  <div class="input-group date" data-provide="datepicker">
								<div class="input-group-prepend">
								  <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
								</div>
								<input wire:model="travelDateOutRegFromGo" type="text" id="travelDateOutRegFromGoId" class="form-control" onchange='Livewire.emit("selectTravelDateOutRegFromGo", this.value)' placeholder="Tanggal berangkat ..." autocomplete="off" disabled="disabled">
							  </div>
							</div>
						</div>					
					  </div>
				  </div>
            </div>				
			
			<div wire:ignore class="card card-default outRegional box" style="display:none;">
				<div class="card-header">
					<h3 class="card-title">Rute Travel Kembali</h3>
				</div>
				  <div class="card-body">
					  <div class="row">
						<div class="col-sm-4">
							<div wire:ignore class="form-group">
								<select wire:model="travelDestiOutRegFromBack" id="travelDestiOutRegFromBackId" class="select2 form-control" onchange='Livewire.emit("selectTravelDestiOutRegFromBack", this.value)' placeholder="Dari">
									<option value="" selected="selected">Pilih Keberangkatan</option>
									@foreach($destinations as $item)
										<option value="{{$item->id}}">{{$item->name}}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="col-sm-4">
							<div  wire:ignore class="form-group">
								<select wire:model="travelDestiOutRegToBack" id="travelDestiOutRegToBackId" class="select2 form-control" onchange='Livewire.emit("selectTravelDestiOutRegToBack", this.value)' placeholder="Tujuan">
									<option value="" selected="selected">Pilih Tujuan</option>
									@foreach($destinations as $item)
										<option value="{{$item->id}}">{{$item->name}}</option>
									@endforeach
								</select>
							</div>
						</div>					  
						<div class="col-sm-4">
							<div  class="form-group">
							  <div class="input-group date" data-provide="datepicker">
								<div class="input-group-prepend">
								  <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
								</div>
								<input wire:model="travelDateOutRegFromBack" type="text" id="travelDateOutRegFromBackId" class="form-control" onchange='Livewire.emit("selectTravelDateOutRegFromBack", this.value)' placeholder="Tanggal kembali ..." autocomplete="off" disabled="disabled">
							  </div>
							</div>
						</div>					
					  </div>
				  </div>
            </div>
			
			<div wire:ignore class="card card-default outRegional box" style="display:none;">
				<div class="card-header">
					<h3 class="card-title">Akomodasi</h3>
				</div>
				  <div class="card-body">
					  <div class="row">
						<div class="col-sm-4">
							<div class="form-group">
								<label>Jml Hari Penginapan:</label>	
								<input wire:model="lodgingOutRegDay" class="form-control" type="text" placeholder="Jml hari penginapan..." maxlength="2">
							</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group">
							<label>(Rp)Perhari Penginapan:</label>
								<input wire:model="lodgingOutRegCost" type="text" class="form-control" type-currency="IDR" placeholder="Rp Biaya penginapan ..." maxlength="13">
							</div>
						</div>		
					  </div>
					  <div class="row">
						<div class="col-sm-4">
							<div class="form-group">
								<label>Jml Hari Transportasi:</label>	
								<input wire:model="transportOutRegDay" class="form-control" type="text" placeholder="Jml hari transportasi..." maxlength="2">
							</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group">
							<label>(Rp)Perhari Transportasi:</label>
								<input wire:model="transportOutRegCost" type="text" class="form-control" type-currency="IDR" placeholder="Rp Biaya transportasi ..." maxlength="13">
							</div>
						</div>		
					  </div>
					  <div class="row">
						<div class="col-sm-4">
							<div class="form-group">
								<label>Jml Hari Makan:</label>	
								<input wire:model="mealOutRegDay" class="form-control" type="text" placeholder="Jml hari makan..." maxlength="2">
							</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group">
							<label>(Rp)Perhari Makan:</label>
								<input wire:model="mealOutRegCost" type="text" class="form-control" type-currency="IDR" placeholder="Rp Biaya makan ..." maxlength="13">
							</div>
						</div>		
					  </div>
					  <div class="row">
						<div class="col-sm-4">
							<div class="form-group">
								<label>Jml Hari Lain2:</label>	
								<input wire:model="otherOutRegDay" class="form-control" type="text" placeholder="Jml hari lain2..." maxlength="2">
							</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group">
							<label>(Rp)Perhari Lain:</label>
								<input wire:model="otherOutRegCost" type="text" class="form-control" type-currency="IDR" placeholder="Rp Biaya lain2 ..." maxlength="13">
							</div>
						</div>		
					  </div>					  
				  </div>
            </div>			
			{{--	<div class="row">
						<div class="col-sm-6">
							<div  class="form-group">
							<label>Tanggal On Site</label>
							  <div class="input-group date" data-provide="datepicker">
								<div class="input-group-prepend">
								  <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
								</div>
								<input wire:model="inDate" type="text" id="inDateId" class="form-control" onchange='Livewire.emit("selectInDate", this.value)' placeholder="Masuk bekerja ..." autocomplete="off" disabled="disabled">
							  </div>
							</div>
						</div>						
			</div>	--}}		
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
			@if($location=='inSite')
				<button type="submit" class="btn btn-primary"><i class="fa fa-tasks"></i> Ajukan Tugas</button>
			@elseif($location=='inRegional')
				<button type="submit" class="btn btn-primary"><i class="fa fa-tasks"></i> Ajukan Tugas</button>
			@else
				<button type="submit" class="btn btn-primary"><i class="fa fa-tasks"></i> Ajukan Tugas</button>			
			@endif
        </div>
				
@endif
			
		</form>
      </div>
    
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
@push('styles')
  <link rel="stylesheet" type="text/css" href="{{asset('template/plugins/pikaday/pikaday.css')}}">
  <link rel="stylesheet" href="{{asset('template/plugins/select2/css/select2.min.css')}}">
  <link rel="stylesheet" href="{{asset('template/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('template/custom/single.css')}}">
	    <link rel="stylesheet" type="text/css" href="{{asset('template/plugins/timepicker/timepicker.modif.css')}}">
 <link rel="stylesheet" href="{{asset('template/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">		
@endpush
@push('scripts')
<script src="{{asset('template/plugins/moment/moment.min.js')}}"></script>
<script src="{{asset('template/plugins/pikaday/pikaday.js')}}"></script>
<script src="{{asset('template/plugins/select2/js/select2.full.min.js')}}"></script>
<script src="{{asset('template/plugins/timepicker/timepicker.modif.js')}}"></script>
<script>
  $(function () {
    $('.select2').select2()

    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })

  })
</script>
<script>
$(document).ready(function(){
    $('input[type="radio"]').click(function(){
        var inputValue = $(this).attr("value");
        var targetBox = $("." + inputValue);
        $(".box").not(targetBox).hide();
        $(targetBox).show();
    });
});
</script>
<script>
       $(document).ready(function () {
		   $(".time").timepicker();
          $(document).on('change', '#ticketDestiOutRegFromGoId', function (e) {
              @this.set('ticketDestiOutRegFromGo', e.target.value);
           });		   
          $(document).on('change', '#ticketDestiOutRegToGoId', function (e) {
              @this.set('ticketDestiOutRegToGo', e.target.value);
           });

          $(document).on('change', '#ticketDestiOutRegFromBackId', function (e) {
              @this.set('ticketDestiOutRegFromBack', e.target.value);
           });		   
          $(document).on('change', '#ticketDestiOutRegToBackId', function (e) {
              @this.set('ticketDestiOutRegToBack', e.target.value);
           });

          $(document).on('change', '#travelDestiOutRegFromGoId', function (e) {
              @this.set('travelDestiOutRegFromGo', e.target.value);
           });		   
          $(document).on('change', '#travelDestiOutRegToGoId', function (e) {
              @this.set('travelDestiOutRegToGo', e.target.value);
           });
		   
          $(document).on('change', '#travelDestiOutRegFromBackId', function (e) {
              @this.set('travelDestiOutRegFromBack', e.target.value);
           });		   
          $(document).on('change', '#travelDestiOutRegToBackId', function (e) {
              @this.set('travelDestiOutRegToBack', e.target.value);
           });
		   

          $(document).on('change', '#travelDestiInRegFromGoId', function (e) {
              @this.set('travelDestiInRegFromGo', e.target.value);
           });		   
          $(document).on('change', '#travelDestiInRegToGoId', function (e) {
              @this.set('travelDestiInRegToGo', e.target.value);
           });
		   
          $(document).on('change', '#travelDestiInRegFromBackId', function (e) {
              @this.set('travelDestiInRegFromBack', e.target.value);
           });		   
          $(document).on('change', '#travelDestiInRegToBackId', function (e) {
              @this.set('travelDestiInRegToBack', e.target.value);
           });		   
       });

       document.addEventListener('livewire:load', function (event) {
          @this.on('refreshDropdown', function () {
              $('.select2').select2();
          });  
     })
</script>
<script>
    var picker2 = new Pikaday({
        field: document.getElementById('ticketDateOutRegFromGoId'),
        format: 'DD/MM/YYYY',
    });	
	
    var picker3 = new Pikaday({
        field: document.getElementById('travelDateOutRegFromGoId'),
        format: 'DD/MM/YYYY',
    });
	
	    var picker4 = new Pikaday({
        field: document.getElementById('startDateInSiteId'),
        format: 'DD/MM/YYYY',
    });
	
	var picker5 = new Pikaday({
		field: document.getElementById('endDateInSiteId'),
		format: 'DD/MM/YYYY',
	});

    var picker4 = new Pikaday({
        field: document.getElementById('startDateInRegId'),
        format: 'DD/MM/YYYY',
    });
	
	var picker5 = new Pikaday({
		field: document.getElementById('endDateInRegId'),
		format: 'DD/MM/YYYY',
	});
	
	    var picker4 = new Pikaday({
        field: document.getElementById('startDateOutRegId'),
        format: 'DD/MM/YYYY',
    });
	
	var picker5 = new Pikaday({
		field: document.getElementById('endDateOutRegId'),
		format: 'DD/MM/YYYY',
	});

	var picker8 = new Pikaday({
        field: document.getElementById('ticketDateOutRegFromBackId'),
        format: 'DD/MM/YYYY',
    });	
	
    var picker9 = new Pikaday({
        field: document.getElementById('travelDateOutRegFromBackId'),
        format: 'DD/MM/YYYY',
    });
	
	
    var picker3 = new Pikaday({
        field: document.getElementById('travelDateInRegFromGoId'),
        format: 'DD/MM/YYYY',
    });
	
	    var picker9 = new Pikaday({
        field: document.getElementById('travelDateInRegFromBackId'),
        format: 'DD/MM/YYYY',
    });		
</script>

 <script>
function clearSelect2() {
   var frm = document.getElementsByName('crtForm')[0];
   frm.submit();
   frm.reset();
   return false;
}
</script>
@endpush