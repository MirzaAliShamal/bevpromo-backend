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
                            <i class="fa fa-reorder"></i> Edit Field
                        </div>
                        {{ Form::button('<span>Save Changes </span><i class="glyphicon glyphicon-save"></i>', array('form'=>'update-form', 'type' => 'submit', 'class' => 'btn red pull-right'))}}
                    </div>
                    <div class="portlet-body">
                        {{ Form::open(['route'=>['admin.coupons.default-text.update', $text->id], 'class'=>'form-horizontal', 'role'=>'form', 'id'=>'update-form', 'method' => 'put']) }}
                        <div class="form-body">
                            <div class="form-group">
                                {{ Form::label('default_field_name', 'Field Name: ', ['class' => 'col-md-2 control-label']) }}
                                <div class="col-md-10">
                                    @if($text->default_field_name == 'subject')
                                        <input type="text" name="default_field_name" readonly class="form-control" value="{{$text->default_field_name}}" />
                                    @else
                                        {{ Form::text('default_field_name', $text->default_field_name, ['class'=>'form-control']) }}
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                {{ Form::label('default_field_data', 'Field Data: ', ['class' => 'col-md-2 control-label']) }}
                                <div class="col-md-10">
                                    @if($text->default_field_name == 'subject')
                                        <input type="text" name="default_field_data" class="form-control" value="{{$text->default_field_data}}" />
                                    @else
                                        <textarea class="ckeditor" name="default_field_data" id="default_field_data"
                                        rows="2" cols="20">{{$text->default_field_data}}</textarea>
                                    @endif
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