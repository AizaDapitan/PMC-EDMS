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

<div class="main">
    <div class="container">
        <div class="col-md-12 tab-style-1">

            <div class="breadcrumbs">                
                <ol class="breadcrumb">
                    <li><a href="{{ url('/dashboard') }}">Home</a></li>
                    <li class="active">User Access Rights</li>
                </ol>

                <h1>User Access Rights</h1>
                
            </div>
            @if (count($errors) > 0)
            <div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                <ul class="nav">
                    @foreach ($errors->all() as $error)
                    <li><span class="fa fa-exclamation"></span>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            @if(session('success'))
            <div class="alert alert-success alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                <span class="fa fa-check-square-o"></span>
                {!! session('success') !!}
            </div>
            @endif
            @if(session('failed'))
            <div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                <span class="a fa-exclamation"></span>
                {!! session('failed') !!}
            </div>
            @endif

            <div class="portlet light portlet-fit portlet-datatable bordered">

                <form id="form" action="{{ route('admin.useraccessrights.store') }}" method="POST">

                    <input type="hidden" id="create" name="create" value="{{ $create }}">
                    <input type="hidden" name="users_permissions" id="users_permissions" value="">
                    @csrf

                    <div class="portlet-title">
                        
                        <div class="actions">
                            <div class="form-group form-inline" style="display:inline;margin-right:10px">
                                <label class="control-label" style="margin-right:20px">User Name </label>
                                
                                    <select required name="userid" id="userid" class="form-control select2">
                                        @foreach($users as $user)
                                        <option value="{{ $user['id'] }}">{{ $user['username'] }}</option>
                                        @endforeach
                                    </select>
                                
                            </div>
                            @if($create)
                                <button type="submit" class="btn blue" id="saveUserPermission">
                                    <i class="fa fa-save"></i>&nbsp; Save Changes
                                </button>
                            @else
                                <button disabled type="submit" class="btn blue" id="saveUserPermission">
                                    <i class="fa fa-save"></i>&nbsp; Save Changes
                                </button>
                            @endif
                        </div>
                    </div>                     
                    
                    <div class="portlet-body">
                        <div class="table-scrollable">
                            <table class="table table-hover" style="width:100%;">
                                <thead class="thead-light">
                                    <tr class="green">
                                        <th>Permission List</th>
                                        <th>View</th>
                                        <th>Create</th>
                                        <th>Update</th>
                                        <th>Print</th>
                                        <th>Upload</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($modules as $module)
                                    <tr>
                                        <td width="50%">
                                            <div class="caption custom-padding">
                                                <span class="caption-subject font-green bold uppercase">{{ strtoupper($module['description'])}}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="md-checkbox custom-padding">
                                                <input type="checkbox" class="md-check" data-role="{{$module['id']}}_view" data-module="{{$module['id']}}_view" onclick="checkPermission(this.id)" id="{{$module['id']}}_view">
                                                <label for="{{$module['id']}}_view">
                                                    <span></span>
                                                    <span span class="check"></span>
                                                    <span class="box"></span>
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="md-checkbox custom-padding">
                                                <input type="checkbox" class="md-check" data-role="{{$module['id']}}_create" data-module="{{$module['id']}}_create" onclick="checkPermission(this.id)" id="{{$module['id']}}_create">
                                                <label for="{{$module['id']}}_create">
                                                    <span></span>
                                                    <span span class="check"></span>
                                                    <span class="box"></span>
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="md-checkbox custom-padding">
                                                <input type="checkbox" class="md-check" data-role="{{$module['id']}}_edit" data-module="{{$module['id']}}_edit" id="{{$module['id']}}_edit" onclick="checkPermission(this.id)">
                                                <label for="{{$module['id']}}_edit">
                                                    <span></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span>
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="md-checkbox custom-padding">
                                                <input type="checkbox" class="md-check" data-role="{{$module['id']}}_print" data-module="{{$module['id']}}_print" id="{{$module['id']}}_print" onclick="checkPermission(this.id)">
                                                <label for="{{$module['id']}}_print">
                                                    <span></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span>
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="md-checkbox custom-padding">
                                                <input type="checkbox" class="md-check" data-role="{{$module['id']}}_upload" data-module="{{$module['id']}}_upload" id="{{$module['id']}}_upload" onclick="checkPermission(this.id)">
                                                <label for="{{$module['id']}}_upload">
                                                    <span></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span>
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    @foreach($permissions as $permission)
                                    @if(strtoupper($permission['module_type']) == strtoupper($module['description']) )
                                    <tr>
                                        <td>
                                            {{ strtoupper($permission['description']) }}
                                        </td>
                                        <td>
                                            <div class="md-checkbox">
                                                <input type="checkbox" class="md-check" data-role="{{$permission['id']}}_{{$module['id']}}_view" data-module="{{$permission['id']}}_{{$module['id']}}_view" id="{{$permission['id']}}_{{$module['id']}}_view" onchange="storeID(this.id)">
                                                <label for="{{$permission['id']}}_{{$module['id']}}_view">
                                                    <span></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span>
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="md-checkbox">
                                                <input type="checkbox" class="md-check" data-role="{{$permission['id']}}_{{$module['id']}}_create" data-module="{{$permission['id']}}_{{$module['id']}}_create" id="{{$permission['id']}}_{{$module['id']}}_create" onchange="storeID(this.id)">
                                                <label for="{{$permission['id']}}_{{$module['id']}}_create">
                                                    <span></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span>
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="md-checkbox">
                                                <input type="checkbox" class="md-check" data-role="{{$permission['id']}}_{{$module['id']}}_edit" data-module="{{$permission['id']}}_{{$module['id']}}_edit" id="{{$permission['id']}}_{{$module['id']}}_edit" onchange="storeID(this.id)">
                                                <label for="{{$permission['id']}}_{{$module['id']}}_edit">
                                                    <span></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span>
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="md-checkbox">
                                                <input type="checkbox" class="md-check" data-role="{{$permission['id']}}_{{$module['id']}}_print" data-module="{{$permission['id']}}_{{$module['id']}}_print" id="{{$permission['id']}}_{{$module['id']}}_print" onchange="storeID(this.id)">
                                                <label for="{{$permission['id']}}_{{$module['id']}}_print">
                                                    <span></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span>
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="md-checkbox">
                                                <input type="checkbox" class="md-check" data-role="{{$permission['id']}}_{{$module['id']}}_upload" data-module="{{$permission['id']}}_{{$module['id']}}_upload" id="{{$permission['id']}}_{{$module['id']}}_upload" onchange="storeID(this.id)">
                                                <label for="{{$permission['id']}}_{{$module['id']}}_upload">
                                                    <span></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span>
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    @endif
                                    @endforeach
                                    @endforeach

                                </tbody>
                            </table>

                        </div>

                </form>
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
        $(document).ready(function() {
            getUsersPermissions($("#userid").val());
            $("#userid").on('change', function() {
                getUsersPermissions($("#userid").val());

            })
        });

        function getUsersPermissions(userid) {
            document.querySelectorAll('input[type=checkbox]').forEach(el => el.checked = false)
            $("#users_permissions").val("");
            $.ajax({
                url: '{!! route('admin.useraccessrights.store') !!}',
                type: 'get',
                
                data: {
                    userid: userid
                },
                success: function(data) {
                    $.each(data, function(index, element) {
                        var chkid = "";
                        chkid = (element.permission_id + "_" + element.module_id + "_" + element.action)
                        if (chkid != "") {
                            document.getElementById(element.module_id + "_" + element.action).checked = true;
                            document.getElementById(chkid).checked = true;

                            storeID(chkid);
                        }
                    });
                }
            });
        }

        function checkPermission(id) {
            var checkboxes = document.getElementsByTagName("input");
            const cb = document.getElementById(id);
            for (var i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i].type == "checkbox") {
                    if (checkboxes[i].id.includes(id)) {
                        document.getElementById(checkboxes[i].id).checked = cb.checked;
                        storeID(checkboxes[i].id);
                    }
                }
            }
        }

        function storeID(id) {
            var users_permissions = $("#users_permissions").val();
            
            if (document.getElementById(id).checked) {
                if (users_permissions != "") {

                    users_permissions = users_permissions + ',' + id;
                } else {

                    users_permissions = id;
                }
            } else {
            if((id.match(/_/g) || []).length == 2)
            {
                    if (users_permissions.includes("," + id)) {
                        users_permissions = users_permissions.replace("," + id, "");
                        console.log(users_permissions);
                    } else if (users_permissions.includes(id + ",")) {
                        users_permissions = users_permissions.replace(id + ",", "");
                        
                        console.log(users_permissions);
                    } else {
                        users_permissions = users_permissions.replace(id, "");
                    }
                }
            }
            $("#users_permissions").val(users_permissions);
        }
</script>
@endsection