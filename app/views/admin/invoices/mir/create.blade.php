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
        <!-- BEGIN PAGE CONTENT-->
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="portlet box blue-hoki ">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-reorder"></i> Add New MIR Coupon
                        </div>
                        {{ Form::button('<span>Save </span><i class="glyphicon glyphicon-save"></i>', array('form'=>'update-form', 'type' => 'submit', 'class' => 'btn red pull-right'))}}
                    </div>
                    <div class="portlet-body">
                        {{ Form::open(['route'=>['admin.coupons.mir.store'], 'class'=>'form-horizontal', 'role'=>'form', 'id'=>'update-form', 'method' => 'post', 'autocomplete'=>'off']) }}
                        <div class="form-body">
                            <div class="form-group">
                                {{ Form::label('name', 'Coupon Name: ', ['class' => 'col-md-2 control-label']) }}
                                <div class="col-md-10">
                                    {{ Form::text('name', null, ['class'=>'form-control']) }}
                                </div>
                            </div>
                            <div class="form-group">
                                {{ Form::label('description', 'Description: ', ['class' => 'col-md-2 control-label']) }}
                                <div class="col-md-10">
                                    {{ Form::text('description', null, ['class'=>'form-control', 'autocomplete'=>'off']) }}
                                </div>
                            </div>
                            <div class="form-group">
                                {{ Form::label('expires', 'Expires: ', ['class' => 'col-md-2 control-label']) }}
                                <div class="col-md-3">
                                    {{ Form::text('expires', null, ['class'=>'form-control form-control-inline input-medium date-picker', 'autocomplete'=>'off']) }}
                                </div>
                            </div>
                            <div class="form-group">
                                {{ Form::label('receive_by', 'Receive By: ', ['class' => 'col-md-2 control-label']) }}
                                <div class="col-md-3">
                                    {{ Form::text('receive_by', null, ['class'=>'form-control form-control-inline input-medium date-picker', 'autocomplete'=>'off']) }}
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">Active: </label>
                                <div class="radio-list col-md-10">
                                    <label class="radio-inline">
                                        {{ Form::radio('active', '1', true, ['class'=>'radio-inline']) }} Yes
                                        {{ Form::radio('active', '0', false, ['class'=>'radio-inline', 'style'=>'margin-left: -9px;']) }} No
                                </div>
                            </div>
                            <div class="form-group">
                                {{ Form::label('owner_id', 'Program Owner: ', ['class' => 'col-md-2 control-label']) }}
                                <div class="col-md-10">
                                    {{ Form::select('owner_id', $users, null, ['class'=>'form-control']) }}
                                </div>
                            </div>
                            <div class="form-group">
                                {{ Form::label('brand_id', 'Brand: ', ['class' => 'col-md-2 control-label']) }}
                                <div class="col-md-10">
                                    {{ Form::select('brand_id', $brands, null, ['class'=>'form-control']) }}
                                </div>
                            </div>
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@stop