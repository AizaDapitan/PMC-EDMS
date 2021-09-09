@extends('layouts.app')

@section('pageCSS')

	<link href="google.css" rel="stylesheet" type="text/css"/>
	<link href="{{env('APP_URL')}}/themes/metronic/assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
	<link href="{{env('APP_URL')}}/themes/metronic/assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css"/>
	<link href="{{env('APP_URL')}}/themes/metronic/assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
	<link href="{{env('APP_URL')}}/themes/metronic/assets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
	<link href="{{env('APP_URL')}}/themes/metronic/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css"/>
	<!-- END GLOBAL MANDATORY STYLES -->
	<!-- BEGIN PAGE LEVEL PLUGIN STYLES -->
	<link href="{{env('APP_URL')}}/themes/metronic/assets/global/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css"/>
	<link href="{{env('APP_URL')}}/themes/metronic/assets/global/plugins/fullcalendar/fullcalendar/fullcalendar.css" rel="stylesheet" type="text/css"/>

	<link rel="stylesheet" type="text/css" href="{{env('APP_URL')}}/themes/metronic/assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css"/>

	<link rel="stylesheet" type="text/css" href="{{env('APP_URL')}}/themes/metronic/assets/global/plugins/clockface/css/clockface.css"/>
	<link rel="stylesheet" type="text/css" href="{{env('APP_URL')}}/themes/metronic/assets/global/plugins/bootstrap-datepicker/css/datepicker3.css"/>
	<link rel="stylesheet" type="text/css" href="{{env('APP_URL')}}/themes/metronic/assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css"/>
	<link rel="stylesheet" type="text/css" href="{{env('APP_URL')}}/themes/metronic/assets/global/plugins/bootstrap-colorpicker/css/colorpicker.css"/>
	<link rel="stylesheet" type="text/css" href="{{env('APP_URL')}}/themes/metronic/assets/global/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css"/>
	<link rel="stylesheet" type="text/css" href="{{env('APP_URL')}}/themes/metronic/assets/global/plugins/bootstrap-datetimepicker/css/datetimepicker.css"/>

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

@endsection


@section('content')

	<!-- Search | Filter -->
	<div class="row">
		
		<div class="col-md-12" >
			
			<div style="margin-left: 50px;">
			<h3 class="page-title"> Genset List </h3>
			
			<form method="GET" role="form" action="/genset-list">
			
			<ul class="page-breadcrumb breadcrumb">
				
				<li>							
					<a href="#">Search:</a>							
				</li>

				<li>			

					<select class="form-control input-sm" name="s_location">
		 				<option value="" disabled selected> - Location - </option>
                            @foreach($u_location as $key => $value )
                                @if( urldecode(request('s_location')) == $key )
                                    <option value="{{$key}}" selected > {{ $key }} </option>
                                @else
                                    <option value="{{$key}}" > {{ $key }} </option>
                                @endif
                            @endforeach     
                        </select>  
		 			</select>		

				</li>

				<li>							
					<select class="form-control input-sm" name="s_type">
		 				<option value="" disabled selected> - Category - </option>
                            @foreach($u_type as $key => $value )
                                @if( urldecode(request('s_type')) == $key )
                                    <option value="{{$key}}" selected> {{ $key }} </option>
                                @else
                                    <option value="{{$key}}"> {{ $key }} </option>
                                @endif
                            @endforeach  
                        </select>
		 			</select>				 											
				</li>

				<li>
					<select class="form-control input-sm" name="s_name">
		 				<option value="" disabled selected> - Unit - </option>
                            @foreach($u_name as $unit )
                                @if( urldecode(request('s_name')) == $unit->name )
                                    <option value="{{$unit->name}}" selected> {{ $unit->name }} </option>
                                @else
                                    <option value="{{$unit->name}}"> {{ $unit->name }} </option>
                                @endif
                            @endforeach  
		 			</select>
				</li>

				<li>
					<input type="submit" class="btn green btn-sm" value="Go">
				</li>	

				<li class="pull-right" style="position:relative;top:5px;">
                    <div id="dashboard-report-range" class="dashboard-date-range tooltips" data-placement="top" data-original-title="Change dashboard date range">
                        <i class="icon-calendar"></i>
                        <span></span>
                        <i class="fa fa-angle-down"></i>
                    </div>
                </li>			
				
			</ul>

			</form>

			<input type="hidden" name="hiddenstart" id="hiddenstart" value="">
			<input type="hidden" name="hiddenend" id="hiddenend" value="">
			<input type="hidden" name="hiddens_location" id="hiddens_location" value="">
			<input type="hidden" name="hiddens_name" id="hiddens_name" value="">
			<input type="hidden" name="hiddens_type" id="hiddens_type" value="">

			</div>
		</div>

	</div>
	<!-- End Search | Filter -->

	<!-- Display Downlist Data -->
	<div class="row ">
		
		<div class="col-md-12 col-sm-12">
			
			<div style="margin-left: 50px;"> 
			<table class="table table-condensed table-striped table-hover" id="sample_4">
				
				<thead>
					<tr>
						<th>#</th>
						<th>Unit</th>
						<th>Start</th>
						<th>End</th>
						<th>Fuel</th>
						<th>KWH</th>
						<th>Remarks</th>	
						<th>Actions</th>											
					</tr>
				</thead>

				<tbody>
					@foreach( $downtime as $key => $down )
						<tr>
							<td >{{ $key + 1 }}</td>
							<td >{{ $down->unit? $down->unit->name : 'N/A' }}</td>
							<td >{{ $down->start_date->toFormattedDateString() }}</td>
							<td >{{ $down->end_date->toFormattedDateString() }}</td>
							<td >{{ $down->fuel }}</td>
							<td >{{ $down->kwh }}</td>							
							<td width="30%">{{ $down->remarks }}</td>
							<td>
								<a href="#" class="btn purple btn-sm" onclick="window.open('/genset/{{$down->id}}','displayWindow','toolbar=no,scrollbars=yes,width=800,height=600'); return false; " title="Edit Genset"><i class="fa fa-edit"></i></a>
                                <a href="#" class="btn red btn-sm deletedl" data="{{ $down->id }}" title="Delete Genset"><i class="fa fa-minus-circle"></i></a>
							</td>
						</tr>
					@endforeach
				</tbody>

			</table>	
			
			</div>	
		</div>	

	</div>
	<!-- End Display Downlist Data -->

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
	<!-- END CORE PLUGINS -->
	<!-- BEGIN PAGE LEVEL PLUGINS -->
	<script src="{{env('APP_URL')}}/themes/metronic/assets/global/plugins/jquery.pulsate.min.js" type="text/javascript"></script>
	<script src="{{env('APP_URL')}}/themes/metronic/assets/global/plugins/bootstrap-daterangepicker/moment.min.js" type="text/javascript"></script>
	<script src="{{env('APP_URL')}}/themes/metronic/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.js" type="text/javascript"></script>
	<script src="{{env('APP_URL')}}/themes/metronic/assets/global/plugins/gritter/js/jquery.gritter.js" type="text/javascript"></script>
	<!-- IMPORTANT! fullcalendar depends on jquery-ui-1.10.3.custom.min.js for drag & drop support -->
	<script src="{{env('APP_URL')}}/themes/metronic/assets/global/plugins/fullcalendar/fullcalendar/fullcalendar.min.js" type="text/javascript"></script>
	<script src="{{env('APP_URL')}}/themes/metronic/assets/global/plugins/jquery-easypiechart/jquery.easypiechart.js" type="text/javascript"></script>
	<script src="{{env('APP_URL')}}/themes/metronic/assets/global/plugins/jquery.sparkline.min.js" type="text/javascript"></script>
	<script src="{{env('APP_URL')}}/themes/metronic/assets/global/plugins/bootbox/bootbox.min.js" type="text/javascript"></script>

	<script type="text/javascript" src="{{env('APP_URL')}}/themes/metronic/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
	<script type="text/javascript" src="{{env('APP_URL')}}/themes/metronic/assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script>
	<script type="text/javascript" src="{{env('APP_URL')}}/themes/metronic/assets/global/plugins/clockface/js/clockface.js"></script>
	<script type="text/javascript" src="{{env('APP_URL')}}/themes/metronic/assets/global/plugins/bootstrap-daterangepicker/moment.min.js"></script>
	<script type="text/javascript" src="{{env('APP_URL')}}/themes/metronic/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
	<script type="text/javascript" src="{{env('APP_URL')}}/themes/metronic/assets/global/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
	<script type="text/javascript" src="{{env('APP_URL')}}/themes/metronic/assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>

	<script type="text/javascript" src="{{env('APP_URL')}}/themes/metronic/assets/global/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="{{env('APP_URL')}}/themes/metronic/assets/global/plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js"></script>
	<script type="text/javascript" src="{{env('APP_URL')}}/themes/metronic/assets/global/plugins/datatables/extensions/ColReorder/js/dataTables.colReorder.min.js"></script>
	<script type="text/javascript" src="{{env('APP_URL')}}/themes/metronic/assets/global/plugins/datatables/extensions/Scroller/js/dataTables.scroller.min.js"></script>
	<script type="text/javascript" src="{{env('APP_URL')}}/themes/metronic/assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>

	<!-- END PAGE LEVEL PLUGINS -->
	<!-- BEGIN PAGE LEVEL SCRIPTS -->
	<script src="{{env('APP_URL')}}/themes/metronic/assets/global/scripts/metronic.js" type="text/javascript"></script>
	<script src="{{env('APP_URL')}}/themes/metronic/assets/admin/layout/scripts/layout.js" type="text/javascript"></script>
	<script src="{{env('APP_URL')}}/themes/metronic/assets/admin/layout/scripts/quick-sidebar.js" type="text/javascript"></script>
	<script src="{{env('APP_URL')}}/themes/metronic/assets/admin/pages/scripts/index.js" type="text/javascript"></script>
	<script src="{{env('APP_URL')}}/themes/metronic/assets/admin/pages/scripts/components-pickers.js"></script>
	<script type="text/javascript" src="/js/downtime.js"></script>

	<script type="text/javascript">

		jQuery(document).ready(function() {    
		  	
			Metronic.init(); // init metronic core components
			Layout.init(); // init current layout
		  	TableAdvanced.init();

		    $('#sample_4').on('click', '.deletedl', function(){       
                
                var x = $(this).attr('data');
                console.log(x);

                bootbox.confirm("Are you sure you want to delete this record?", function(result) {
                    
                    if(result){
                        $.ajaxSetup({
                            headers:
                            { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
                        });

                        $.ajax({
                            type:'DELETE',
                            url:'/genset/'+x  
                        }).done(function(data){
                        	console.log(data);
                           	location.reload();
                        });
                    }

                }); 

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
		                [0, 'asc']
		            ],
		            "lengthMenu": [
		                [5, 15, 20, -1],
		                [5, 15, 20, "All"] // change per page values here
		            ],
		            // set the initial value
		            "pageLength": 20,
		        });

		        // var tableWrapper = $('#sample_4_wrapper'); // datatable creates the table wrapper by adding with id {your_table_jd}_wrapper
		        // var tableColumnToggler = $('#sample_4_column_toggler');

		        // /* modify datatable control inputs */
		        // tableWrapper.find('.dataTables_length select').select2(); // initialize select2 dropdown

		        // /* handle show/hide columns*/
		        // $('input[type="checkbox"]', tableColumnToggler).change(function () {
		        //     /* Get the DataTables object again - this is not a recreation, just a get of the object */
		        //     var iCol = parseInt($(this).attr("data-column"));
		        //     var bVis = oTable.fnSettings().aoColumns[iCol].bVisible;
		        //     oTable.fnSetColumnVis(iCol, (bVis ? false : true));
		        // });
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
		
	</script>

@endsection