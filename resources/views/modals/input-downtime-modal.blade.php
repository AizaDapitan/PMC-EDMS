<!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
<div class="modal fade bs-modal-lg" id="inputdowntime" tabindex="-1" role="inputdowntime" aria-hidden="true">
	
	<div class="modal-dialog">
		
		<div class="modal-content">
			
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
					<h4 class="modal-title">Input Downtime Details</h4>
				</div>
			
				<div class="modal-body">							 
					 
					<form method="POST" id="downtimeform" action="/downtime" class="form-horizontal">
						@csrf

					 	<div class="form-group">	
					 		
					 		<label class="control-label col-md-3" style="text-align:left !important;">Unit 
					 			<span style="color: red;">*</span>
					 		</label>
					 		
					 		<div class="col-md-9">
					 			<select class="form-control" name="unit" id="unit" onchange="checkinput();" required="required">
					 				<option value="" disabled selected> - Select Unit - </option>		
					 				@foreach( $units as $unit )
					 					<option value="{{ $unit->id }}"> {{ $unit->name }} </option>
					 				@endforeach			 				
					 			</select>
					 		</div>	
					 	
					 	</div>

					 	<div class="form-group">

							<label class="control-label col-md-3" style="text-align:left !important;">Start 
								<span style="color: red;">*</span>
							</label>

							<div class="col-md-9">
								<div class="input-group date form_datetime">
									<input type="text" size="16" name="startd" id="startd" readonly class="form-control" 
										onchange="checkinput();" required="required">
									<span class="input-group-btn">
									<button class="btn default date-set" type="button"><i class="fa fa-calendar"></i></button>
									</span>
								</div>									
							</div>

						</div>

						<div class="form-group">

							<label class="control-label col-md-3" style="text-align:left !important;">
								End 
								<span style="color: red;">*</span>
							</label>
							<div class="col-md-9">
								<div class="input-group date form_datetime">
									<input type="text" size="16" name="endd" id="endd" readonly class="form-control" 
										onchange="checkinput();" required>
									<span class="input-group-btn">
									<button class="btn default date-set" type="button"><i class="fa fa-calendar"></i></button>
									</span>
								</div>									
							</div>

						</div>


						<div class="form-group">

							<label class="control-label col-md-3" style="text-align:left !important;">
								Remarks: 
								<span style="color: red;">*</span>
							</label>

							<div class="col-md-9">
								<textarea rows="5" name="remarks" required="required" class="form-control"></textarea>		
							</div>

						</div>

						<div class="form-group" style="margin-top: 10px;">

							<label class="control-label col-md-3" style="text-align:left !important;">
								Type:
								<span style="color: red;">*</span>
							</label>
					 		
					 		<div class="col-md-9">
					 			<select class="form-control" name="isscheduled" id="isscheduled" required="required">							
					 				<option value="1">Scheduled</option>
					 				<option value="0">Unscheduled</option>
					 				<option value="2">Grid Outage</option>
					 			</select>
					 		</div>		

					 	</div>
		 	
				 		<div class="pull-right">

						 	<button type="button" class="btn default" data-dismiss="modal">Cancel</button>
							<input type="submit" class="btn blue" value="Save">

						</div>

					</form>
					
					<div style="clear: both;"></div>

				</div>
				
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->

</div>