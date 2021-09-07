<!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
<div class="modal fade bs-modal-lg" id="gensetdowntime" tabindex="-1" role="gensetdowntime" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<form method="POST" role="form" id="gensetform" action="/genset">
				@csrf

			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title">Input Genset Utilization</h4>
			</div>

			<div class="modal-body">							 
				 	
			 	<div class="form-group" style="height:320px">	
			 		
			 		<label class="control-label col-md-3">Unit <span style="color: red;">*</span></label>
			 		<div class="col-md-9 margin-bottom-10">
			 			<select class="form-control" name="unit_id" id="unit" onchange="checkinput();" required="required">
			 			<option value="" selected="selected" disabled> - Select Unit - </option>
			 				@foreach($units as $unit )
	                        	@if( $unit->type == 'GENSET UNITS AND GENSET BREAKERS' )
		                            <option value="{{$unit->id}}"> {{ $unit->name }} </option>
		                        @endif
	                        @endforeach  	
			 			</select>
			 		</div>	

					<label class="control-label col-md-3">Start <span style="color: red;">*</span></label>
					<div class="col-md-9 margin-bottom-10">
						<div class="input-group date form_datetime">
							<input type="text" size="16" name="start_date" id="startd" readonly class="form-control" onchange="checkinput();" required="required">
							<span class="input-group-btn">
							<button class="btn default date-set" type="button"><i class="fa fa-calendar"></i></button>
							</span>
						</div>									
					</div>
					
					<label class="control-label col-md-3">End <span style="color: red;">*</span></label>
					<div class="col-md-9 margin-bottom-10">
						<div class="input-group date form_datetime">
							<input type="text" size="16" name="end_date" id="endd" readonly class="form-control" onchange="checkinput();">
							<span class="input-group-btn">
							<button class="btn default date-set" type="button"><i class="fa fa-calendar"></i></button>
							</span>
						</div>									
					</div>

					<div class="row">
						<label class="control-label col-md-3">Fuel Consumption (liters): <span style="color: red;">*</span></label>
				 		<div class="col-md-9 margin-bottom-10">
				 			<input type="number" class="form-control" step="0.01" value="0.00" name="fuel" id="fuel">
				 		</div>
			 		</div>
					
					<div class="row">
				 		<label class="control-label col-md-3">KWH Delivered: <span style="color: red;">*</span></label>
				 		<div class="col-md-9 margin-bottom-10">
				 			<input type="number" class="form-control" value="0.00" step="0.01" name="kwh" id="kwh">
				 		</div>
					</div>

					<div class="row">
						<label class="control-label col-md-3">Remarks: <span style="color: red;">*</span></label>
						<div class="col-md-9 margin-bottom-10">
							<textarea cols="53" rows="5" name="remarks" required="required"></textarea>								
						</div>
					</div>

					<h3>Run Hours Reading</h3>
					<div class="row">
				 		<label class="control-label col-md-3">Start: <span style="color: red;">*</span></label>
				 		<div class="col-md-9 margin-bottom-10">
				 			<input type="number" class="form-control" value="0.00" step="0.01" onchange="compute_hours()" name="run_start" id="startreading">
				 		</div>
					</div>

					<div class="row">
				 		<label class="control-label col-md-3">Stop: <span style="color: red;">*</span></label>
				 		<div class="col-md-9 margin-bottom-10">
				 			<input type="number" class="form-control" value="0.00" step="0.01" onchange="compute_hours()" name="run_stop" id="stopreading">
				 		</div>
					</div>

					<div class="row">
				 		<label class="control-label col-md-3">Total:</label>
				 		<div class="col-md-9 margin-bottom-10">
				 			<input type="number" class="form-control" value="0.00" step="0.01" id="totalrunhours" readonly="readonly">
				 		</div>
					</div>
				
				</div>							

			</div>
				
			<div class="modal-footer" id="footermode">
				<button type="button" class="btn default" data-dismiss="modal">Cancel</button>
				<input type="submit" class="btn blue" value="Save">
			</div>
			
			</form>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->

</div>

<!-- /.modal -->