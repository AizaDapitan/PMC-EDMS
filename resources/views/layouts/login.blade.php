<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
	    <meta charset="utf-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1">

	    <!-- CSRF Token -->
	    <meta name="csrf-token" content="{{ csrf_token() }}">

	    <title>{{ config('app.name', 'Laravel') }}</title>

	    <link href="{{ asset('themes/metronic/assets/global/plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css"/>
		<link href="{{ asset('themes/metronic/assets/global/plugins/simple-line-icons/simple-line-icons.min.css') }}" rel="stylesheet" type="text/css"/>
		<link href="{{ asset('themes/metronic/assets/global/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
		<link href="{{ asset('themes/metronic/assets/global/plugins/uniform/css/uniform.default.css') }}" rel="stylesheet" type="text/css"/>
		<link href="{{ asset('themes/metronic/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css') }}" rel="stylesheet" type="text/css"/>
		<!-- END GLOBAL MANDATORY STYLES -->
		<!-- BEGIN PAGE LEVEL STYLES -->
		<link href="{{ asset('themes/metronic/assets/global/plugins/select2/select2.css') }}" rel="stylesheet" type="text/css"/>
		<link href="{{ asset('themes/metronic/assets/admin/pages/css/login-soft.css') }}" rel="stylesheet" type="text/css"/>
		<!-- END PAGE LEVEL SCRIPTS -->
		<!-- BEGIN THEME STYLES -->
		<link href="{{ asset('themes/metronic/assets/global/css/components.css') }}" rel="stylesheet" type="text/css"/>
		<link href="{{ asset('themes/metronic/assets/global/css/plugins.css') }}" rel="stylesheet" type="text/css"/>
		<link href="{{ asset('themes/metronic/assets/admin/layout/css/layout.css') }}" rel="stylesheet" type="text/css"/>
		<link id="style_color" href="{{ asset('themes/metronic/assets/admin/layout/css/themes/default.css') }}" rel="stylesheet" type="text/css"/>
		<link href="{{ asset('themes/metronic/assets/admin/layout/css/custom.css') }}" rel="stylesheet" type="text/css"/>

		<link rel="shortcut icon" href="favicon.ico"/>

	</head>

	<body>

		 <div class="login" style="background-color: transparent !important;">
        
	        <div class="logo" style="opacity: 0;">
	            <a href="index.php">
	                <img src="{{ asset('themes/metronic/assets/admin/layout/img/logo.png') }}" alt=""/>
	            </a>
	        </div>

	        <div class="content">
				@yield('content')
			</div>

			<div class="copyright">
	             <b>{{ date('Y') }} &copy; Philsaga Mining Corp.</b>
	        </div>

	    </div>

		<script src="{{ asset('themes/metronic/assets/global/plugins/jquery-1.11.0.min.js') }}" type="text/javascript"></script>
		<script src="{{ asset('themes/metronic/assets/global/plugins/jquery-migrate-1.2.1.min.js') }}" type="text/javascript"></script>
		<!-- IMPORTANT! Load jquery-ui-1.10.3.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
		<script src="{{ asset('themes/metronic/assets/global/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js') }}" type="text/javascript"></script>
		<script src="{{ asset('themes/metronic/assets/global/plugins/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
		<script src="{{ asset('themes/metronic/assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js') }}" type="text/javascript"></script>
		<script src="{{ asset('themes/metronic/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js') }}" type="text/javascript"></script>
		<script src="{{ asset('themes/metronic/assets/global/plugins/jquery.blockui.min.js') }}" type="text/javascript"></script>
		<script src="{{ asset('themes/metronic/assets/global/plugins/jquery.cokie.min.js') }}" type="text/javascript"></script>
		<script src="{{ asset('themes/metronic/assets/global/plugins/uniform/jquery.uniform.min.js') }}" type="text/javascript"></script>
		<script src="{{ asset('themes/metronic/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}" type="text/javascript"></script>
		<!-- END CORE PLUGINS -->
		<!-- BEGIN PAGE LEVEL PLUGINS -->
		<script src="{{ asset('themes/metronic/assets/global/plugins/jquery-validation/js/jquery.validate.min.js') }}" type="text/javascript"></script>
		<script src="{{ asset('themes/metronic/assets/global/plugins/backstretch/jquery.backstretch.min.js') }}" type="text/javascript"></script>
		<script type="text/javascript" src="{{ asset('themes/metronic/assets/global/plugins/select2/select2.min.js') }}"></script>
		<!-- END PAGE LEVEL PLUGINS -->
		<!-- BEGIN PAGE LEVEL SCRIPTS -->
		<script src="{{ asset('themes/metronic/assets/global/scripts/metronic.js') }}" type="text/javascript"></script>
		<script src="{{ asset('themes/metronic/assets/admin/layout/scripts/layout.js') }}" type="text/javascript"></script>
		<script src="{{ asset('themes/metronic/assets/admin/layout/scripts/quick-sidebar.js') }}" type="text/javascript"></script>
		<script src="{{ asset('themes/metronic/assets/admin/pages/scripts/login-soft.js') }}" type="text/javascript"></script>

		<script>
			jQuery(document).ready(function() {     
			  	Metronic.init(); // init metronic core components
				Layout.init(); // init current layout
				QuickSidebar.init() // init quick sidebar
			  	Login.init();

		       	// init background slide images
		       	$.backstretch([
			        "{{ asset('themes/metronic/assets/admin/pages/media/bg/1.jpg') }}",
	    		    "{{ asset('themes/metronic/assets/admin/pages/media/bg/2.jpg') }}",
	    		    "{{ asset('themes/metronic/assets/admin/pages/media/bg/3.jpg') }}",
	    		    "{{ asset('themes/metronic/assets/admin/pages/media/bg/4.jpg') }}",
	    		    //"metronic/assets/admin/pages/media/bg/5.jpg",
	    		    //"metronic/assets/admin/pages/media/bg/6.jpg"
			        ], {
			          fade: 1000,
			          duration: 8000
			    	}
			    );
			});
		</script>

	</body>

</html>