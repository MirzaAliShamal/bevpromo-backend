@extends('layouts.default')

@section('content')
<div class="page-content-wrapper">
    <div class="page-content">
        <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
        <div class="modal fade" id="portlet-config" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
            aria-hidden="true">
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
                            <i class="fa fa-reorder"></i> Edit MIR Coupon
                        </div>
                        {{ Form::button('<span>Save Changes </span><i class="glyphicon glyphicon-save"></i>', array('form'=>'update-form', 'type' => 'submit', 'class' => 'btn red pull-right'))}}
                    </div>
                    <div class="portlet-body">
                        {{ Form::open(['route'=>['admin.coupons.mir.update', $coupon->id], 'class'=>'form-horizontal', 'role'=>'form', 'id'=>'update-form', 'method' => 'put']) }}
                        <div class="form-body">
                            <div class="form-group">
                                {{ Form::label('name', 'Coupon Name: ', ['class' => 'col-md-2 control-label']) }}
                                <div class="col-md-10">
                                    {{ Form::text('name', $coupon->name, ['class'=>'form-control']) }}
                                </div>
                            </div>
                            <div class="form-group">
                                {{ Form::label('description', 'Description: ', ['class' => 'col-md-2 control-label']) }}
                                <div class="col-md-10">
                                    {{ Form::text('description', $coupon->description, ['class'=>'form-control', 'autocomplete'=>'off']) }}
                                </div>
                            </div>
                            <div class="form-group">
                                {{ Form::label('expires', 'Expires: ', ['class' => 'col-md-2 control-label']) }}
                                <div class="col-md-3">
                                    <?php
                                    $dob = date('Y-m-d', strtotime($coupon->expires));
                                    ?>
                                    <input type="date" name="expires" id="expires" value="{{$dob}}" class="form-control form-control-inline input-medium" />
{{--                                    {{ Form::text('expires', $coupon->expires, ['class'=>'form-control form-control-inline input-medium date-picker', 'autocomplete'=>'off']) }}--}}
                                </div>
                            </div>
                            <div class="form-group">
                                {{ Form::label('receive_by', 'Receive By: ', ['class' => 'col-md-2 control-label']) }}
                                <div class="col-md-3">
                                    <?php
                                    $dob = date('Y-m-d', strtotime($coupon->receive_by));
                                    ?>
                                    <input type="date" name="receive_by" id="receive_by" value="{{$dob}}" class="form-control form-control-inline input-medium" />
{{--                                    {{ Form::text('receive_by', $coupon->receive_by, ['class'=>'form-control form-control-inline input-medium date-picker', 'autocomplete'=>'off']) }}--}}
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">Active: </label>
                                <div class="radio-list col-md-10">
                                    <label class="radio-inline">
                                        @if ($coupon->active == 1)
                                        {{ Form::radio('active', '1', true, ['class'=>'radio-inline']) }} Yes
                                        {{ Form::radio('active', '0', false, ['class'=>'radio-inline', 'style'=>'margin-left: -9px;']) }}
                                        No
                                        @else
                                        {{ Form::radio('active', '1', false, ['class'=>'radio-inline']) }} Yes
                                        {{ Form::radio('active', '0', true, ['class'=>'radio-inline', 'style'=>'margin-left: -9px;']) }}
                                        No
                                        @endif
                                </div>
                            </div>
                            <div class="form-group">
                                {{ Form::label('user_id', 'Program Owner: ', ['class' => 'col-md-2 control-label']) }}
                                <div class="col-md-8">
                                    {{ Form::select('user_id', $users, $coupon->user_id, ['class'=>'form-control']) }}
                                </div>
                                <a href="/admin/clients/create" target="_blank" class="btn red control-label"
                                   role="button" style="text-align: center;"><i class="fa fa-plus"></i></a>&nbsp;
                                <a class="btn red control-label" id="btnRefreshOwner" name="btnRefreshOwner"
                                   style="text-align: center;"><i class="fa fa-refresh"></i></a>
                            </div>
                            <div class="form-group">
                                {{ Form::label('brand_id', 'Brand: ', ['class' => 'col-md-2 control-label']) }}
                                <div class="col-md-8">
                                    {{ Form::select('brand_id', $brands, $coupon->brand_id, ['class'=>'form-control']) }}
                                </div>
                                <a href="/admin/brands/create" target="_blank" class="btn red control-label"
                                   role="button" style="text-align: center;"><i class="fa fa-plus"></i></a>&nbsp;
                                <a class="btn red control-label" id="btnRefreshBrand" name="btnRefreshBrandirc"
                                   style="text-align: center;"><i class="fa fa-refresh"></i></a>
                            </div>
                            <div class="form-group">
                                {{ Form::label('circulation', 'Circulation: ', ['class' => 'col-md-2 control-label']) }}
                                <div class="col-md-10">
                                    {{ Form::text('circulation', $coupon->circulation, ['class'=>'form-control', 'autocomplete'=>'off']) }}
                                </div>
                            </div>
                            <div class="form-group">
                                {{ Form::label('coupon_type_id', 'Coupon Type: ', ['class' => 'col-md-2 control-label']) }}
                                <div class="col-md-10">
                                    {{ Form::select('coupon_type_id', $types, $coupon->coupon_type_id, ['class'=>'form-control']) }}
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