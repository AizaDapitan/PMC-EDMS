@extends('layouts.app')
@section('content')
<div class="breadcrumbs">
        <h1>Role</h1>
        
        <ol class="breadcrumb">
            <li><a href="{{ route('home') }}">Home</a></li>            
            <li class="active">Role</li>
        </ol>
    </div>
    <div class="page-content-container">
        <div class="page-content-row">                         
            <div class="page-content-col">
                <!-- BEGIN PAGE BASE CONTENT -->
                <div class="row">
                    <div class="col-md-5">
                        <!-- BEGIN SAMPLE FORM PORTLET-->
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
                        <div class="portlet light bordered">

                            <!-- <div class="portlet-title">
                                <div class="caption font-red-sunglo">
                                    <i class="fa fa-list-alt font-red-sunglo"></i>
                                    <span class="caption-subject bold uppercase"> Role Creation / Updation Form</span>
                                </div>
                            </div> -->

                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="icon-equalizer font-green"></i>
                                    <span class="caption-subject font-green sbold uppercase">Create a Role / Update Form</span>
                                </div>
                            </div>                            
                            
                            <div class="portlet-body">
                                <div class="tab-content">
                                    <!-- PERSONAL INFO TAB -->
                                    <div class="tab-pane active">
                                        <form id="form" role="form" action="{{ route('pages.roles.store') }}" method="POST">
                                            @csrf

                                            <input type="hidden" name="_method" id="method" value="POST">
                                            <input type="hidden" name="id" id="id" value="">     
                                            @if($activateDeactivate)
                                            <input type="checkbox" name="active" id="active"> Active
                                            @else
                                            <input disabled type="checkbox" name="active" id="active"> Active
                                            @endif
                                            
                                            <div class="form-group col-md-12">
                                                <div class="portlet light bordered">
                                                    <div class="portlet-body form">                                                        
                                                        <label class="control-label">Role</label><i class="font-red"> *</i>
                                                        <input required type="text" placeholder="Role" name="role" id="role" class="form-control"/>
                                                    </div>
                                                </div>
                                                <div class="portlet light bordered">
                                                    <div class="portlet-body form">                                                        
                                                        <label class="control-label">Description</label><i class="font-red"> *</i>
                                                        <input required type="text" placeholder="Description" name="description" id="description" class="form-control"/>
                                                    </div>
                                                </div>
                                            </div>
                                                
                                            
                                            <div style="text-align: right;">
                                                <a class="btn btn-circle default" href="javascript:;" id="cancel"><i class="fa fa-backward"></i> Back</a>

                                                @if($create)
                                                <button type="submit" class="btn btn-circle blue" id="submit"><span class="glyphicon glyphicon-send"></span> Submit</button>
                                                @else
                                                <button disabled type="submit" class="btn btn-circle blue" id="submit"><span class="glyphicon glyphicon-send"></span> Submit</button>
                                                @endif

                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <!-- END SAMPLE FORM PORTLET-->                                                                              
                    </div>
                                    <div class="col-md-7">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                                                <div class="portlet light bordered">

                                                    <!-- <div class="portlet-title">
                                                        <div class="caption font-dark">
                                                            <i class="fa fa-users font-dark"></i>
                                                            <span class="caption-subject bold uppercase"> Roles List</span>
                                                        </div>
                                                        <div class="tools"> </div>
                                                    </div> -->

                                                    <div class="portlet-title">
                                                        <div class="caption">
                                                            <i class="icon-user font-green"></i>
                                                            <span class="caption-subject font-green sbold uppercase"> Manage Roles </span>
                                                        </div>
                                                    </div>                                                    

                                                    <div class="portlet-body">
                                                        <table class="table table-striped table-bordered table-hover" id="sample_1">
                                                            <thead>
                                                                <tr>
                                                                    <!-- <th>Id</th>  -->
                                                                    <th>Role</th>                             
                                                                    <th>Description</th>
                                                                    <th>Status</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tfoot>
                                                                <tr>
                                                                    <!-- <th>Id</th>  -->
                                                                    <th>Role</th>                             
                                                                    <th>Description</th>
                                                                    <th>Status</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </tfoot>
                                                            <tbody>
                                                                @foreach ($roles as $role)
                                                                    <tr>
                                                                        <!-- <td>{{ $role['id']  }}</td> -->
                                                                        <td>{{ strtoupper($role['name']) }}</td>
                                                                        <td>{{ strtoupper($role['description']) }}</td>                                                                        
                                                                        <td> 
                                                                            @if($role['active'])
                                                                            <i class="font-black"> Active</i>
                                                                            @else
                                                                            <i class="font-red"> Inactive</i>
                                                                            @endif
                                                                        </td>
                                                                       
                                                                        <td class="text-center">
                                                                            @if($edit)
                                                                             <!-- <a onclick="getRoleDetails({!! $role['id'] !!})" data-toggle="modal" class="btn btn-circle blue"><i class="fa fa-edit"></i> Edit</a>  -->
                                                                             <a onclick="getRoleDetails({!! $role['id'] !!})" data-toggle="modal" class="btn btn-sm green btn-outline filter-submit margin-bottom"><i class="fa fa-edit"></i> Edit</a>
                                                                            @else
                                                                            <a class="btn btn-sm grey btn-outline filter-submit margin-bottom"><i class="fa fa-edit"></i> Edit</a>
                                                                            @endif

                                                                            <!-- @if($delete)                                                                            
                                                                            <a data-toggle="modal" class="btn btn-sm red btn-outline filter-cancel" href="#remove{{ $role['id' ]}}"><i class="fa fa-times"></i> Remove</a>
                                                                            @else
                                                                            <a class="btn btn-sm grey btn-outline filter-cancel" ><i class="fa fa-times"></i> Remove</a>
                                                                            @endif -->

                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <!-- END EXAMPLE TABLE PORTLET-->                                                                                
                                </div>
                            </div>                                                                                                                                                  
                        </div>
                    </div>                              
                    <!-- END PAGE BASE CONTENT -->
                </div>
            </div>
        </div>
        <!-- END SIDEBAR CONTENT LAYOUT -->
        
        @foreach($roles as $role)
        <div class="modal fade" id="remove{{ $role['id'] }}" tabindex="-1" role="basic" aria-hidden="true">
                <div class="modal-dialog">

                    <form action="{{ route('pages.roles.destroy', $role['id']) }}" method="POST">
                        @csrf
                        <!-- @method('DELETE') -->
                                            
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <h4 class="modal-title"><b>Confirmation</b></h4>
                            </div>
                            <div class="modal-body"> 
<!--                                          
                            <input type="checkbox" name="assigneduser" id="assigneduser"> Assigned User/s
                            <input type="checkbox" name="withpermission" id="withpermission"> With Permission -->
                             </br>
                            Are you sure you want to <b>Remove</b> this role? </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-circle dark btn-outline" data-dismiss="modal">Close</button>
                                <button type="submit" name="remove" class="btn btn-circle red"><span class="fa fa-trash"></span> Remove</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        @endforeach
@stop
@section('scripts')
	<script>
		$(document).ready(function(){
            $('#cancel').hide();

            document.getElementById('active').checked = true;
			$('#cancel').click(function() {
				$(this).hide();
                document.getElementById('active').checked = true;
                $('#role').val('');
                $('#description').val('');
                $('#method').val('POST');
                $('#form').attr('action', '{{ route('pages.roles.store') }}');
                $('#submit').html('<span class="glyphicon glyphicon-pushpin"></span> Submit');
			});
        });

		function getRoleDetails(id) {
			$.ajax({
                url: '{!! route('pages.roles.edit') !!}',
                type: 'POST',
                async: false,
                dataType: 'json',
                data:{
                    _token: '{!! csrf_token() !!}',
                    id: id
                },
                success: function(response){
                    $('#cancel').show();
                    if (response.active == "1"){
                        
                    document.getElementById('active').checked = true;
			        //$('#active').attr("checked",true);
                    }
                    else
                    {
                    document.getElementById('active').checked = false;
			       // $('#active').attr("checked",false);
                    }
                    $('#role').val(response.name);
                    $('#id').val(id);
                    $('#description').val(response.description);                    
                    $('#method').val('PUT');
                    $('#form').attr('action', '{{ route('pages.roles.update') }}');
                    $('#submit').html('<span class="glyphicon glyphicon-edit"></span> Update');
                }
            });
		}
	</script>
@stop