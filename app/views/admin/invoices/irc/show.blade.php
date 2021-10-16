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
        <div class="invoice">
        <hr/>
        <div class="row">
            <div class="col-xs-3">
                <h3>Client:</h3>
                <ul class="list-unstyled">
                    <li>
                        {{ $user->first_name }} {{ $user->last_name }}
                    </li>
                    <li>
                        {{ $supplier->name }}
                    </li>
                    <li>
                        {{ $user->phone }}
                    </li>
                    <li>
                        {{ $user->address }}
                    </li>
                    <li>
                        {{ $user->city }}, {{ $user->state }} {{ $user->zip }}
                    </li>
                </ul>
            </div>
            <div class="col-xs-3">
                <h3>Description:</h3>
                <p>
                    {{ $invoiceIrc->description }}
                </p>
            </div>
            <div class="col-xs-3 invoice-payment">
                <h3>Status:</h3>
                <p>
                    {{ $status->name }}
                </p>
            </div>
            <div class="col-xs-3">
                <h3>Invoice ID:</h3>
                <p>
                    {{ $invoiceIrc->id }}
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <table class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th>
                            Program ID:
                        </th>
                        <th>
                            Program Name:
                        </th>
                        <th class="hidden-480">
                            Program Description:
                        </th>
                        <th class="hidden-480">
                            Dollar Value:
                        </th>
                        <th class="hidden-480">
                            Quantity Entered:
                        </th>
                        <th>
                            Total Value:
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($coupons as $coupon)
                        <tr>
                            <td>
                                {{ $coupon->id }}
                            </td>
                            <td>
                                {{ $coupon->name }}
                            </td>
                            <td>
                                {{ $coupon->description }}
                            </td>
                            <td>
                                ${{ $coupon->value }}
                            </td>
                            <td>
                                {{ $coupon->countEntries() }}
                            </td>
                            <td>
                                $ {{ $coupon->calculateEntryValues() }}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-4">
                <div class="well">
                    <address>
                        <strong>Beverage Promotions LLC</strong><br/>
                        100 Main St<br/>
                        Phoenix, AZ 85001<br/>
                        <abbr title="Phone">P:</abbr> (555) 555-5555 </address>
                    <address>
                        <strong>Matt DeNicola</strong><br/>
                        <a href="mailto:#">
                            matt@bevpromotions.com </a>
                    </address>
                </div>
            </div>
            <div class="col-xs-8 invoice-block">
                <div class="row">
                    <div class="col-xs-3 invoice-block">
                        <ul class="list-unstyled amounts">
                            <li>
                                <strong>Total Value:</strong> <span class="pull-right">$ {{ $invoiceIrc->allCouponSum() }}</span>
                            </li>
                            <li>
                                <strong>Total Fees:</strong> <span class="pull-right">$##</span>
                            </li>
                            <li>
                                <strong>Total Pre-Funds:</strong> <span class="pull-right">$##</span>
                            </li>
                            <li>
                                <strong>Total Payouts:</strong> <span class="pull-right">$##</span>
                            </li>
                            <li>
                                <strong>Total Balance:</strong> <span class="pull-right">$##</span>
                            </li>
                        </ul>
                    </div>
                </div>
                <br/>
                <a class="btn btn-lg blue hidden-print margin-bottom-5" onclick="javascript:window.print();">
                    Print <i class="fa fa-print"></i>
                </a>
                <a href="/admin/invoices/irc/{{ $invoiceIrc->id }}/edit" class="btn btn-lg green hidden-print margin-bottom-5">
                    Edit Invoice <i class="fa fa-check"></i>
                </a>
            </div>
        </div>
        </div>
    </div>
</div>

@stop