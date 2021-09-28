@extends('layouts.app')

@section('pageCSS')

	<link href="{{env('APP_URL')}}/themes/metronic/assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
	<link href="{{env('APP_URL')}}/themes/metronic/assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css"/>
	<link href="{{env('APP_URL')}}/themes/metronic/assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
	<link href="{{env('APP_URL')}}/themes/metronic/assets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
	<link href="{{env('APP_URL')}}/themes/metronic/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css"/>
	<!-- END GLOBAL MANDATORY STYLES -->
	<!-- BEGIN PAGE LEVEL PLUGIN STYLES -->
	<link href="{{env('APP_URL')}}/themes/metronic/assets/global/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css"/>
	<link href="{{env('APP_URL')}}/themes/metronic/assets/global/plugins/fullcalendar/fullcalendar/fullcalendar.css" rel="stylesheet" type="text/css"/>

	<link rel="stylesheet" type="text/css" href="{{env('APP_URL')}}/themes/metronic/assets/global/plugins/clockface/css/clockface.css"/>
	<link rel="stylesheet" type="text/css" href="{{env('APP_URL')}}/themes/metronic/assets/global/plugins/bootstrap-datepicker/css/datepicker3.css"/>
	<link rel="stylesheet" type="text/css" href="{{env('APP_URL')}}/themes/metronic/assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css"/>
	<link rel="stylesheet" type="text/css" href="{{env('APP_URL')}}/themes/metronic/assets/global/plugins/bootstrap-colorpicker/css/colorpicker.css"/>
	<link rel="stylesheet" type="text/css" href="{{env('APP_URL')}}/themes/metronic/assets/global/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css"/>
	<link rel="stylesheet" type="text/css" href="{{env('APP_URL')}}/themes/metronic/assets/global/plugins/bootstrap-datetimepicker/css/datetimepicker.css"/>

	<link href="{{env('APP_URL')}}/themes/metronic/assets/global/plugins/nouislider/jquery.nouislider.css" rel="stylesheet" type="text/css"/>


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

		
	<!-- BEGIN PAGE HEADER-->
		
	<div class="row">

		@if(session()->has('message'))
            <div class="col-md-12">

                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                	<span class="fa fa-check-square-o"></span>
                    <strong>Success!</strong> {{ session()->get('message') }}
                </div>

            </div>
        @endif

        @if(session()->has('error_message'))
            <div class="col-md-12">

                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                    <strong>Oops!</strong> {{ session()->get('error_message') }}
                </div>

            </div>
        @endif

        @if($errors->any())
            <div class="col-md-12">

                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                    <strong>Oops!</strong> {{ $errors->first() }}
                </div>

            </div>
        @endif
	
		<div class="col-md-12">

			<!-- input modal --->
                @include('modals.new-unit-modal')
                @include('modals.new-genset-modal')
            <!-- end input modal -->    
			
			<!-- <h3 class="page-title"> EDMS <small>Availability Records</small> </h3> -->
            <div class="breadcrumbs">                
                <ol class="breadcrumb">
                    <li><a href="{{ url('/dashboard') }}">Home</a></li>
                    <li class="active">Genset Units</li>
                </ol>

                <h1>Genset Units</h1>
                
            </div>

			
			<form method="GET" role="form" action="{{ route('genset') }}">

				<ul class="page-breadcrumb breadcrumb">
					
					<li> <a href="#">Filters:</a> </li>
					
					<li>			
						
						<input type="hidden" name="startDate" id="hiddenstart" 
	                            value="{{ request()->has('startDate') ? request('startDate') : \Carbon\Carbon::now()->subMonth()->format('Y-m-d') }}">
	                    <input type="hidden" name="endDate" id="hiddenend" 
	                            value="{{ request()->has('endDate') ? request('endDate') : date('Y-m-d') }}">  

						<!-- <input type="hidden" name="datetype" value="">	 -->

						<select class="form-control input-sm" name="s_location" id="s_location" onchange="changefilters();">
			 				<option value="" disabled selected> - Location - </option>
	                        @foreach($u_location as $key => $value )
	                            @if( urldecode(request('s_location')) == $key )
                                    <option value="{{$key}}" selected > {{ $key }} </option>
                                @else
                                    <option value="{{$key}}" > {{ $key }} </option>
                                @endif
	                        @endforeach 	                        
			 			</select>							
					</li>

					<li>							
						<select class="form-control input-sm" name="s_type" id="s_type"onchange="changefilters();">
							@if( request()->has('s_type') )
			 					<option value="GENSET UNITS AND GENSET BREAKERS" selected> GENSET UNITS AND GENSET BREAKERS </option>
			 				@else
				 				<option value="" disabled selected> - Category - </option>
				 				<option value="GENSET UNITS AND GENSET BREAKERS"> GENSET UNITS AND GENSET BREAKERS </option>
	                        @endif
			 			</select>				 											
					</li>

					<li id="unitlist">
						<select class="form-control input-sm" name="s_name" id="s_name">
			 				<option value="" disabled selected> - Unit - </option>
	                        @foreach($units as $unit )
	                        	@if( $unit->type == 'GENSET UNITS AND GENSET BREAKERS' )
		                            @if( urldecode(request('s_name')) == $unit->name )
                                    <option value="{{$unit->name}}" selected> {{ $unit->name }} </option>
	                                @else
	                                    <option value="{{$unit->name}}"> {{ $unit->name }} </option>
	                                @endif
		                        @endif
	                        @endforeach  
			 			</select>
					</li>
				
					<li>
						<input type="submit" class="btn green btn-sm" value="Go">
						<a href="{{env('APP_URL')}}/genset" class="btn purple btn-sm" style="color:white;">Reset</a>
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
			
		</div>

	</div>

	<input type="hidden" name="hiddenstart" id="hiddenstart" value="">
	<input type="hidden" name="hiddenend" id="hiddenend" value="">
	<input type="hidden" name="hiddens_location" id="hiddens_location" value="">
	<input type="hidden" name="hiddens_name" id="hiddens_name" value="">
	<input type="hidden" name="hiddens_type" id="hiddens_type" value="">
	<!-- END PAGE HEADER-->

	<div class="clearfix"></div>

	<div class="row margin-bottom-10">

		<div class="col-md-12">

			<div class=" pull-right">
			@if($createRuntime)
					<a data-toggle="modal" href="#gensetdowntime" class="btn yellow-casablanca">Add Genset Run Time</a>	
				@else
					<button disabled class="btn yellow-casablanca">Add Genset Run Time</button>	
				@endif
				<a href="{{env('APP_URL')}}/rpt_genset_utilization" target="blank" class="btn blue-madison">Daily Utilization Report</a>
				<a href="{{env('APP_URL')}}/genset-list" id="dl_raw_genset" class="btn purple">Download Raw Data</a>
			</div>	

		</div>

	</div>

	<div class="row">

		<div class="col-md-12 col-sm-12">

			<div class="portlet solid bordered grey-cararra">

				<div class="portlet-title">

					<div class="caption">
						<i class="fa fa-bar-chart-o"></i>Monitoring
					</div>

					<div class="tools">

						<div class="btn-group" data-toggle="buttons">

							@if( request()->has('type') && request()->type == 'daily' )
                                <label class="btn grey-steel btn-sm active">
                                <input type="radio" name="datetype" 
                                    class="toggle" value="daily" id="option1" onchange="refresh_all();" checked>Daily</label>
                            @else
                                <label class="btn grey-steel btn-sm">
                                <input type="radio" name="datetype" 
                                    class="toggle" value="daily" id="option1" onchange="refresh_all();">Daily</label>
                            @endif

                            @if( !request()->has('type') || request()->type == 'undefined' )
                                <label class="btn grey-steel btn-sm active">
                                <input type="radio" name="datetype" 
                                    class="toggle" value="weekly" id="option2" onchange="refresh_all();" checked>Weekly</label>
                            @else
                                @if( request()->has('type') && request()->type == 'weekly' )                                
                                    <label class="btn grey-steel btn-sm active">
                                    <input type="radio" name="datetype" 
                                        class="toggle" value="weekly" id="option2" onchange="refresh_all();" checked>Weekly</label>
                                @else
                                    <label class="btn grey-steel btn-sm">
                                    <input type="radio" name="datetype" 
                                        class="toggle" value="weekly" id="option2" onchange="refresh_all();">Weekly</label>
                                @endif
                            @endif

                            @if( request()->has('type') && request()->type == 'monthly' )
                                <label class="btn grey-steel btn-sm active">
                                <input type="radio" name="datetype" 
                                    class="toggle" value="monthly" id="option3" onchange="refresh_all();" checked>Monthly</label>
                            @else
                                <label class="btn grey-steel btn-sm">
                                <input type="radio" name="datetype" 
                                    class="toggle" value="monthly" id="option3" onchange="refresh_all();">Monthly</label>
                            @endif

						</div>

					</div>

				</div>

				<div class="portlet-body" style="overflow: auto;">
				
					<table style="font-size:12px;" class="table table-bordered" id="table567">

						<thead>
                            
                            <td width="20%"><h4 style="font-weight: 700; color: blue;"> GENSET UNITS AND GENSET BREAKERS </h4></td>
                            @foreach( $displayDate as $date ) 
                                @if( request()->has('type') && request()->type == 'daily' )
                                    <td class="text-center"> <h5> {{ $date['start'] }} </h5> </td>
                                @else
                                    <td class="text-center"> <h5> {{ $date['start'] }} - {{ $date['end'] }} </h5> </td>
                                @endif
                            @endforeach

                        </thead>

                        <tbody>

                            @foreach( $units->where('type', 'GENSET UNITS AND GENSET BREAKERS')->groupBy('location') as $key1 => $val1 )
                            
                                <tr>
                                    <td><h5><strong> {{ $key1 }} </strong></h5></td>

                                    @foreach( $val1 as $unit ) 
                                    <tr>
                                        <td> <a href="#" onclick="window.open('{{env('APP_URL')}}/unit/{{$unit->id}}','displayWindow','toolbar=no,scrollbars=yes,width=800,height=600'); return false;" style="color: #000000;"> {{ $unit->name }} </a> </td>
                                        
                                        @foreach( $displayData as $unit_d_data )

                                            @if( $unit_d_data['unit'] == $unit->id )

                                                @foreach( $unit_d_data['genset_data'] as $range_d_data )
                                                	@php $mins = number_format(  $range_d_data['runtime'] / 60, 2 ) @endphp
                                                    @if( $range_d_data['runtime'] != 0 ) 
                                                        <td class="text-center tdtab" style="background: green; color: white;">
                                                        	<a href="" onclick="return false;" data-toggle="popover" title="{{$mins}}hrs" 
                                                                    data-content="{{ $range_d_data['remarks'] }}" data-trigger="hover" style="color:white;" data-placement="top">
	                                                        	<span class="dTime_percentage">
	                                                        		{{ $mins  }}
	                                                        	</span> hrs
	                                                        </a>
                                                        </td>
                                                    @else
                                                        <td class="text-center tdtab" style="background: green; color: white;">
                                                        	<a href="" onclick="return false;" data-toggle="popover" title="0" 
                                                                    data-content="" data-trigger="hover" style="color:white;" 
                                                                    data-placement="top">
                                                         		<span class="dTime_percentage">0</span>
                                                         	</a>
                                                         </td>
                                                    @endif

                                                @endforeach

                                            @endif

                                        @endforeach

                                    </tr>
                                	@endforeach

                                </tr>

                            @endforeach


                        </tbody>

					</table>

				</div>

			</div>
			<!-- END PORTLET-->
		</div>		

	</div>

	<div class="row ">

		<div class="col-md-12 col-sm-12">

			<div class="portlet box blue-steel">
				
				<div class="portlet-title">
					
					<div class="caption">
						<i class="fa fa-bell-o"></i>Recent Utilization Logs
					</div>
					
				</div>

				<div class="portlet-body">
					
					<div class="scroller" style="height: 400px;" data-always-visible="1" data-rail-visible="0">
						
						<ul class="feeds">
							
							<table class="table" id="genset-util">
								
								<thead>
									<tr>
										<th>#</th>
										<th>Unit</th>
										<th>Start</th>
										<th>End</th>
										<th>Fuel</th>
										<th>KWH</th>
										<th>Start Run hrs</th>
										<th>Stop Run hrs</th>
										<th>Total Run hrs</th>
										<th>Remarks</th>	
										<th>Actions</th>											
									</tr>
								</thead>

								<tbody>
									
									@foreach( $gensets as $key => $genset )
										<tr>
											<td>{{ $key + 1 }}</td>
											<td>{{ $genset->unit ? $genset->unit->name : 'N/A' }}</td>
											<td>{{ $genset->start_date->toFormattedDateString() }}</td>
											<td>{{ $genset->end_date->toFormattedDateString() }}</td>
											<td>{{ $genset->fue }}</td>
											<td>{{ $genset->kwh }}</td>
											<td>{{ $genset->run_start }}</td>
											<td>{{ $genset->run_stop }}</td>
											<td>{{ $genset->run_stop - $genset->run_start }}</td>
											<td>{{ $genset->remarks }}</td>
											<td>
												<a href="#" class="btn purple btn-sm" onclick="window.open('{{env('APP_URL')}}/genset/{{$genset->id}}','displayWindow','toolbar=no,scrollbars=yes,width=800,height=600'); return false; "
													title="Edit Genset"><i class="fa fa-edit"></i></a>
                                                <a href="#" class="btn red btn-sm deletedl" data="{{ $genset->id }}"
                                                	title="Delete Genset"><i class="fa fa-minus-circle"></i></a>
											</td>
										</tr>
									@endforeach

								</tbody>

							</table>	

						</ul>

					</div>

					<div class="scroller-footer">

						<div class="btn-arrow-link pull-right">

							<a href="{{ route('genset_list') }}">See All Records</a>
							<i class="icon-arrow-right"></i>

						</div>

					</div>

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

	<script src="{{env('APP_URL')}}/themes/metronic/assets/global/plugins/nouislider/jquery.nouislider.min.js"></script>


	<!-- END PAGE LEVEL PLUGINS -->
	<!-- BEGIN PAGE LEVEL SCRIPTS -->
	<script src="{{env('APP_URL')}}/themes/metronic/assets/global/scripts/metronic.js" type="text/javascript"></script>
	<script src="{{env('APP_URL')}}/themes/metronic/assets/admin/layout/scripts/layout.js" type="text/javascript"></script>
	<script src="{{env('APP_URL')}}/themes/metronic/assets/admin/layout/scripts/quick-sidebar.js" type="text/javascript"></script>
	<script src="{{env('APP_URL')}}/themes/metronic/assets/admin/pages/scripts/index.js" type="text/javascript"></script>
	<script src="{{env('APP_URL')}}/themes/metronic/assets/admin/pages/scripts/components-pickers.js"></script>
	<script src="{{env('APP_URL')}}/themes/metronic/assets/admin/pages/scripts/components-nouisliders.js"></script>
	<script type="text/javascript" src="{{env('APP_URL')}}/js/genset.js"></script>

	<script>
		var unitss = {!! $u_name !!};
        jQuery(document).ready(function() {    
            
            Metronic.init(); // init metronic core components
            Layout.init(); // init current layout
           
            $('[data-toggle="popover"]').popover(); 
            
            Index.init();
            Index.initDashboardDaterange();   
            ComponentsPickers.init();
                
            $('.deletedl').click(function(){       
                
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
                            url:'{{env("APP_URL")}}/genset/'+x  
                        }).done(function(data){
                        	console.log(data);
                           	location.reload();
                        });
                    }

                }); 

            });

        });

        function compute_hours(){
			var start = $('#startreading').val();
			var stop = $('#stopreading').val();
			var totalrunhours = parseFloat(stop) - parseFloat(start);
			$('#totalrunhours').val(totalrunhours);
		}

    </script>

@endsection