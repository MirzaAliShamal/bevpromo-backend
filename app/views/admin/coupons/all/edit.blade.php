@extends('layouts.default-dt')

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
                            <i class="fa fa-reorder"></i> Edit Program
                        </div>
                        {{ Form::button('<span>Save </span><i class="glyphicon glyphicon-save"></i>', array('form'=>'update-form', 'type' => 'submit', 'class' => 'btn red pull-right'))}}
                    </div>
                    <div class="portlet-body">
                        {{ Form::open(['route'=>['admin.coupons.all.update', $coupon->id], 'enctype'=>"multipart/form-data",'class'=>'form-horizontal', 'role'=>'form', 'id'=>'update-form', 'method' => 'put', 'autocomplete'=>'off']) }}
                        <div class="form-body">
                            <div class="form-group">
                                {{ Form::label('campaign_type', 'Select Campaign Type:', ['class' => 'col-md-2 control-label']) }}
                                <div class="col-md-10">
                                    <select class="form-control" id="campaignType" name="campaign_type">
                                        @foreach ($campaigns as $key => $item)
                                        <option value="{{ $key }}" @if ($key == $coupon->campaign_type)
                                            selected="selected" @endif>{{ $item; }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group" id="campaignLogo" style="display: none">
                                {{ Form::label('campaign_logo', 'Choose Campaign Logo: ', ['class' => 'col-md-2 control-label']) }}
                                <div class="col-md-10">
                                    <input type="file" name="campaign_logo" class="form-control" required>
                                </div>
                            </div>
                            <div class='form-group' id='customUrl' style='display: none'>
                                <label for='custom_url' class='col-md-2 control-label'>Offer URL: </label>
                                <div class='col-md-10'>
                                <input type='text' name='custom_url' id='custom_url' value="{{ $coupon->custom_url }}" class='form-control'></div></div>
                                <div class="form-group" id="offerCode" style="display: none">
                                    <label for="offer_code" class="col-md-2 control-label">Offer Code: </label>
                                    <div class="col-md-10">
                                        <input type="text" name="offer_code" id="offer_code" value="{{ $coupon->offer_code }}" class="form-control">
                                    </div></div>
                                <div class="form-group" id="promoTitle" style="display: none">
                                    <label for="promotion_title" class="col-md-2 control-label">Offer Title: </label>
                                    <div class="col-md-10">
                                    <textarea class="form-control" name="promotion_title" id="promotion_title" rows="2" cols="20">{{ $coupon->promotion_title }}</textarea>
                                    </div></div>
                                    <div class="form-group">
                                        {{ Form::label('coupon_type_id', 'Coupon Type: ', ['class' => 'col-md-2 control-label']) }}
                                        <div class="col-md-10">
                                            {{ Form::select('coupon_type_id', $types, $coupon->coupon_type_id, ['class'=>'form-control']) }}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {{ Form::label('name', 'Coupon/Program Name: ', ['class' => 'col-md-2 control-label']) }}
                                        <div class="col-md-10">
                                            {{ Form::text('name', $coupon->name, ['class'=>'form-control']) }}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {{ Form::label('value', 'Dollar Value: ', ['class' => 'col-md-2 control-label']) }}
                                        <div class="col-md-10">
                                            {{ Form::text('value', $coupon->value, ['class'=>'form-control', 'autocomplete'=>'off']) }}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {{ Form::label('description', 'Description: ', ['class' => 'col-md-2 control-label']) }}
                                        <div class="col-md-10">
                                            {{ Form::text('description', $coupon->description, ['class'=>'form-control', 'autocomplete'=>'off']) }}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {{ Form::label('start_date', 'Start Date: ', ['class' => 'col-md-2 control-label']) }}
                                        <div class="col-md-3">
                                            {{ Form::text('start_date', $coupon->start_date, ['class'=>'form-control form-control-inline input-medium date-picker', 'autocomplete'=>'off']) }}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {{ Form::label('expires', 'Expiration Date: ', ['class' => 'col-md-2 control-label']) }}
                                        <div class="col-md-3">
                                            {{ Form::text('expires', $coupon->expires, ['class'=>'form-control form-control-inline input-medium date-picker', 'autocomplete'=>'off']) }}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {{ Form::label('receive_by', 'Receive By: ', ['class' => 'col-md-2 control-label']) }}
                                        <div class="col-md-3">
                                            {{ Form::text('receive_by', $coupon->receive_by, ['class'=>'form-control form-control-inline input-medium date-picker', 'autocomplete'=>'off']) }}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {{ Form::label('barcode', 'Barcode: ', ['class' => 'col-md-2 control-label']) }}
                                        <div class="col-md-10">
                                            {{ Form::text('barcode', $coupon->barcode, ['class'=>'form-control', 'autocomplete'=>'off']) }}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {{ Form::label('circulation', 'Circulation: ', ['class' => 'col-md-2 control-label']) }}
                                        <div class="col-md-10">
                                            {{ Form::text('circulation', $coupon->circulation, ['class'=>'form-control', 'autocomplete'=>'off']) }}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {{ Form::label('user_id', 'Program Owner: ', ['class' => 'col-md-2 control-label']) }}
                                        <div class="col-md-10">
                                            {{ Form::select('user_id', $users, $coupon->user_id, ['class'=>'form-control']) }}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {{ Form::label('brand_id', 'Brand: ', ['class' => 'col-md-2 control-label']) }}
                                        <div class="col-md-10">
                                            {{ Form::select('brand_id', $brands, $coupon->brand_id, ['class'=>'form-control']) }}
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
                                <div class="col-md-10">
                                    {{ Form::select('user_id', $users, $coupon->user_id, ['class'=>'form-control']) }}
                                </div>
                            </div>
                            <div class="form-group">
                                {{ Form::label('brand_id', 'Brand: ', ['class' => 'col-md-2 control-label']) }}
                                <div class="col-md-10">
                                    {{ Form::select('brand_id', $brands, $coupon->brand_id, ['class'=>'form-control']) }}
                                </div>
                            </div>
                            <div class="form-group">
                                {{ Form::label('coupon_type_id', 'Coupon Type: ', ['class' => 'col-md-2 control-label']) }}
                                <div class="col-md-10">
                                    {{ Form::select('coupon_type_id', $types, $coupon->coupon_type_id, ['class'=>'form-control']) }}
                                </div>
                            </div>
                            <div class="form-group">
                                {{ Form::label('name', 'Coupon Name: ', ['class' => 'col-md-2 control-label']) }}
                                <div class="col-md-10">
                                    {{ Form::text('name', $coupon->name, ['class'=>'form-control']) }}
                                </div>
                            </div>
                            <div class="form-group">
                                {{ Form::label('value', 'Dollar Value: ', ['class' => 'col-md-2 control-label']) }}
                                <div class="col-md-10">
                                    {{ Form::text('value', $coupon->value, ['class'=>'form-control', 'autocomplete'=>'off']) }}
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
                                    {{ Form::text('expires', $coupon->expires, ['class'=>'form-control form-control-inline input-medium date-picker', 'autocomplete'=>'off']) }}
                                </div>
                            </div>
                            <div class="form-group">
                                {{ Form::label('receive_by', 'Receive By: ', ['class' => 'col-md-2 control-label']) }}
                                <div class="col-md-3">
                                    {{ Form::text('receive_by', $coupon->receive_by, ['class'=>'form-control form-control-inline input-medium date-picker', 'autocomplete'=>'off']) }}
                                </div>
                            </div>
                            <div class="form-group">
                                {{ Form::label('barcode', 'Barcode: ', ['class' => 'col-md-2 control-label']) }}
                                <div class="col-md-10">
                                    {{ Form::text('barcode', $coupon->barcode, ['class'=>'form-control', 'autocomplete'=>'off']) }}
                                </div>
                            </div>
                            <div class="form-group">
                                {{ Form::label('circulation', 'Circulation: ', ['class' => 'col-md-2 control-label']) }}
                                <div class="col-md-10">
                                    {{ Form::text('circulation', $coupon->circulation, ['class'=>'form-control', 'autocomplete'=>'off']) }}
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
                            <div class="portlet-title sweeptakesPart" style="display:none">
                            <h3>Image Uploader</h3>
                                <div class="form-body">
                                    <div class="border col-sm-10">
                                        <div class="form-group">
                                            {{ Form::label('photo_position', 'Select Photo Position:', ['class' => 'col-md-4 control-label']) }}
                                            <div class="col-md-5">
                                                {{ Form::select('photo_position[1][]', $uploadType, 'default', ['class'=>'uploadTypeChange form-control', 'id'=>'uploadType','data-id'=>1]) }}
                                            </div>
                                            
                                        </div>
                       
                                        <div class="form-group parentImage" id="images_upload" >
                                            {{ Form::label('image_post', 'Select Image: ', ['class' => 'col-md-4 control-label']) }}
                                            <div class="col-md-6 imageCopy_1">
                                                <input type="file" name="images[1][]" class="form-control">
                                            </div>
                                            <div class="col-md-2">
                                                <a class="imageCopy"  data-id="1" href="javascript:void(0)"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a>
                                            </div>                                                    
                                        </div>                         
                                  
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="col-md-2">
                                            <a class="imageUpload" href="javascript:void(0)"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a>
                                        </div> 
                                    </div>
                                    <div id="imagesUploadCopy" ></div>
                                
                                    @foreach($imageArr as $position=>$imageA)
                                    <div class="col-sm-12">
                                    <p>{{$uploadType[$position]}}</p>
                                    @foreach($imageA as $id=>$imagepath)
                                    <div class="col-sm-3">
                                    <div  class="img-wraps">
           
                        <span  class="closes deleteImage" data-id="{{$id}}" title="Delete">&times;</span>
                        <img  class="img-responsive delete_{{$id}}" src="{{$imagepath}}"></div>
                                        
                                        </div>

                                    @endforeach
                                    </div>
                                    @endforeach

                                </div>
                                    
                                <div class="col-sm-12">
                            <h3>Program Details</h3>
                    </div>
                            <div class="form-group">
                                {{ Form::label('program_no', 'Program No.: ', ['class' => 'col-md-3 control-label']) }}
                                <div class="col-md-9 ">
                                    {{ Form::text('program_no',$programDetails->id, ['class'=>'form-control', 'autocomplete'=>'off','disabled'=>'disabled']) }}
                                </div>
                            </div>
                            <div class="form-group">
                                {{ Form::label('program_name', 'Program Name.: ', ['class' => 'col-md-3 control-label']) }}
                                <div class="col-md-9">
                                    <input type="hidden" name="program_number" value="{{$programDetails->id}}">
                                    {{ Form::text('program_name', $programDetails->name, ['class'=>'form-control', 'autocomplete'=>'off']) }}
                                </div>
                            </div>
                            <div class="form-group">
                                {{ Form::label('program_url', 'Program URL(without www.): ', ['class' => 'col-md-3 control-label']) }}
                                <div class="col-md-9">
                                    {{ Form::text('program_url', $programDetails->url, ['class'=>'form-control', 'autocomplete'=>'off']) }}
                                </div>
                            </div>
                         
                            <div class="form-group">
                                {{ Form::label('admin_email', 'Admin Email: ', ['class' => 'col-md-3 control-label']) }}
                                <div class="col-md-9">
                                    {{ Form::text('admin_email', $programDetails->admin_email, ['class'=>'form-control', 'autocomplete'=>'off']) }}
                                </div>
                            </div>
                            <div class="form-group">
                                {{ Form::label('brand_landing_url', 'Brand Landing Url: ', ['class' => 'col-md-3 control-label']) }}
                                <div class="col-md-9">
                                    {{ Form::text('brand_landing_url', $programDetails->brand_landing_url, ['class'=>'form-control', 'autocomplete'=>'off']) }}
                                </div>
                            </div>
                            <div class="form-group">
                                {{ Form::label('valid_states', 'Valid States: ', ['class' => 'col-md-3 control-label']) }}
                                <div class="col-md-9">
                                {{ Form::select('valid_states[]',$allStates, $couponStates, ['class'=>'form-control','multiple','id'=>'validStates']) }}
                                </div>
                            </div>
                            <div class="form-group">
                                {{ Form::label('program_start_date', 'Program Start Date: ', ['class' => 'col-md-3 control-label']) }}
                                <div class="col-md-9">
                                    {{ Form::text('program_start_date', $programDetails->start_date, ['class'=>'form-control form-control-inline input-medium date-picker', 'autocomplete'=>'off']) }}
                                </div>
                            </div>
                            <div class="form-group">
                                {{ Form::label('program_end_date', 'Program End Date: ', ['class' => 'col-md-3 control-label']) }}
                                <div class="col-md-9">
                                    {{ Form::text('program_end_date', $programDetails->end_date, ['class'=>'form-control form-control-inline input-medium date-picker', 'autocomplete'=>'off']) }}
                                </div>
                            </div>
                            <div class="form-group">
                                {{ Form::label('program_status', 'Program Status:', ['class' => 'col-md-3 control-label']) }}
                                <div class="col-md-9">
                                    {{ Form::select('program_status', $programStatus, $programDetails->status, ['class'=>'form-control', 'id'=>'programStatus']) }}
                                </div>
                            </div>
                            
                            <div class="form-group">
                                {{ Form::label('daily_entry_limit', 'Daily Entry Limit: ', ['class' => 'col-md-3 control-label']) }}
                                <div class="col-md-9">
                                    {{ Form::text('daily_entry_limit', $programDetails->data_entry_limit, ['class'=>'form-control', 'autocomplete'=>'off']) }}
                                </div>
                            </div>
                            <div class="form-group">
                                {{ Form::label('under_age_link', 'Under Age Link: ', ['class' => 'col-md-3 control-label']) }}
                                <div class="col-md-9">
                                    {{ Form::text('under_age_link', $programDetails->under_age_link, ['class'=>'form-control', 'autocomplete'=>'off']) }}
                                </div>
                            </div>
                            <div class="form-group">
                                {{ Form::label('rule_only_program', 'Rules Only Program: ', ['class' => 'col-md-3 control-label']) }}
                                <div class="col-md-9">
                                    {{ Form::checkbox('rule_only_program', null, ($programDetails->rules == 1 ? true : false),['class'=>'form-control']) }}
                                </div>
                            </div>
                            <div class="form-group">
                            {{ Form::label('prize_info', 'Prize Information ', ['class' => 'col-md-12 control-label ','style'=>'text-align:left; margin-bottom:10px;']) }}
                                <textarea class="ckeditor" cols="80" id="prizeInfo" name="prize_info" rows="10">{{$programDetails->prize_info}}</textarea>
                                <script>
                                CKEDITOR.replace( 'prizeInfo' );
                                </script>
                            </div>
                            <div class="form-group">
                            {{ Form::label('rules', 'Rules ', ['class' => 'col-md-12 control-label ','style'=>'text-align:left; margin-bottom:10px;']) }}
                                <textarea class="ckeditor" cols="80" id="rules" name="rules_info" rows="10">{{$programDetails->rules_info}}</textarea>
                                <script>
                                CKEDITOR.replace( 'rules' );
                                </script>
                            </div>
                            <div class="form-group">
                            {{ Form::label('prize_info', 'Terms and Conditions  ', ['class' => 'col-md-12 control-label ','style'=>'text-align:left; margin-bottom:10px;']) }}
                                <textarea class="ckeditor" cols="80" id="terms_conditions" name="terms_conditions" rows="10">{{$programDetails->terms_conditions}}</textarea>
                                <script>
                                CKEDITOR.replace( 'terms_conditions' );
                                </script>
                            </div>
                            <div class="form-group">
                            {{ Form::label('privacy_policy', 'Privacy Policy', ['class' => 'col-md-12 control-label ','style'=>'text-align:left; margin-bottom:10px;']) }}
                                <textarea class="ckeditor" cols="80" id="privacy_policy" name="privacy_policy" rows="10">{{$programDetails->privacy_policy}}</textarea>
                                <script>
                                CKEDITOR.replace( 'termcondition' );
                                </script>
                            </div>
                            <div class="form-group">
                            {{ Form::label('legal_disclaimer', 'Legal Disclaimer', ['class' => 'col-md-12 control-label ','style'=>'text-align:left; margin-bottom:10px;']) }}
                                <textarea class="ckeditor" cols="80" id="legal_disclaimer" name="legal_disclaimer" rows="10">{{$programDetails->legal_disclaimer}}</textarea>
                                <script>
                                CKEDITOR.replace( 'termcondition' );
                                </script>
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
<style>
.img-wraps {
    position: relative;
    display: inline-block;
   
    font-size: 0;
}
.img-wraps .closes {
    position: absolute;
    top: 5px;
    right: 8px;
    z-index: 100;
    background-color: #FFF;
    padding: 4px 3px;
    
    color: #000;
    font-weight: bold;
    cursor: pointer;
   
    text-align: center;
    font-size: 22px;
    line-height: 10px;
    border-radius: 50%;
    border:1px solid red;
}
.img-wraps:hover .closes {
    opacity: 1;
}
</style>
@stop
@push('footer-script')
<script>
    $(document).ready(function () {
            $('#campaignType').trigger('change');
        });
</script>
@endpush