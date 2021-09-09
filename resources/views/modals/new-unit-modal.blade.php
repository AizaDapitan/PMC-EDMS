<div class="modal fade bs-modal-lg" id="munit" tabindex="-1" role="munit" aria-hidden="true">

	<div class="modal-dialog">

		<div class="modal-content">
			
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title">Add New Unit</h4>
			</div>

			<div class="modal-body">
				
				<form method="post" action="{{ route('units') }}" class="form-horizontal">
					@csrf

				 	<div class="form-group">

						<label class="col-md-3 control-label" style="text-align:left !important;">Description <span style="color: red;">*</span></label>
						<div class="col-md-9">
							<input type="text" class="form-control" required name="name" placeholder="Enter text">			
						</div>

					</div>

					<div class="form-group">

						<label class="col-md-3 control-label" style="text-align:left !important;">Category <span style="color: red;">*</span></label>
						<div class="col-md-9">
							<select class="form-control" name="type" required>
								<option value="" disabled selected> - Select - </option>
								@foreach($units->groupBy('type') as $key => $category )
									<option value="{{$key}}"> {{ $key }} </option>
								@endforeach
							</select>							
						</div>

					</div>

					<div class="form-group">

						<label class="col-md-3 control-label" style="text-align:left !important;">
							Location <span style="color: red;">*</span>
						</label>
						<div class="col-md-9">
							<select class="form-control" name="location" required>
								<option value="" disabled selected> - Select - </option>
								@foreach($units->groupBy('location') as $key => $category )
									<option value="{{$key}}"> {{ $key }} </option>
								@endforeach							
							</select>								
						</div>

					</div>	

					<div class="pull-right">

						<button type="button" class="btn default" data-dismiss="modal">Cancel</button>
						<input type="submit" class="btn blue" value="Save">
						
					</div>
					
					<div class="clearfix"></div>

				</form>

			</div>

		</div>

	</div>
	
</div>