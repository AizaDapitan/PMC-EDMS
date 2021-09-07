<html lang="en">

	<!--<![endif]-->
	<!-- BEGIN HEAD -->
	<head>
		<meta charset="utf-8"/>
		<title>EDMS | Monitoring</title>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
		<meta content="" name="description"/>
		<meta content="" name="author"/>
		<!-- BEGIN GLOBAL MANDATORY STYLES -->
		<link href="google.css" rel="stylesheet" type="text/css"/>
		<link href="/themes/metronic/assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
		<link href="/themes/metronic/assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css"/>
		<link href="/themes/metronic/assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
		<link href="/themes/metronic/assets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
		<link href="/themes/metronic/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css"/>
		<!-- END GLOBAL MANDATORY STYLES -->
		<!-- BEGIN PAGE LEVEL PLUGIN STYLES -->
		<link href="/themes/metronic/assets/global/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css"/>
		<link href="/themes/metronic/assets/global/plugins/fullcalendar/fullcalendar/fullcalendar.css" rel="stylesheet" type="text/css"/>
		<link rel="stylesheet" type="text/css" href="/themes/metronic/assets/global/plugins/clockface/css/clockface.css"/>
		<link rel="stylesheet" type="text/css" href="/themes/metronic/assets/global/plugins/bootstrap-datepicker/css/datepicker3.css"/>
		<link rel="stylesheet" type="text/css" href="/themes/metronic/assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css"/>
		<link rel="stylesheet" type="text/css" href="/themes/metronic/assets/global/plugins/bootstrap-colorpicker/css/colorpicker.css"/>
		<link rel="stylesheet" type="text/css" href="/themes/metronic/assets/global/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css"/>
		<link rel="stylesheet" type="text/css" href="/themes/metronic/assets/global/plugins/bootstrap-datetimepicker/css/datetimepicker.css"/>
		<!-- END PAGE LEVEL PLUGIN STYLES -->
		<!-- BEGIN PAGE STYLES -->
		<link href="/themes/metronic/assets/admin/pages/css/tasks.css" rel="stylesheet" type="text/css"/>
		<!-- END PAGE STYLES -->
		<!-- BEGIN THEME STYLES -->
		<link href="/themes/metronic/assets/global/css/components.css" rel="stylesheet" type="text/css"/>
		<link href="/themes/metronic/assets/global/css/plugins.css" rel="stylesheet" type="text/css"/>
		<link href="/themes/metronic/assets/admin/layout/css/layout.css" rel="stylesheet" type="text/css"/>
		<link id="style_color" href="/themes/metronic/assets/admin/layout/css/themes/default.css" rel="stylesheet" type="text/css"/>
		<link href="/themes/metronic/assets/admin/layout/css/custom.css" rel="stylesheet" type="text/css"/>
		<!-- END THEME STYLES -->
		<link rel="shortcut icon" href="favicon.ico"/>
		<style>
			.popover-title {
		color: black;
		
			}
			.popover-content {
			color: black;
			
			}
		</style>
	</head>
	<body class="page-header-fixed page-full-width">

		<div class="page-container">
			<!-- BEGIN CONTENT -->
			<div class="page-content-wrapper">
				
				<div class="page-content">
					
					<div class="row">

						<div class="col-md-12">
							
							<table width="100%">
								<tr>
									<td align="center">
										<font color="blue" size="+1">Equipment Up Time Data</font><br>
											@if( request()->startdate )
											<strong>From:</strong> {{ \Carbon\Carbon::parse(request()->startdate)->toFormattedDateString() }} 
											&nbsp;
											<strong>To:</strong> {{ \Carbon\Carbon::parse(request()->enddate)->toFormattedDateString() }}
										@else
											As of: {{ date('F d,Y') }}<br>
										@endif
									</td>
								</tr>
							</table> <br>

						</div>

					</div>

					<form method="GET" role="form">

						<div class="row">

							<div class="col-md-12">

								<div class="row">
									
									<div class="col-md-3">
										<div class="form-group">
											<label class="control-label col-md-3">Start</label>
											<div class="col-md-9">
												<div class="input-group date date-picker margin-bottom-5 col-md-12" data-date-format="yyyy-mm-dd">
													<input type="text" class="form-control form-filter input-sm" readonly name="startdate" id="startdate" value="{{ request()->has('startdate') ? request('startdate') : date('Y-m-d') }}">
													<span class="input-group-btn">
														<button class="btn  default" type="button"><i class="fa fa-calendar"></i></button>
													</span>
												</div>
											</div>
										</div>
									</div>

									<div class="col-md-3">
										<div class="form-group">
											<label class="control-label col-md-3">End</label>
											<div class="col-md-9">
												<div class="input-group date date-picker margin-bottom-5 col-md-12" data-date-format="yyyy-mm-dd">
													<input type="text" class="form-control form-filter input-sm" readonly name="enddate" id="enddate" value="{{ request()->has('enddate') ? request('enddate') : date('Y-m-d') }}">
													<span class="input-group-btn">
														<button class="btn  default" type="button"><i class="fa fa-calendar"></i></button>
													</span>
												</div>
											</div>
										</div>
									</div>

									<div class="col-md-2">
										<select class="form-control" name="is_scheduled">
											<option value="1" {{request()->is_scheduled == 1?'selected':'' }}> Planned Only </option>
						            		<option value="0" {{request()->is_scheduled == 0?'selected':'' }}> Breakdown Downtime Only </option>
						            		<option value="2" {{request()->is_scheduled == 2?'selected':'' }}> Grid Outage </option>
						            		<option value="3" {{request()->is_scheduled == 3 || !request()->has('is_scheduled')?'selected':'' }}> All </option>
										</select>
									</div>

									<div class="col-md-3 col-md-offset-1">
										<table width="100%">
											<tr>												
												<td><input type="submit" class="btn purple" value="Generate"></td>
											</tr>
										</table>
									</div>

								</div>

							</div>

						</div>

					</form>

					<div class="row">

						<div class="col-md-12">

							<table width="100%">
								
								<tr>
									<td colspan="3">
									<a class="btn green" href="#" onclick="exportToExcel('#sample_4')">Export to Excel</a>
									@php
										$_url = str_replace('/rpt_daily', '/rpt_daily_print', request()->getRequestUri());
									@endphp

									&nbsp;<a class="btn purple" href="{{$_url}}">Print</a>
								</td>
									
								</tr>

							</table> <br> 

							<div class="table-scrollable">
							<table width="100%" style="font-style:Arial;font-size:14px;" class="table table-bordered" id="sample_4">
													
								<thead>
									<td class="text-center"> # </td>
									<td class="text-center"> Units </td>
									@foreach( $displayDate as $date )
										<td class="text-center"> {{ $date }}</td>
									@endforeach
							 	</thead>	

								<tbody>
									@php $count = 1; @endphp
									@foreach( $displayData as $key => $data )
										<tr>
											<td class="text-center"> {{ $count }} </td>
											<td class="text-center"><strong> {{ $key }} </strong></td>
											@foreach( $data as $d )
												<td class="text-center">
												 	{{ number_format( (1440 - $d['mins']) / 60, 2) }}
												 </td>
											@endforeach
										</tr>
										@php $count++; @endphp
									@endforeach
								</tbody>										
								
							</table>
							</div>
						</div>

					</div>

				</div>

			</div>

		</div>


	<script src="/themes/metronic/assets/global/plugins/jquery-1.11.0.min.js" type="text/javascript"></script>
	<script src="/themes/metronic/assets/global/plugins/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
	<!-- IMPORTANT! Load jquery-ui-1.10.3.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
	<script src="/themes/metronic/assets/global/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js" type="text/javascript"></script>
	<script src="/themes/metronic/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="/themes/metronic/assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
	<script src="/themes/metronic/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
	<script src="/themes/metronic/assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
	<script src="/themes/metronic/assets/global/plugins/jquery.cokie.min.js" type="text/javascript"></script>
	<script src="/themes/metronic/assets/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
	<script src="/themes/metronic/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
	<!-- END CORE PLUGINS -->
	<!-- BEGIN PAGE LEVEL PLUGINS -->
	<script src="/themes/metronic/assets/global/plugins/jquery.pulsate.min.js" type="text/javascript"></script>
	<script src="/themes/metronic/assets/global/plugins/bootstrap-daterangepicker/moment.min.js" type="text/javascript"></script>
	<script src="/themes/metronic/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.js" type="text/javascript"></script>
	<script src="/themes/metronic/assets/global/plugins/gritter/js/jquery.gritter.js" type="text/javascript"></script>
	<!-- IMPORTANT! fullcalendar depends on jquery-ui-1.10.3.custom.min.js for drag & drop support -->
	<script src="/themes/metronic/assets/global/plugins/fullcalendar/fullcalendar/fullcalendar.min.js" type="text/javascript"></script>
	<script src="/themes/metronic/assets/global/plugins/jquery-easypiechart/jquery.easypiechart.js" type="text/javascript"></script>
	<script src="/themes/metronic/assets/global/plugins/jquery.sparkline.min.js" type="text/javascript"></script>
	<script type="text/javascript" src="/themes/metronic/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
	<script type="text/javascript" src="/themes/metronic/assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script>
	<script type="text/javascript" src="/themes/metronic/assets/global/plugins/clockface/js/clockface.js"></script>
	<script type="text/javascript" src="/themes/metronic/assets/global/plugins/bootstrap-daterangepicker/moment.min.js"></script>
	<script type="text/javascript" src="/themes/metronic/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
	<script type="text/javascript" src="/themes/metronic/assets/global/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
	<script type="text/javascript" src="/themes/metronic/assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
	<!-- END PAGE LEVEL PLUGINS -->
	<!-- BEGIN PAGE LEVEL SCRIPTS -->
	<script src="/themes/metronic/assets/global/scripts/metronic.js" type="text/javascript"></script>
	<script src="/themes/metronic/assets/admin/layout/scripts/layout.js" type="text/javascript"></script>
	<script src="/themes/metronic/assets/admin/layout/scripts/quick-sidebar.js" type="text/javascript"></script>
	<script src="/themes/metronic/assets/admin/pages/scripts/index.js" type="text/javascript"></script>
	<script src="/themes/metronic/assets/admin/pages/scripts/components-pickers.js"></script>
	<script src="/js/jquery.table2excel.js"></script>
	<script>
		function exportToExcel(table){
			jQuery(table).table2excel({
				name: "EquipmentUpTime"+<?php echo date('Ymdhis'); ?>,
				filename: "EquipmentUpTime"+<?php echo date('Ymdhis'); ?> //do not include extension
			});
		}
	</script>
	<script>
		jQuery(document).ready(function() {
			Metronic.init(); // init metronic core components
			Layout.init(); //
			ComponentsPickers.init();
		});
	</script>
	<!-- END JAVASCRIPTS -->

	</body>

</html>