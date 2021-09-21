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

    <style type="text/css">
        .static_width {
            display: block;
            width: 375px;
        }
    </style>

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

            <!-- input modal --->
                @include('modals.input-downtime-modal')
                @include('modals.new-unit-modal')
            <!-- end input modal -->    

            <h3 class="page-title">
                EDMS <small>Availability Records</small>
            </h3>

            <form method="GET" role="form" action="{{ route('home') }}">
                <!--- Filter Display -->
                <ul class="page-breadcrumb breadcrumb">                    
                    <li>                            
                        <a href="#">Filters:</a>                            
                    </li>
                    <li>            
                        
                        <input type="hidden" name="startDate" id="hiddenstart" 
                                value="{{ request()->has('startDate') ? request('startDate') : \Carbon\Carbon::now()->subMonth()->format('Y-m-d') }}">
                        <input type="hidden" name="endDate" id="hiddenend" 
                                value="{{ request()->has('endDate') ? request('endDate') : date('Y-m-d') }}">     
                       <!--  <input type="hidden" name="datetype" value="weekly">   -->

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
                            <option value="" disabled selected> - Category - </option>
                            @foreach($u_type as $key => $value )
                                @if( urldecode(request('s_type')) == $key )
                                    <option value="{{$key}}" selected> {{ $key }} </option>
                                @else
                                    <option value="{{$key}}"> {{ $key }} </option>
                                @endif
                            @endforeach  
                        </select>                                                           
                    </li>

                    <li id="unitlist">
                        <select class="form-control input-sm" name="s_name" id="s_name">
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
                        <button type="submit" class="btn green btn-sm" > Go </button>
                        <a href="{{ url('/dashboard') }}" class="btn purple btn-sm" style="color:white;">Reset</a>

                        <!-- <a href="{{env('APP_URL')}}/dashboard" class="btn purple btn-sm" style="color:white;">Reset</a> -->
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

    <div class="row">               
        
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="dashboard-stat blue-madison" style="height:130px;">
                <div class="visual">
                    <img src="{{env('APP_URL')}}/images/aselco.jpg" alt="" width="150">
                </div>
                <div class="details">
                    <div class="number">
                        {{ $u_type_downtime_total['ASELCO POWER MAIN INCOMER'] }} mins
                    </div>
                    <div class="desc">
                         ASELCO POWER MAIN INCOMER
                    </div>
                </div>
                <a class="more pull-right" href="{{env('APP_URL')}}/dashboard?s_type=ASELCO+POWER+MAIN+INCOMER">
                 View more&nbsp;&nbsp;<i class="m-icon-swapright m-icon-white"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="dashboard-stat red-intense" style="height:130px;">
                <div class="visual">
                    <img src="{{env('APP_URL')}}/images/feeder_breaker.png" alt="" width="130" style="position:relative;top:-30px;">
                </div>
                <div class="details">
                    <div class="number">
                         {{ $u_type_downtime_total['FEEDER BREAKERS'] }} mins
                    </div>
                    <div class="desc">
                         FEEDER BREAKERS
                    </div>
                </div>
                <a class="more pull-right" href="{{env('APP_URL')}}/dashboard?s_type=FEEDER+BREAKERS">
                 View more&nbsp;&nbsp;<i class="m-icon-swapright m-icon-white"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="dashboard-stat green-haze" style="height:130px;">
                <div class="visual">
                    <img src="{{env('APP_URL')}}/images/genset.png" alt="" width="180">
                </div>
                <div class="details">
                    <div class="number">
                         {{ $u_type_downtime_total['GENSET UNITS AND GENSET BREAKERS'] }} mins
                    </div>
                    <div class="desc">
                         GENSET UNITS AND <br> GENSET BREAKERS
                    </div>
                </div>                      
                <a class="more pull-right margin-top-10" href="{{env('APP_URL')}}/dashboard?s_type=GENSET+UNITS+AND+GENSET+BREAKERS">
                 View more <i class="m-icon-swapright m-icon-white"></i>
                </a>
            </div>
        </div>
        
    </div>

    <div class="clearfix"></div>

    <div class="row">   

        <div class="col-md-12">

            <div class="col-md-1"><input id="slider_2_input_startxx" type="text" class="form-control btn red-thunderbird white" value="0 %" name="fromxx" readonly="readonly"><input id="slider_2_input_start" type="hidden" class="form-control btn red-thunderbird white" name="from" readonly="readonly"></div>

            <div class="col-md-10"><div class="noUi-control noUi-danger" id="slider_2"> </div></div>

            <div class="col-md-1"><input id="slider_2_input_endxx" type="text" class="form-control btn green white" name="toxx" value="100 %" readonly="readonly"><input id="slider_2_input_end" type="hidden" class="form-control btn green white" name="to" readonly="readonly"></div>

        </div>

    </div>

    <div class="clearfix"></div>

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
                  
                    <table style="font-size:12px;" class="table table-bordered">
                      
                        <thead>
                            <td width="20%"></td>
                            @foreach( $displayDate as $date ) 
                                @if( request()->has('type') && request()->type == 'daily' )
                                    <td class="text-center"> <strong> {{ $date['start'] }} </strong> </td>
                                @else
                                    <td class="text-center"> <strong> {{ $date['start'] }} - {{ $date['end'] }} </strong> </td>
                                @endif
                            @endforeach
                        </thead>
                        
                        <tbody>
                            @foreach( $units->groupBy('type') as $key => $val )

                                <tr width="20%">
                                    <td class="static_width text-center"><h4> <strong style="color: blue;">{{ $key }} </strong></h4></td>
                                </tr>
                                @foreach( $val->groupBy('location') as $key1 => $val1 )
                                
                                    <tr>
                                        <td class="static_width text-center"><h5><strong> {{ $key1 }} </strong></h5></td>
                                    </tr>

                                    @foreach( $val1 as $unit ) 
                                        <tr>
                                            <td class="text-center static_width"> <a href="#" onclick="window.open('{{env('APP_URL')}}/unit/{{$unit->id}}','displayWindow','toolbar=no,scrollbars=yes,width=800,height=600'); return false;" style="color: #000000;"> {{ $unit->name }} </a> </td>
                                                                                                                                    
                                            @foreach( $displayData as $unit_d_data )

                                                @if( $unit_d_data['unit'] == $unit->id )

                                                    @foreach( $unit_d_data['downtime_data'] as $range_d_data )

                                                        @if( $range_d_data['downtime'] != 0 ) 
                                                            @php 
                                                                $mins = number_format( 100 - ( $range_d_data['downtime'] / $range_d_data['total_time'] ) * 100 );
                                                            @endphp
                                                            <td class="text-center tdtab" style="background: green; color: white;">
                                                                <a href="" onclick="return false;" data-toggle="popover" title="{{$mins}}%" 
                                                                    data-content="{{ $range_d_data['remarks'] }}" data-trigger="hover" style="color:white;" data-placement="top">
                                                                {{ $range_d_data['downtime'] }}mins (<span class="dTime_percentage">{{ $mins  }}
                                                                    </span>%) 
                                                                </a>
                                                            </td>
                                                        @else
                                                            <td class="text-center tdtab" style="background: green; color: white;">
                                                                <a href="" onclick="return false;" data-toggle="popover" title="100%" 
                                                                    data-content="" data-trigger="hover" style="color:white;" data-placement="top">
                                                                    <span class="dTime_percentage">100</span>% 
                                                                </a>
                                                            </td>
                                                        @endif

                                                    @endforeach

                                                @endif

                                            @endforeach

                                        </tr>
                                    @endforeach

                                @endforeach

                            @endforeach

                        </tbody>

                    </table>

                </div>

            </div>

        </div>    

    </div>

    <div class="clearfix"></div>

    <div class="row ">
        
        <div class="col-md-12 col-sm-12">

            <div class="portlet box blue-steel">
                
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-bell-o"></i>Recent Downtime Logs
                    </div>
                    
                </div>

                <div class="portlet-body">
                    
                    <div class="scroller" style="height: 300px;" data-always-visible="1" data-rail-visible="0">
                        
                        <ul class="feeds">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Unit</th>
                                        <th>Start</th>
                                        <th>End</th>
                                        <th>Remarks</th>    
                                        <th>Action</th>                                           
                                    </tr>
                                </thead>
                                <tbody>
                                
                                    @foreach( $downtime as $down ) 
                                        <tr>
                                            <td></td>
                                            <td width="15%">{{ $down->unit? $down->unit->name : 'N/A' }}</td>
                                            <td width="5%">{{ $down->start_date->toFormattedDateString() }} </td>
                                            <td width="5%">{{ $down->end_date->toFormattedDateString() }} </td>
                                            <td width="65%">{{ $down->remarks }} </td>
                                            <td width="10%">
                                                <a href="#" class="btn purple btn-sm" onclick="window.open( '{{ env('APP_URL') }}/downtime/{{$down->id}}','displayWindow','toolbar=no,scrollbars=yes,width=800,height=600'); return false; "                                                                                    
                                                    title="Edit Downtime"><i class="fa fa-edit"></i></a>
                                                <a href="#" class="btn red btn-sm deletedl" data="{{$down->id}}"
                                                    title="Delete Downtime"><i class="fa fa-minus-circle"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>                        
                        </ul>

                    </div>

                    <div class="scroller-footer">
                        <div class="btn-arrow-link pull-right">
                            <a href="/downtime-list" target="_blank">See All Records</a>
                            <i class="icon-arrow-right"></i>
                        </div>
                    </div>

                </div>

            </div>

        </div>              

    </div>

    <div class="clearfix"></div>

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
    <script type="text/javascript"> var unitss = {!! $u_name !!} </script>
    <script type="text/javascript" src="{{env('APP_URL')}}/js/dashboard.js"></script>

    <script>

        jQuery(document).ready(function() {    
            
                Metronic.init(); // init metronic core components
                Layout.init(); // init current layout
               
                $('[data-toggle="popover"]').popover(); 
                
                Index.init();
                Index.initDashboardDaterange();   
                ComponentsPickers.init();
                ComponentsNoUiSliders.init();
                
                $("#slider_2").trigger("change");

                $('.deletedl').click(function(){       
                
                    var x = $(this).attr('data');

                    bootbox.confirm("Are you sure you want to delete this record?", function(result) {
                        
                        if(result){
                            $.ajaxSetup({
                                headers:
                                { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
                            });

                            $.ajax({
                                type:'DELETE',
                                url:"{{env('APP_URL')}}/downtime/"+x  
                            }).done(function(data){
                                location.reload();
                            });
                        }

                    }); 

                });

        });

    </script>
    
@endsection
