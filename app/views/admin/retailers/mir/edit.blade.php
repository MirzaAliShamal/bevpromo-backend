@extends('.........layouts.default')

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
                            <i class="fa fa-reorder"></i> Edit Retailer
                        </div>
                        {{ Form::button('<span>Save Changes </span><i class="glyphicon glyphicon-save"></i>', array('form'=>'update-form', 'type' => 'submit', 'class' => 'btn red pull-right'))}}
                    </div>
                    <div class="portlet-body">
                        {{ Form::open(['route'=>['admin.retailers.mir.update', $retailer->id], 'class'=>'form-horizontal', 'role'=>'form', 'id'=>'update-form', 'method' => 'put']) }}
                        <div class="form-body">
                            <div class="form-group">
                                {{ Form::label('name', 'Retailer Name: ', ['class' => 'col-md-2 control-label']) }}
                                <div class="col-md-10">
                                    {{ Form::text('name', $retailer->name, ['class'=>'form-control']) }}
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">Active: </label>
                                <div class="radio-list col-md-10">
                                    <label class="radio-inline">
                                        @if ($retailer->is_active == 1)
                                        {{ Form::radio('is_active', '1', true, ['class'=>'radio-inline']) }} Yes
                                        {{ Form::radio('is_active', '0', false, ['class'=>'radio-inline', 'style'=>'margin-left: -9px;']) }} No
                                        @else
                                        {{ Form::radio('is_active', '1', false, ['class'=>'radio-inline']) }} Yes
                                        {{ Form::radio('is_active', '0', true, ['class'=>'radio-inline', 'style'=>'margin-left: -9px;']) }} No
                                        @endif
                                </div>
                            </div>
                            <div class="form-group">
                                {{ Form::label('address', 'Address: ', ['class' => 'col-md-2 control-label']) }}
                                <div class="col-md-10">
                                    {{ Form::text('address', $retailer->address, ['class'=>'form-control']) }}
                                </div>
                            </div>
                            <div class="form-group">
                                {{ Form::label('city', 'City: ', ['class' => 'col-md-2 control-label']) }}
                                <div class="col-md-10">
                                    {{ Form::text('city', $retailer->city, ['class'=>'form-control']) }}
                                </div>
                            </div>
                            <div class="form-group">
                                {{ Form::label('state', 'State: ', ['class' => 'col-md-2 control-label']) }}
                                <div class="col-md-10">
                                    {{ Form::text('state', $retailer->state, ['class'=>'form-control']) }}
                                </div>
                            </div>
                            <div class="form-group">
                                {{ Form::label('zip', 'Zip: ', ['class' => 'col-md-2 control-label']) }}
                                <div class="col-md-10">
                                    {{ Form::text('zip', $retailer->zip, ['class'=>'form-control']) }}
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