@extends('layouts.default')

@section('content')
<div class="page-content-wrapper">
    <div class="page-content">
     
        <!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
        <!-- BEGIN PAGE CONTENT-->
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="portlet box blue-hoki ">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-reorder"></i> Image Uploader
                        </div>
                        {{ Form::button('<span>Save </span><i class="glyphicon glyphicon-save"></i>', array('form'=>'update-form', 'type' => 'submit', 'class' => 'btn red pull-right'))}}
                    </div>
                    <div class="portlet-body">
                        {{ Form::open(['route'=>['admin.imageuploaderStore'],'enctype'=>"multipart/form-data", 'class'=>'form-horizontal', 'role'=>'form', 'id'=>'update-form', 'method' => 'post', 'autocomplete'=>'off']) }}
                        <div class="form-body">
                        <div class="form-group">
                                {{ Form::label('photo_position', 'Select Photo Position:', ['class' => 'col-md-4 control-label']) }}
                                <div class="col-md-7">
                                    {{ Form::select('photo_position', $uploadType, 'default', ['class'=>'form-control', 'id'=>'uploadType']) }}
                                </div>
                            </div>
                       
                        <div class="form-group" id="images_upload" >
                            {{ Form::label('image_post', 'Select Image: ', ['class' => 'col-md-4 control-label']) }}
                            <div class="col-md-6">
                                <input type="file" name="images[]" class="form-control">
                            </div> 
                            <div class="col-md-2">
                               <a class="imageUpload" href="javascript:void(0)">+</a>
                            </div>                              
                        </div>
                        <div id="imagesUploadCopy" ></div>
                        </div>

                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@stop