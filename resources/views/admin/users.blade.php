@extends('layouts.app')

@section('pageCSS')

<link href="{{env('APP_URL')}}/themes/metronic/assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<link href="{{env('APP_URL')}}/themes/metronic/assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
<link href="{{env('APP_URL')}}/themes/metronic/assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="{{env('APP_URL')}}/themes/metronic/assets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css" />
<link href="{{env('APP_URL')}}/themes/metronic/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
<!-- END GLOBAL MANDATORY STYLES -->

<!-- BEGIN PAGE LEVEL STYLES -->
<link rel="stylesheet" type="text/css" href="{{env('APP_URL')}}/themes/metronic/assets/global/plugins/select2/select2.css" />
<link rel="stylesheet" type="text/css" href="{{env('APP_URL')}}/themes/metronic/assets/global/plugins/datatables/extensions/Scroller/css/dataTables.scroller.min.css" />
<link rel="stylesheet" type="text/css" href="{{env('APP_URL')}}/themes/metronic/assets/global/plugins/datatables/extensions/ColReorder/css/dataTables.colReorder.min.css" />
<link rel="stylesheet" type="text/css" href="{{env('APP_URL')}}/themes/metronic/assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css" />
<!-- END PAGE LEVEL STYLES -->

<!-- BEGIN THEME STYLES -->
<link href="{{env('APP_URL')}}/themes/metronic/assets/global/css/components.css" rel="stylesheet" type="text/css" />
<link href="{{env('APP_URL')}}/themes/metronic/assets/global/css/plugins.css" rel="stylesheet" type="text/css" />
<link href="{{env('APP_URL')}}/themes/metronic/assets/admin/layout/css/layout.css" rel="stylesheet" type="text/css" />
<link id="style_color" href="{{env('APP_URL')}}/themes/metronic/assets/admin/layout/css/themes/default.css" rel="stylesheet" type="text/css" />
<link href="{{env('APP_URL')}}/themes/metronic/assets/admin/layout/css/custom.css" rel="stylesheet" type="text/css" />
<!-- END PAGE LEVEL PLUGIN STYLES -->

<!-- BEGIN PAGE STYLES -->
<link href="{{env('APP_URL')}}/themes/metronic/assets/admin/pages/css/tasks.css" rel="stylesheet" type="text/css" />
<!-- END PAGE STYLES -->

<!-- BEGIN THEME STYLES -->
<link href="{{env('APP_URL')}}/themes/metronic/assets/global/css/components.css" rel="stylesheet" type="text/css" />
<link href="{{env('APP_URL')}}/themes/metronic/assets/global/css/plugins.css" rel="stylesheet" type="text/css" />
<link href="{{env('APP_URL')}}/themes/metronic/assets/admin/layout/css/layout.css" rel="stylesheet" type="text/css" />
<link id="style_color" href="{{env('APP_URL')}}/themes/metronic/assets/admin/layout/css/themes/default.css" rel="stylesheet" type="text/css" />
<link href="{{env('APP_URL')}}/themes/metronic/assets/admin/layout/css/custom.css" rel="stylesheet" type="text/css" />
<!-- END BEGIN THEME STYLES -->

@endsection


@section('content')

@include('layouts.header')

<div class="modal fade" id="basic" tabindex="-1" role="basic" aria-hidden="true">
    <form id="form" role="form" action="{{ route('admin.users.store') }}" method="POST">
        @csrf
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body">

                    <input type="hidden" name="_method" id="method" value="POST">
                    <input type="hidden" name="id" id="id" value="">

                    <label class="control-label" name="activeLabel" id="activeLabel">Status </label>
                    <input type="checkbox" name="active" id="active">

                    <label class="control-label" name="lockLabel" id="lockLabel" style="display: none;"> Lock </label>
                    <input type="checkbox" name="locked" id="locked" style="display: none;">

                    <div class="form-group">
                        <label class="control-label">First Name <span class="required" aria-required="true"> * </span></label>
                        <input type="text" name="firstname" id="firstname" class="form-control" placeholder="Enter first name" required>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Last Name <span class="required" aria-required="true"> * </span></label>
                        <input type="text" class="form-control" name="lastname" id="lastname" placeholder="Enter last name" required>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Email Address <span class="required" aria-required="true"> * </span></label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="Enter email address" required>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Username <span class="required" aria-required="true"> * </span></label>
                        <input type="text" class="form-control" name="username" id="username" placeholder="Enter Username" required>
                    </div>
                    <div class="form-group">
                        <label class="control-label">User Role <span class="required" aria-required="true"> * </span></label>
                        <select required name="role_id" id="role_id" class="form-control">
                            @foreach($roles as $role)
                            <option value="{{ $role['id'] }}">{{ $role['name'] }}</option>
                            @endforeach
                        </select>

                    </div>

                    <label style="display: none;" class="control-label" name="resetLabel" id="resetLabel">Reset Password</label>
                    <input style="display: none;" type="checkbox" name="reset" id="reset">
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn default" data-dismiss="modal">Close</button>
                    <input type="submit" class="btn blue" value="Save">
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </form>
</div>

<div class="main">
    <div class="container">
        <div class="col-md-12 tab-style-1">

            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="{{ url('/dashboard') }}">Home</a></li>
                    <li class="active">Users</li>
                </ol>

                <h1>Users</h1>

            </div>
            @if(session('errorMesssage'))
            <div id="errdiv" class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                {!! session('errorMesssage') !!}
            </div>
            @endif

            @if(session('success'))
            <div class="alert alert-success alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                <span class="fa fa-check-square-o"></span>
                {!! session('success') !!}
            </div>
            @endif

            <form method="POST" action="{{ route('admin.users.search') }}" class="mb-5">
                @csrf
                <a class="btn green" data-toggle="modal" href="#basic" onclick="addUser()"> Add User </a>

            </form>
</br>
            <table class="table table-striped table-hover" id="sample_1">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Lock</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr>
                        <td>{{ ucfirst($user->firstname) }} {{ ucfirst($user->lastname) }}</td>
                        <td>{{ $user->username }} </td>
                        <td>{{ $user->email }} </td>
                        <td>{{ $user->role }} </td>
                        <td>
                            @if($user->active)
                            <i class="font-blue"> Active</i>
                            @else
                            <i class="font-red"> Inactive</i>
                            @endif
                        </td>
                        <td>
                            @if(!$user->locked)
                            <i class="font-blue"> Unlocked</i>
                            @else
                            <i class="font-red"> Locked</i>
                            @endif
                        </td>

                        <td class="text-center">
                            <button onclick="getUserDetails({!! $user['id'] !!})" class="btn btn-sm blue btn-outline filter-submit margin-bottom" data-toggle="modal" data-target="#basic">
                                <i class="fa fa-edit"></i> Edit</button>
                            <!-- <button class="btn btn-sm blue btn-outline filter-submit margin-bottom">
                                <i class="fa fa-eye"></i> View</button> -->
                            <!-- <button class="btn btn-sm green btn-outline filter-cancel">
                                <i class="fa fa-user-check"></i> Activate</button>
                            <button class="btn btn-sm red btn-outline filter-cancel">
                                <i class="fa fa-user-times"></i> Deactivte</button> -->
                        </td>

                    </tr>
                    @endforeach

                <tbody>
            </table>

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
        document.getElementById('active').checked = true;
    });

    function addUser() {
        $('#username').val('');
        $('#id').val('');
        $('#role_id').val('');
        $('#firstname').val('');
        $('#lastname').val('');
        $('#email').val('');
        $('#method').val('POST');
        $('#form').attr('action', '{{ route('admin.users.store') }}');
        $('#reset').hide();
        $('#resetLabel').hide();
        $('#locked').hide();
        $('#lockLabel').hide();
        document.getElementById('active').checked = true;
    }

    function getUserDetails(id) {
        $.ajax({
            url: '{!! route('admin.users.edit') !!}',
            type: 'POST',
            async: false,
            dataType: 'json',
            data: {
                _token: '{!! csrf_token() !!}',
                id: id
            },
            success: function(response) {
                // if (response.reset == "1")
                // {                    
                // document.getElementById('reset').checked = true;
                // }
                // else
                // {
                // document.getElementById('reset').checked = false;
                // }                
                if (response.active == "1") {
                    document.getElementById('active').checked = true;
                } else {
                    document.getElementById('active').checked = false;
                }
                if (response.locked == "1") {
                    document.getElementById('locked').checked = true;
                } else {
                    document.getElementById('locked').checked = false;
                }
                $('#username').val(response.username);
                $('#role_id').val(response.role_id);
                $('#firstname').val(response.firstname);
                $('#lastname').val(response.lastname);
                $('#email').val(response.email);
                $('#id').val(id);
                $('#method').val('PUT');
                $('#form').attr('action', '{{ route('admin.users.update') }}');
                $('#reset').show();
                $('#resetLabel').show();
                $('#locked').show();
                $('#lockLabel').show();
            }
        });
    }
</script>
@endsection