@extends('layouts.default-dt')

@section('content')
<div class="modal fade" id="delete" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Confirm Deletion</h4>
            </div>
            <div class="modal-body">
                 Are you sure you want to delete this record?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn default" data-dismiss="modal">Close</button>
                <a href="/admin/entries/irc/{{$entryIrc->id }}/delete" type="button" class="btn default blue">Yes</a>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
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
                            <i class="fa fa-reorder"></i> Edit IRC Entry
                        </div>
                        {{ Form::button('<span>Save Changes </span><i class="glyphicon glyphicon-save"></i>', array('form'=>'update-form', 'type' => 'submit', 'class' => 'btn green pull-right'))}}
                        <a href="#delete" class="btn red pull-right" data-toggle="modal">Delete Record <i class="glyphicon glyphicon-remove"></i></a>
                    </div>
                    <div class="portlet-body">
                        {{ Form::open(['route'=>['admin.entries.irc.update', $entryIrc->id], 'enctype'=>"multipart/form-data", 'class'=>'form-horizontal', 'role'=>'form', 'id'=>'update-form', 'method' => 'put']) }}
                        <div class="form-body">
                                <div class="form-group">
                                        {{ Form::label('retailer_id', 'Retailer: ', ['class' => 'col-md-2 control-label']) }}
                                        
                                        <div class="col-md-8">
                                            <select class="form-control" id="retailer_id" name="retailer_id">
                                                @foreach ($retailers as $key => $item)
                                                    @if($item->address != null)
                                                        <option value="{{ $item->id }}"@if ($item->id == $entryIrc->retailer_id) selected="selected" @endif>{{ $item->name }} ({{ $item->address }} {{ $item->state }})</option>
                                                    @else
                                                        <option value="{{ $item->id }}" @if ($item->id == $entryIrc->retailer_id) selected="selected" @endif>{{ $item->name }}</option>
                                                    @endif
                                                @endforeach
                                            
                                            </select>
                                            
                                        </div>
                                        <a href="/admin/retailers/irc/create?inline=1" target="_blank" class="btn red control-label" role="button" style="text-align: center;"><i class="fa fa-plus"></i></a>
                                <a class="btn red control-label" id="btnRefreshCouponIR" name="btnRefreshCouponIR"
                                   style="text-align: center;"><i class="fa fa-refresh"></i></a>
                                    </div>
                                    
                            <div class="form-group">
                                {{ Form::label('coupon_id', 'Program: ', ['class' => 'col-md-2 control-label']) }}
                                <div class="col-md-8">
                                    {{ Form::select('coupon_id', $coupons, $entryIrc->coupon_id, ['class'=>'form-control']) }}
                                </div>
                                <a href="/admin/coupons/irc/create?inline=1" target="_blank" class="btn red control-label" role="button" style="text-align: center;"><i class="fa fa-plus"></i></a>
                                <a class="btn red control-label" id="btnRefreshCouponIR" name="btnRefreshCouponIR"
                                   style="text-align: center;"><i class="fa fa-refresh"></i></a>
                            </div>
                            <div class="form-group">
                                {{ Form::label('coupon_notes_ir', 'Notes: ', ['class' => 'col-md-2 control-label']) }}
                                <div class="col-md-10">
                                    <textarea class="form-control" cols="6" id="coupon_notes_ir" name="coupon_notes_ir" rows="2">{{ strip_tags($entryIrc->coupon_notes_ir) }}</textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                {{ Form::label('coupon_quantity', 'Quantity: ', ['class' => 'col-md-2 control-label']) }}
                                <div class="col-md-10">
                                    {{ Form::text('coupon_quantity', $entryIrc->coupon_quantity, ['class'=>'form-control']) }}
                                </div>
                            </div>
                            <div class="form-group">
                                {{ Form::label('payable', 'Payable: ', ['class' => 'col-md-2 control-label']) }}
                                <div class="col-md-10">
                                    {{ Form::text('payable', $entryIrc->payable, ['class'=>'form-control']) }}
                                </div>
                            </div>
                            <div class="form-group">
                                {{ Form::label('shipping', 'Shipping: ', ['class' => 'col-md-2 control-label']) }}
                                <div class="col-md-10">
                                    {{ Form::text('shipping', $entryIrc->shipping, ['class'=>'form-control']) }}
                                </div>
                            </div>
                            <div class="form-group">
                                {{ Form::label('client_invoice', 'Client Invoice: ', ['class' => 'col-md-2 control-label']) }}
                                <div class="col-md-10">
                                    {{ Form::text('client_invoice', $entryIrc->client_invoice, ['class'=>'form-control']) }}
                                </div>
                            </div>
                            <div class="form-group">
                                {{ Form::label('clearinghouse_id', 'Clearinghouse: ', ['class' => 'col-md-2 control-label']) }}
                                <div class="col-md-8">
                                    {{ Form::select('clearinghouse_id', $clearinghouses, $entryIrc->clearinghouse_id, ['class'=>'form-control']) }}
                                </div>
                                <a href="/admin/clearinghouses/create" target="_blank" class="btn red control-label" role="button" style="text-align: center;"><i class="fa fa-plus"></i></a>
                                <a class="btn red control-label" id="btnRefreshCleariningIR" name="btnRefreshCouponIR"
                                   style="text-align: center;"><i class="fa fa-refresh"></i></a>
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

@push('footer-script')
    <script>
        // $(document).on('keyup keypress blur change', '#coupon_notes_ir', function () {
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