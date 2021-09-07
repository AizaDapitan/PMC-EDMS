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
										<font color="blue" size="+1"> Masterlist </font><br>
										{{ date('F d,Y') }}<br>
									</td>
								</tr>
							</table> <br><br>

						</div>

					</div>

					<form method="GET" role="form">

						<div class="row">

							<div class="col-md-12">

								<div class="row">
									
									<div class="col-md-4">
										<div class="form-group">
											<select class="form-control" name="location">
												<option value> -- ALL LOCATION -- </option>
												@foreach( $locations as $key => $location )
													@if( request()->location == $key )
														<option value="{{ $key }}" selected>{{ $key }}</option>
													@else
														<option value="{{ $key }}">{{ $key }}</option>
													@endif
												@endforeach
											</select>
										</div>
									</div>

									<div class="col-md-4">
										<div class="form-group">
											<select class="form-control" name="type">
												<option value> -- ALL TYPES -- </option>
												@foreach( $types as $key => $type )
													@if( request()->type == $key )
														<option value="{{ $key }}" selected>{{ $key }}</option>	
													@else 
														<option value="{{ $key }}">{{ $key }}</option>
													@endif
												@endforeach
											</select>
										</div>
									</div>

									<div class="col-md-2 col-md-offset-2">
										<table width="100%">
											<tr>												
												<td><input type="submit" class="btn green" value="Generate"></td>
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
										$_url = str_replace('/rpt_masterlist', '/rpt_masterlist_print', request()->getRequestUri());
									@endphp

									&nbsp;<a class="btn purple" href="{{$_url}}">Print</a>
								</td>
									
								</tr>

							</table> <br>

							<table width="100%" style="font-style:Arial;font-size:14px;" id="sample_4">
													
								<thead>
									<td>Seq</td>
									<td>Name</td>
									<td>Location</td>
									<td>Type</td>
							 	</thead>	

								<tr><td colspan="5"><hr></td></tr>
										
								<tbody>
									@foreach( $units as $key => $unit )
									<tr style=" background:{{ $key%2 == 0 ? '#ffffff':'#F6F7F6'}}">
										<td>{{ $key + 1 }}</td>
										<td>{{ $unit->name }}</td>
										<td>{{ $unit->location }}</td>
										<td>{{ $unit->type }}</td>
									</tr>
									@endforeach
								</tbody>

							</table>
							
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
				name: "Masterlist"+<?php echo date('Ymdhis'); ?>,
				filename: "Masterlist"+<?php echo date('Ymdhis'); ?> //do not include extension
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