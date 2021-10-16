@extends('layouts.default-dt')

@section('content')
    <style>
        .modal .modal-header .close {
            margin-top: 0px !important;
            display: none !important;
        }
    </style>
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
                            <i class="fa fa-reorder"></i> Add New MIR Entry
                        </div>
                        {{ Form::button('<span>Save </span><i class="glyphicon glyphicon-save"></i>', array('form'=>'update-form', 'type' => 'submit', 'class' => 'btn red pull-right'))}}
                    </div>
                    <div class="portlet-body">
                        {{ Form::open(['route'=>['admin.entries.mir.store'], 'class'=>'form-horizontal', 'role'=>'form', 'id'=>'update-form', 'enctype'=>"multipart/form-data", 'method' => 'post', 'autocomplete'=>'off']) }}
                        <div class="form-body">

                            <div class="form-group">
                                {{ Form::label('mir_retailer_id', 'Retailer: ', ['class' => 'col-md-2 control-label']) }}
                                <div class="col-md-8">
                                    <select class="form-control" id="mir_retailer_id" name="mir_retailer_id">
                                        @foreach ($retailers as $key => $item)
                                            @if($item->address != null)
                                                <option value="{{ $item->id }}">{{ $item->name }} ( {{ $item->address }} {{ $item->state }} )</option>
                                            @else
                                                <option value="{{ $item->id }}">{{ $item->name }} ( {{ $item->state }} )</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <a href="/admin/retailers/mir/create" target="_blank" class="btn red control-label" role="button" style="text-align: center;"><i class="fa fa-plus"></i></a>
                                <a class="btn red control-label" id="btnRefreshEntriesMri" name="btnRefreshBrandirc"
                                   style="text-align: center;"><i class="fa fa-refresh"></i></a>
                            </div>
                            <div class="form-group">
                                {{ Form::label('coupon_id', 'Program: ', ['class' => 'col-md-2 control-label']) }}
                                <div class="col-md-8">
                                    {{ Form::select('coupon_id', ['default' => 'Please select the coupon'] + $coupons, null, ['class'=>'form-control']) }}
                                </div>
                                <a href="/admin/coupons/mir/create" target="_blank" class="btn red control-label" role="button" style="text-align: center;"><i class="fa fa-plus"></i></a>
                                <a class="btn red control-label" id="btnRefreshEntriesMriCop" name="btnRefreshBrandirc"
                                   style="text-align: center;"><i class="fa fa-refresh"></i></a>
                            </div>
                            <div class="form-group">
                                {{ Form::label('coupon_notes_mir', 'Notes: ', ['class' => 'col-md-2 control-label']) }}
                                <div class="col-md-10">
                                    <textarea class="form-control" cols="6" id="coupon_notes_mir" name="coupon_notes_mir" rows="2"></textarea>
{{--                                    {{ Form::textarea('coupon_notes_mir', null, ['class'=>'form-control']) }}--}}
                                </div>
                            </div>
                            <div class="form-group">
                                {{ Form::label('dollar_value', 'Dollar Value: ', ['class' => 'col-md-2 control-label']) }}
                                <div class="col-md-10">
                                    {{ Form::text('dollar_value', null, ['class'=>'form-control']) }}
                                </div>
                            </div>
                            <div class="form-group">
                                {{ Form::label('first_name', 'First Name: ', ['class' => 'col-md-2 control-label']) }}
                                <div class="col-md-10">
                                    {{ Form::text('first_name', null, ['class'=>'form-control']) }}
                                </div>
                            </div>
                            <div class="form-group">
                                {{ Form::label('last_name', 'Last Name: ', ['class' => 'col-md-2 control-label']) }}
                                <div class="col-md-10">
                                    {{ Form::text('last_name', null, ['class'=>'form-control']) }}
                                </div>
                            </div>
                            <div class="form-group">
                                {{ Form::label('address', 'Address: ', ['class' => 'col-md-2 control-label']) }}
                                <div class="col-md-10">
                                    {{ Form::text('address', null, ['class'=>'form-control']) }}
                                </div>
                            </div>
                            <div class="form-group">
                                {{ Form::label('city', 'City: ', ['class' => 'col-md-2 control-label']) }}
                                <div class="col-md-10">
                                    {{ Form::text('city', null, ['class'=>'form-control']) }}
                                </div>
                            </div>
                            <div class="form-group">
                                {{ Form::label('state', 'State: ', ['class' => 'col-md-2 control-label']) }}
                                <div class="col-md-10">
                                    {{ Form::text('state', null, ['class'=>'form-control']) }}
                                </div>
                            </div>
                            <div class="form-group">
                                {{ Form::label('zip', 'Zip: ', ['class' => 'col-md-2 control-label']) }}
                                <div class="col-md-10">
                                    {{ Form::text('zip', null, ['class'=>'form-control']) }}
                                </div>
                            </div>
                            <div class="form-group">
                                {{ Form::label('email', 'Email: ', ['class' => 'col-md-2 control-label']) }}
                                <div class="col-md-10">
                                    {{ Form::text('email', null, ['class'=>'form-control']) }}
                                </div>
                            </div>
                            <div class="form-group">
                                {{ Form::label('birth_date', 'Birth Date: ', ['class' => 'col-md-2 control-label']) }}
                                <div class="col-md-3">
                                    <input type="date" name="birth_date" id="birth_date" class="form-control form-control-inline input-medium" />
{{--                                    {{ Form::text('birth_date', null, ['class'=>'form-control form-control-inline input-medium date-picker', 'autocomplete'=>'off']) }}--}}
                                </div>
                            </div>
                            <div class="form-group">
                                {{ Form::label('mir_status_id', 'Status: ', ['class' => 'col-md-2 control-label']) }}
                                <div class="col-md-10">
                                    {{ Form::select('mir_status_id', $mirStatuses, null, ['class'=>'form-control']) }}
                                </div>
                            </div>
                            <div class="form-group">
                                {{ Form::label('denial_reason_id', 'Denial Reason: ', ['class' => 'col-md-2 control-label']) }}
                                <div class="col-md-8">
                                    {{ Form::select('denial_reason_id', $mirDenialReasons, 'default', ['class'=>'form-control']) }}
                                </div>
                                <a onclick="openDenialReasonPoPup()" target="_blank" class="btn red control-label" role="button" style="text-align: center;"><i class="fa fa-plus"></i></a>
                            </div>
                        </div>
                        {{ Former::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header" style="background-color:#67809f;color:#fff;">
                <h4 class="modal-title" style="font-size: 15px;
    font-weight: bold;">Add Denial Reasons</h4>
                <i class="fa fa-times" data-dismiss="modal" aria-hidden="true" style="float: right;
    bottom: 20px;
    position: relative;"></i>
            </div>
            <form id="formData">
            <div class="modal-body">
                <div class="row">
                    <label class="col-md-2 control-label">Denial Reasons: </label>
                    <div class="radio-list col-md-10">
                       <input type="text" name="name" value="" id="reason_name" class="form-control" />
                    </div>
                </div>
                <br>
                <br>
                <div class="row">
                    <label class="col-md-2 control-label">Active: </label>
                    <div class="radio-list col-md-10">
                        <label class="radio-inline">
                            <div class="radio"><span class="checked"><input id="active" class="radio-inline" checked="checked" name="active" type="radio" value="1"></span></div> Yes
                            <div class="radio"><span><input class="radio-inline" id="in-active" style="margin-left: -9px;" name="active" type="radio" value="0"></span></div>
                            No
                        </label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" onclick="submitForm()">save</button>
            </div>
            </form>
        </div>

    </div>
</div>
@stop
@push('footer-script')
    <script>
        function openDenialReasonPoPup(){
            $('#myModal').modal('show');
        }
        function submitForm(){
            let reason_name = $('#reason_name').val();
            let active = $('#active').prop('checked');
            let inActive = $('#in-active').prop('checked');
            let value = '';
            if(active) {
                value = 1;
            }
            if(inActive) {
                value = 0;
            }
            let form = new FormData();
            form.append('_token','{{csrf_token()}}');
            form.append('name',reason_name);
            form.append('value',value);
            $.ajax({
               method: 'post',
               processData: false,
               contentType: false,
               cache: false,
               url:'/admin/entries/mir/add/denial-reason',
               data:form,

               success: function (response){
                   console.log('response');
                   console.log(response);
                   window.location.reload();
               },
               error: function (error){
                  console.log('error');
                  console.log(error);
               },
            });
        }
        // $(document).on('keyup keypress blur change', '#coupon_notes_mir', function () {
        //     var maxLength = 100; // number of characters to limit
        //     imposeMaxLength($(this), maxLength);
        // });
        //
        // function imposeMaxLength(element, maxLength) {
        //     if (element.val().length > maxLength) {
        //         element.val(element.val().substring(0, maxLength));
        //     }
        // }
    </script>
@endpush