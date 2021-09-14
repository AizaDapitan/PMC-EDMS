@extends('layouts.app')

@section('pageCSS')

	<link href="{{env('APP_URL')}}/themes/metronic/assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
	<link href="{{env('APP_URL')}}/themes/metronic/assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css"/>
	<link href="{{env('APP_URL')}}/themes/metronic/assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
	<link href="{{env('APP_URL')}}/themes/metronic/assets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
	<link href="{{env('APP_URL')}}/themes/metronic/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css"/>
	<!-- END GLOBAL MANDATORY STYLES -->

	<!-- BEGIN PAGE LEVEL STYLES -->
	<link rel="stylesheet" type="text/css" href="{{env('APP_URL')}}/themes/metronic/assets/global/plugins/select2/select2.css"/>
	<link rel="stylesheet" type="text/css" href="{{env('APP_URL')}}/themes/metronic/assets/global/plugins/datatables/extensions/Scroller/css/dataTables.scroller.min.css"/>
	<link rel="stylesheet" type="text/css" href="{{env('APP_URL')}}/themes/metronic/assets/global/plugins/datatables/extensions/ColReorder/css/dataTables.colReorder.min.css"/>
	<link rel="stylesheet" type="text/css" href="{{env('APP_URL')}}/themes/metronic/assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css"/>
	<!-- END PAGE LEVEL STYLES -->

	<!-- BEGIN THEME STYLES -->
	<link href="{{env('APP_URL')}}/themes/metronic/assets/global/css/components.css" rel="stylesheet" type="text/css"/>
	<link href="{{env('APP_URL')}}/themes/metronic/assets/global/css/plugins.css" rel="stylesheet" type="text/css"/>
	<link href="{{env('APP_URL')}}/themes/metronic/assets/admin/layout/css/layout.css" rel="stylesheet" type="text/css"/>
	<link id="style_color" href="{{env('APP_URL')}}/themes/metronic/assets/admin/layout/css/themes/default.css" rel="stylesheet" type="text/css"/>
	<link href="{{env('APP_URL')}}/themes/metronic/assets/admin/layout/css/custom.css" rel="stylesheet" type="text/css"/>
	<!-- END PAGE LEVEL PLUGIN STYLES -->

	<!-- BEGIN PAGE STYLES -->
	<link href="{{env('APP_URL')}}/themes/metronic/assets/admin/pages/css/tasks.css" rel="stylesheet" type="text/css"/>
	<!-- END PAGE STYLES -->

	<!-- BEGIN THEME STYLES -->
	<link href="{{env('APP_URL')}}/themes/metronic/assets/global/css/components.css" rel="stylesheet" type="text/css"/>
	<link href="{{env('APP_URL')}}/themes/metronic/assets/global/css/plugins.css" rel="stylesheet" type="text/css"/>
	<link href="{{env('APP_URL')}}/themes/metronic/assets/admin/layout/css/layout.css" rel="stylesheet" type="text/css"/>
	<link id="style_color" href="{{env('APP_URL')}}/themes/metronic/assets/admin/layout/css/themes/default.css" rel="stylesheet" type="text/css"/>
	<link href="{{env('APP_URL')}}/themes/metronic/assets/admin/layout/css/custom.css" rel="stylesheet" type="text/css"/>
	<!-- END BEGIN THEME STYLES -->

@endsection


@section('content')

	<div class="row">

		<div class="col-md-12">

			<form method="GET" action="{{ route('EDMS-assets') }}">

				<h3 class="page-title"> EDMS <small>Asset Management</small> </h3>
				
				<ul class="page-breadcrumb breadcrumb">
					
					<li>							
						<a href="#">Filters:</a>
					</li>

					<li>
						<select class="form-control input-sm" name="asset_type" id="type">
							<option selected value=""> -- Select Type -- </option>
							@foreach( $asset_types as $key => $type )
								@if( request()->has('asset_type') && request()->asset_type == $key )
									<option value="{{ $key }}" selected>{{ $key }}</option>
								@else
									<option value="{{ $key }}">{{ $key }}</option>
								@endif
							@endforeach
			 			</select>		
					</li>

					<li>
						<select class="form-control input-sm" name="site" id="site">
			 				<option selected value=""> -- Select Site -- </option>
			 				@foreach( $site_options as $site )
				 				@if( request()->has('site') && request()->site == $site )
				 					<option value="{{ $site }}" selected>{{ $site }}</option>
				 				@else
				 					<option value="{{ $site }}">{{ $site }}</option>
				 				@endif
			 				@endforeach
			 			</select>		
					</li>

					<li>
						<select class="form-control input-sm" name="location" id="location">
							<option selected value=""> -- Select Location -- </option>
			 				@foreach( $locations as $location)
			 					@if( request()->has('location') && request()->location == $location )
				 					<option value="{{ $location }}" selected>{{ $location }}</option>
				 				@else
				 					<option value="{{ $location }}">{{ $location }}</option>
				 				@endif
			 				@endforeach
			 			</select>		
					</li>

					<li>
						<select class="form-control input-sm" name="condition" id="condition">
			 				<option selected value=""> -- Select Condition -- </option>
			 				@foreach( $conditions as $condition )
			 					@if( request()->has('condition') && request()->condition == $condition )
			 						<option value="{{ $condition }}" selected>{{ $condition }}</option>
			 					@else
			 						<option value="{{ $condition }}">{{ $condition }}</option>
			 					@endif
			 				@endforeach
			 			</select>		
					</li>

					<li>
						<select class="form-control input-sm" name="status" id="status">
							<option selected value=""> -- Select Status -- </option>
			 				@foreach( $statuses as $status )
			 					@if( request()->has('status') && request()->status == $status )
			 						<option value="{{ $status }}" selected>{{ $status }}</option>
			 					@else
			 						<option value="{{ $status }}">{{ $status }}</option>
			 					@endif
			 				@endforeach
			 			</select>		
					</li>				
					<li>
						<input type="submit" class="btn green btn-sm" value="Go">
						<a href="{{env('APP_URL')}}/assets" class="btn purple btn-sm" style="color:white;">Reset</a>						
					</li>

				</ul>

			</form>
			
		</div>

	</div>

	<div class="row ">

		<div class="col-md-12 col-sm-12">

			<div class="portlet box green-haze">
				
				<div class="portlet-title">
					
					<div class="caption">
						<i class="fa fa-bars"></i>Asset List
					</div>

					<div class="actions">
						
						<div class="btn-group">
							<a class="btn btn-default btn-sm" href="#" data-toggle="dropdown">
								Columns <i class="fa fa-angle-down"></i>
							</a>

							<div id="sample_4_column_toggler" class="dropdown-menu hold-on-click dropdown-checkboxes pull-right">
								<label><input type="checkbox" checked data-column="0">Tag No.</label>
								<label><input type="checkbox" checked data-column="1">Asset Type</label>
								<label><input type="checkbox" checked data-column="2">Description</label>
								<label><input type="checkbox" checked data-column="3">Manufacturer</label>
								<label><input type="checkbox" checked data-column="4">Model</label>
								<label><input type="checkbox" checked data-column="5">Serial No.</label>
								<label><input type="checkbox" checked data-column="6">Year Manufactured</label>
								<label><input type="checkbox" checked data-column="7">Commissioning Date</label>
								<label><input type="checkbox" checked data-column="8">Site</label>
								<label><input type="checkbox" checked data-column="9">Location</label>
								<label><input type="checkbox" checked data-column="10">Condition</label>
								<label><input type="checkbox" checked data-column="11">Status</label>
								<label><input type="checkbox" checked data-column="12">Vendor</label>
								<label><input type="checkbox" checked data-column="13">P.O. Ref</label>
								<label><input type="checkbox" checked data-column="14">P.O. Value</label>	
								<label><input type="checkbox" checked data-column="15">Actions</label>										
							</div>

						</div>


						<a class="btn btn-default btn-sm" href="{{env('APP_URL')}}/asset/new"><i class="fa fa-plus"></i> Add New</a>
						<a class="btn btn-default btn-sm" href="#" onclick="exportToExcel('#sample_4');"><i class="fa fa-file-excel-o"></i> Export</a>

					</div>	

				</div>

				<div class="portlet-body">	

					<table class="table" id="sample_4">

						<thead>
							<tr>
								<th>Tag No.</th>
								<th>Asset Type</th>
								<th>Description</th>
								<th>Manufacturer</th>
								<th>Model</th>	
								<th>Serial No.</th>
								<th>Year Manufactured</th>
								<th>Commissioning Date</th>
								<th>Site</th>
								<th>Location</th>
								<th>Condition</th>
								<th>Status</th>
								<th>Vendor</th>
								<th>P.O. Ref</th>
								<th>P.O. Value</th>
								<th width="10%">Actions</th>
							</tr>
						</thead>

						<tbody>
							@foreach( $assets as $asset )
								<tr>
									<td> {{ $asset->tag }} </td>
									<td> {{ $asset->asset_type }} </td>
									<td> {{ $asset->description }} </td>
									<td> {{ $asset->manufacturer }} </td>
									<td> {{ $asset->model }} </td>
									<td> {{ $asset->serial }} </td>
									<td> {{ $asset->year_manufactured }} </td>
									<td> {{ \Carbon\Carbon::parse($asset->commissioning_date)->toFormattedDateString() }} </td>
									<td> {{ $asset->site }} </td>
									<td> {{ $asset->location }} </td>
									<td> {{ $asset->condition }} </td>
									<td> {{ $asset->status }} </td>
									<td> {{ $asset->vendor }} </td>
									<td> {{ $asset->po_reference }} </td>
									<td> {{ $asset->po_value }} </td>
									<td> 
										<a href="{{env('APP_URL')}}/asset/{{$asset->id}}" title="Edit Asset" class="btn purple btn-sm">
											<i class="fa fa-edit"></i></a>
										<a href="#" title="Delete Asset" data="{{$asset->id}}"
											class="btn red btn-sm deletedl delete-asset">
											<i class="fa fa-minus-circle"></i>
										</a>
									</td>
								</tr>
							@endforeach
						</tbody>

					</table>						
				
				</div>

			</div>

		</div>		
				
	</div>

@endsection


@section('pageJS')

	<script src="{{env('APP_URL')}}/themes/metronic/assets/global/plugins/jquery-1.11.0.min.js" type="text/javascript"></script>
	<script src="{{env('APP_URL')}}/themes/metronic/assets/global/plugins/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
	<!-- IMPORTANT! Load jquery-ui-1.10.3.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
	<script src="{{env('APP_URL')}}/themes/metronic/assets/global/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js" type="text/javascript"></script>
	<script src="{{env('APP_URL')}}/themes/metronic/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="{{env('APP_URL')}}/themes/metronic/assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
	<script src="{{env('APP_URL')}}/themes/metronic/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
	<script src="{{env('APP_URL')}}/themes/metronic/assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
	<script src="{{env('APP_URL')}}/themes/metronic/assets/global/plugins/jquery.cokie.min.js" type="text/javascript"></script>
	<script src="{{env('APP_URL')}}/themes/metronic/assets/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
	<script src="{{env('APP_URL')}}/themes/metronic/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>

	<script type="text/javascript" src="{{env('APP_URL')}}/themes/metronic/assets/global/plugins/select2/select2.min.js"></script>
	<script type="text/javascript" src="{{env('APP_URL')}}/themes/metronic/assets/global/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="{{env('APP_URL')}}/themes/metronic/assets/global/plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js"></script>
	<script type="text/javascript" src="{{env('APP_URL')}}/themes/metronic/assets/global/plugins/datatables/extensions/ColReorder/js/dataTables.colReorder.min.js"></script>
	<script type="text/javascript" src="{{env('APP_URL')}}/themes/metronic/assets/global/plugins/datatables/extensions/Scroller/js/dataTables.scroller.min.js"></script>
	<script type="text/javascript" src="{{env('APP_URL')}}/themes/metronic/assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>


	<!-- BEGIN PAGE LEVEL SCRIPTS -->
	<script src="{{env('APP_URL')}}/themes/metronic/assets/global/scripts/metronic.js" type="text/javascript"></script>
	<script src="{{env('APP_URL')}}/themes/metronic/assets/admin/layout/scripts/layout.js" type="text/javascript"></script>
	<script src="{{env('APP_URL')}}/themes/metronic/assets/admin/layout/scripts/quick-sidebar.js" type="text/javascript"></script>
	<script src="{{env('APP_URL')}}/js/jquery.table2excel.js"></script>
	<script type="text/javascript">
		
		jQuery(document).ready(function() {    
			Metronic.init(); // init metronic core components
			Layout.init(); // init current layout
			TableAdvanced.init();

			$('#sample_4').on('click', '.delete-asset', function(){

				var id = $(this).attr('data');

				if( confirm('Are you sure you want to delete this asset?') ) {

					$.ajaxSetup({
                        headers:
                        { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
                    });

                    $.ajax({
                        type:'DELETE',
                        url:'{{env("APP_URL")}}/asset/'+id
                    }).done(function(data){
                    	console.log(data);
                       	location.reload();
                    });

				}


			});

		});

		var TableAdvanced = function () {

		    var initTable4 = function () {
		        var table = $('#sample_4');

		        var oTable = table.dataTable({
		            "columnDefs": [{
		                "orderable": false,
		                "targets": [0]
		            }],
		            "order": [
		                [1, 'asc']
		            ],
		            "lengthMenu": [
		                [5, 15, 20, -1],
		                [5, 15, 20, "All"] // change per page values here
		            ],
		            // set the initial value
		            "pageLength": 20,
		        });

		        var tableWrapper = $('#sample_4_wrapper'); // datatable creates the table wrapper by adding with id {your_table_jd}_wrapper
		        var tableColumnToggler = $('#sample_4_column_toggler');

		        /* modify datatable control inputs */
		        tableWrapper.find('.dataTables_length select').select2(); // initialize select2 dropdown

		        /* handle show/hide columns*/
		        $('input[type="checkbox"]', tableColumnToggler).change(function () {
		            /* Get the DataTables object again - this is not a recreation, just a get of the object */
		            var iCol = parseInt($(this).attr("data-column"));
		            var bVis = oTable.fnSettings().aoColumns[iCol].bVisible;
		            oTable.fnSetColumnVis(iCol, (bVis ? false : true));
		        });
		    }

		    return {
		        init: function () {
		            if (!jQuery().dataTable) {
		                return;
		            }
		            initTable4();	            
		        }

		    };

		}();

		function exportToExcel(table){

			jQuery(table).table2excel({
				name: "Assets",
			    filename: "Assets" //do not include extension
			}); 

		}

	</script>


@endsection