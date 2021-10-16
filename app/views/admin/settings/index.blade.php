@extends('layouts.default')

@section('content')
    <div class="page-content-wrapper">
        <div class="page-content">
            <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
            <div class="modal fade" id="portlet-config" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 class="modal-title">Modal title</h4>
                        </div>
                        <div class="modal-body">
                            Widget settings form goes here
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn blue">Save changes</button>
                            <button type="button" class="btn default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->
            <!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
            <!-- BEGIN PAGE HEADER-->
            <div class="row">
                <div class="col-md-12">
                    <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                    <h3 class="page-title">
                        Settings
                    </h3>

                    <!-- END PAGE TITLE & BREADCRUMB-->
                </div>
            </div>
            <!-- END PAGE HEADER-->
            <!-- BEGIN PAGE CONTENT-->
            <!-- BEGIN DASHBOARD STATS -->
            <form method="post" action="/admin/submit/form" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-4">
                        <label>Upload Logo</label>
                        <input type="file" name="file" class="form-control">
                    </div>
                </div>
                    <br>
                    <br>
                <button type="submit" name="submit" class="btn btn-success">Submit</button>
            </form>
            <br />
            <br />
            {{ Form::open(['route'=>['admin.stateValidState'], 'enctype'=>"multipart/form-data",'class'=>'form-horizontal', 'role'=>'form', 'id'=>'update-states', 'method' => 'post', 'autocomplete'=>'off']) }}
           
               
                    <div class="container mt-2">
                        <div class="row">
                            <div class="col-md-4">
                            <div class="col-md-12"><label>States</label></div>
                                <div class="form-group">
                                    {{ Form::label('valid_states', 'Valid States: ', ['class' => 'col-md-3 control-label']) }}
                                    <div class="col-md-9">
                                    {{ Form::select('valid_states[]',$states, $validStates, ['class'=>'form-control','multiple','id'=>'validStates']) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">  
                            <div class="col-md-12">              
                                <button type="submit" name="submit" class="btn btn-success">Submit</button>
                            </div>                    
                        </div>
                    </div>
                {{ Form::close() }}
            <!-- END DASHBOARD STATS -->
            <!-- END PAGE CONTENT-->
        </div>
    </div>
@stop