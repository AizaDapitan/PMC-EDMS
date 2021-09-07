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

        <div class="col-md-12">
            <!-- BEGIN PAGE TITLE & BREADCRUMB-->
            <h3 class="page-title">
            EDMS <small>Asset Management</small>
            </h3>

        </div>

    </div>

    <div class="row ">

        <div class="col-md-8 col-md-offset-2">
            
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
            
            <div class="portlet box green-haze">
                
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-pencil"></i>Edit an Asset
                    </div>
                    <div class="actions">                               
                        <a class="btn btn-default btn-sm" href="/assets"><i class="fa fa-bars"></i> Asset List</a>                            
                    </div>                                                                                  
                </div>

                <div class="portlet-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form action="/asset/{{$asset->id}}" method="post" class="form-horizontal">
                                @csrf
                                @method('PATCH')

                                <div class="form-group">
                                    <label class="col-md-3 control-label">Tag No <span style="color: red;">*</span></label>
                                    <div class="col-md-9 @error('tag') has-error @enderror">
                                        <input type="text" class="form-control" name="tag" value="{{ $asset->tag }}">
                                        @error('tag')
                                            <span for="tag" class="help-block">{{ $message }}</span>
                                        @enderror                              
                                    </div>
                                </div> 

                                <div class="form-group">
                                    <label class="col-md-3 control-label">Asset Type <span style="color: red;">*</span></label>
                                    <div class="col-md-9 @error('asset_type') has-error @enderror">
                                        <input type="text" class="form-control" name="asset_type" value="{{ $asset->asset_type }}">
                                        @error('asset_type')
                                            <span for="asset_type" class="help-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-3 control-label">Description <span style="color: red;">*</span></label>
                                    <div class="col-md-9 @error('description') has-error @enderror">
                                        <input type="text" class="form-control" name="description" value="{{ $asset->description }}">
                                        @error('description')
                                                <span for="description" class="help-block">{{ $message }}</span>
                                        @enderror   
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-3 control-label">Manufacturer <span style="color: red;">*</span></label>
                                    <div class="col-md-9 @error('manufacturer') has-error @enderror">
                                        <input type="text" class="form-control" name="manufacturer" value="{{ $asset->manufacturer}}">
                                        @error('manufacturer')
                                            <span for="manufacturer" class="help-block">{{ $message }}</span>
                                        @enderror                                 
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-3 control-label">Model <span style="color: red;">*</span></label>
                                    <div class="col-md-9 @error('model') has-error @enderror">
                                        <input type="text" class="form-control" name="model" value="{{ $asset->model }}">
                                        @error('model')
                                            <span for="model" class="help-block">{{ $message }}</span>
                                        @enderror                                  
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-3 control-label">Serial No <span style="color: red;">*</span></label>
                                    <div class="col-md-9 @error('serial') has-error @enderror">
                                        <input type="text" class="form-control" name="serial" value="{{ $asset->serial }}">
                                        @error('serial')
                                            <span for="serial" class="help-block">{{ $message }}</span>
                                        @enderror                                       
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-3 control-label">Year Manufactured <span style="color: red;">*</span></label>
                                    <div class="col-md-9 @error('year_manufactured') has-error @enderror">
                                        <select class="form-control" name="year_manufactured">
                                            @for( $x = 1990; $x < 2100; $x++ )
                                                @if( $x == $asset->year_manufactured )
                                                    <option value="{{ $x }}" selected> {{ $x }} </option> 
                                                @else
                                                    <option value="{{ $x }}"> {{ $x }} </option>                                        
                                                @endif                                                                                       
                                            @endfor
                                        </select>
                                        @error('year_manufactured')
                                            <span for="year_manufactured" class="help-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-3 control-label">Commissioning Date <span style="color: red;">*</span></label>
                                    <div class="col-md-9 @error('commissioning_date') has-error @enderror">
                                        <input type="date" class="form-control" name="commissioning_date" 
                                            value="{{ \Carbon\Carbon::parse($asset->commissioning_date)->format('Y-m-d') }}">
                                        @error('commissioning_date')
                                            <span for="commissioning_date" class="help-block">{{ $message }}</span>
                                        @enderror                                       
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-3 control-label">Site <span style="color: red;">*</span></label>
                                    <div class="col-md-9 @error('site') has-error @enderror">
                                        <select class="form-control" name="site">
                                            @foreach( $site_options as $site )
                                                @if( $site == $asset->site )
                                                    <option value="{{ $site }}" selected> {{ $site }} </option>
                                                @else
                                                    <option value="{{ $site }}"> {{ $site }} </option>
                                                @endif
                                            @endforeach
                                        </select>   
                                        @error('site')
                                            <span for="site" class="help-block">{{ $message }}</span>
                                        @enderror     
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-3 control-label">Location <span style="color: red;">*</span></label>
                                    <div class="col-md-9 @error('location') has-error @enderror">
                                        <select class="form-control" name="location">
                                            @foreach( $locations as $location )
                                                @if( $location == $asset->location )
                                                    <option value="{{ $location }}" selected>{{ $location }}</option>
                                                @else
                                                    <option value="{{ $location }}">{{ $location }}</option>
                                                @endif  
                                            @endforeach                                           
                                        </select>  
                                        @error('location')
                                            <span for="location" class="help-block">{{ $message }}</span>
                                        @enderror                                         
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-3 control-label">Condition <span style="color: red;">*</span></label>
                                    <div class="col-md-9">
                                        <select class="form-control" name="condition">
                                            @foreach( $conditions as $condition )
                                                @if( $condition == $asset->condition )
                                                    <option value="{{ $condition }}" selected>{{ $condition }}</option>
                                                @else
                                                    <option value="{{ $condition }}">{{ $condition }}</option>
                                                @endif  
                                            @endforeach  
                                        </select>       
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-3 control-label">Status <span style="color: red;">*</span></label>
                                    <div class="col-md-9 @error('status') has-error @enderror">
                                        <select class="form-control" name="status">
                                            @foreach( $statuses as $status )
                                                @if( $status == $asset->status )
                                                    <option value="{{ $status }}" selected>{{ $status }}</option>
                                                @else
                                                    <option value="{{ $status }}">{{ $status }}</option>
                                                @endif  
                                            @endforeach  
                                        </select> 
                                        @error('status')
                                            <span for="status" class="help-block">{{ $message }}</span>
                                        @enderror       
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-3 control-label">Vendor</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="vendor" value="{{ $asset->vendor }}">  
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-3 control-label">P.O. Reference</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="po_reference" value="{{ $asset->po_reference }}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-3 control-label">P.O. Value</label>
                                    <div class="col-md-9">
                                        <input type="number" step="0.01" min="0.00" value="{{ $asset->po_value }}" class="form-control" name="po_value">                                     
                                    </div>
                                </div>

                                <div class="form-actions fluid">
                                    <div class="col-md-offset-9 col-md-3">
                                        <button type="submit" class="btn green">Update Asset</button>
                                        <a class="btn default" href="/assets">Cancel</a>
                                    </div>
                                </div>

                            </form> 

                        </div>

                    </div>
                                
                </div>
            </div>
        </div>              
    </div>

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
    <script>

        jQuery(document).ready(function() {    
            
                Metronic.init(); // init metronic core components
                Layout.init(); // init current layout
               
                $('[data-toggle="popover"]').popover(); 
                
                Index.init();
                ComponentsPickers.init();

        });

    </script>

@endsection
