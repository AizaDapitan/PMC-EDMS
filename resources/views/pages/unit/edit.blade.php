@extends('layouts.app')

@section('pageCSS')

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

    <link href="/themes/metronic/assets/global/plugins/nouislider/jquery.nouislider.css" rel="stylesheet" type="text/css"/>


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

@endsection

@section('content')

    <div class="row">

        @if(session()->has('message'))
            <div class="col-md-12">

                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
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

        <div class="col-md-12">

            
            <h3 class="page-title">
                EDMS <small>Edit Unit</small>
            </h3>

        </div>

    </div>

    <div class="col-md-6 col-sm-12">
        
        <form role="FORM" method="POST" action="/unit/{{$unit_selected->id}}">
            @csrf
            @method('PATCH')


            <div class="form-group @error('name') has-error @enderror">

                <label for=""> Description <span style="color: red;">*</span></label>
                <input type="text" class="form-control" name="name" value="{{ $unit_selected->name }}">

                @error('name')
                    <span for="name" class="help-block">{{ $message }}</span>
                @enderror

            </div>


            <div class="form-group @error('type') has-error @enderror">

                <label for=""> Category <span style="color: red;">*</span></label>
                <select class="form-control" name="type">

                    @foreach( $units->groupBy('type') as $key => $unit )
                        @if( $unit_selected->type == $key )
                            <option value="{{$key}}" selected>{{ $key }} </option>
                        @else
                            <option>{{ $key }} </option>
                        @endif
                    @endforeach
                </select>

                @error('type')
                    <span for="type" class="help-block">{{ $message }}</span>
                @enderror

            </div>

            <div class="form-group @error('location') has-error @enderror">

                <label for=""> Location <span style="color: red;">*</span></label>
                <select class="form-control" name="location">
                    @foreach( $units->groupBy('location') as $key => $unit )
                        @if( $unit_selected->location == $key )
                            <option value="{{$key}}" selected>{{ $key }} </option>
                        @else
                            <option>{{ $key }} </option>
                        @endif
                    @endforeach

                    @error('location')
                        <span for="location" class="help-block">{{ $message }}</span>
                    @enderror

                </select>

            </div>

            <button class="btn btn-primary"> Update Unit </button>

        </form>

    </div>

    <div class="clearfix"></div>

@endsection

@section('pageJS')
    
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
    <script src="/themes/metronic/assets/global/plugins/bootbox/bootbox.min.js" type="text/javascript"></script>

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

@endsection
