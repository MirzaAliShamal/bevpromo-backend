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
                            <i class="fa fa-reorder"></i> Edit IRC Invoice
                        </div>
                        {{ Form::button('<span>Save Changes </span><i class="glyphicon glyphicon-save"></i>', array('form'=>'update-form', 'type' => 'submit', 'class' => 'btn red pull-right'))}}
                    </div>
                    <div class="portlet-body">
                        {{ Form::open(['route'=>['admin.invoices.irc.update', $invoiceIrc->id], 'class'=>'form-horizontal', 'role'=>'form', 'id'=>'update-form', 'method' => 'put']) }}
                        <div class="form-body">
                            <div class="form-group">
                                {{ Form::label('invoice_status_id', 'Status: ', ['class' => 'col-md-2 control-label']) }}
                                <div class="col-md-10">
                                    {{ Form::select('invoice_status_id', $statuses, $invoiceIrc->invoice_status_id, ['class'=>'form-control']) }}
                                </div>
                            </div>
                            <div class="form-group">
                                {{ Form::label('description', 'Description: ', ['class' => 'col-md-2 control-label']) }}
                                <div class="col-md-10">
                                    {{ Form::text('description', $invoiceIrc->description, ['class'=>'form-control', 'autocomplete'=>'off']) }}
                                </div>
                            </div>
                            <div class="form-group">
                                {{ Form::label('user_id', 'Client: ', ['class' => 'col-md-2 control-label']) }}
                                <div class="col-md-10">
                                    {{ Form::select('user_id', $user,  $invoiceIrc->user_id, ['class'=>'form-control']) }}
                                </div>
                            </div>
                            <div class="form-group">
                                {{ Form::label('coupons', 'Programs: ', ['class' => 'col-md-2 control-label']) }}
                                <div class="col-md-10">
                                    {{ Form::select('coupons[]', $coupons, $associatedCoupons, array('multiple' => 'multiple', 'class' => 'multi-select', 'id' => 'my_multi_select1')); }}
                                </div>
                            </div>
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="portlet box green ">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-reorder"></i> Transactions for Invoice ID: {{ $invoiceIrc->id }}
                        </div>
                        <a href="/admin/invoices/irc/create" class="btn red pull-right" role="button">Add New Transaction <i class="fa fa-plus"></i></a>
                    </div>
                    <div class="portlet-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" data-source="{{ URL::to('transactions_irc_source/' . $invoiceIrc->id) }}" data-grid="standard">
                                <thead>
                                <tr>
                                    <th class="sortable col-md-1" data-grid="standard" data-sort="id">ID</th>
                                    <th class="sortable col-md-1" data-grid="standard" data-sort="first_name">Type</th>
                                    <th class="sortable col-md-1" data-grid="standard" data-sort="first_name">Amount</th>
                                    <th class="sortable col-md-1" data-grid="standard" data-sort="created_at">Created</th>
                                    <th class="sortable col-md-1" data-grid="standard" data-sort="updated_at">Updated</th>
                                    <th class="sortable col-md-1" data-grid="standard" data-sort="updated_at">Edit</th>
                                </tr>
                                </thead>
                                <tbody></tbody>
                            </table>

                        </div>
                        {{-- Pagination --}}
                        <footer id="pagination" data-grid="standard"></footer>

                        @include('templates/transactions/irc/results')
                        @include('templates/transactions/irc/no_results')
                        @include('templates/transactions/irc/pagination')
                        @include('templates/transactions/irc/filters')
                        @include('templates/transactions/irc/no_filters')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@stop