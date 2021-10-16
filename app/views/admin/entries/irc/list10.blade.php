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
        <!-- BEGIN PAGE HEADER-->
        <div class="portlet box blue-hoki">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-users"></i>Click on an Entry to Edit
                </div>
                <div class="col-md-2 pull-right">
                    <a href="/admin/entries/irc/create" class="btn green " role="button">Add New Entry <i class="fa fa-plus"></i></a>
                </div>
                
            </div>
            <!-- END PAGE HEADER-->
            <!-- BEGIN PAGE CONTENT-->
            <div class="portlet-body form">
                <div class="">
                    <div class="loader" data-grid="standard">

                        <div>
                            <span></span>
                        </div>

                    </div>

                    {{-- Results per page --}}
                    <!--
                    <div class="col-md-2">

                        <div class="form-group">

                            <select data-per-page class="form-control">
                                <option>Per Page</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>

                        </div>

                    </div>
                    !-->
                    



                    

                

                {{-- Results --}}
                <div class="row">

                    <div class="col-lg-12">

                        <div class="table-responsive">

                            <table class="table table-striped table-bordered table-hover" data-source="{{ URL::to('irc_entry_source10') }}" data-grid="standard">

                                <thead>
                                <tr>
                                    <th class="sortable col-md-1" data-grid="standard" data-sort="id">ID</th>
                                    <th class="sortable col-md-2" data-grid="standard" data-sort="retailer">Retailer</th>
                                    <th class="sortable col-md-2" data-grid="standard" data-sort="program">Coupon</th>
                                    <th class="sortable col-md-1" data-grid="standard" data-sort="clearinghouse">Clearinghouse</th>
                                    <th class="sortable col-md-1" data-grid="standard" data-sort="is_invoiced">Invoiced?</th>
                                    <th class="sortable col-md-1" data-grid="standard" data-sort="quantity">Quantity</th>
                                    <th class="sortable col-md-1" data-grid="standard" data-sort="payable">Payable</th>
                                    <th class="sortable col-md-1" data-grid="standard" data-sort="shipping">Shipping</th>
                                    <th class="sortable col-md-1" data-grid="standard" data-sort="created_at">Created</th>
                                </tr>
                                </thead>
                                <tbody></tbody>
                            </table>

                        </div>

                    </div>

                </div>

                {{-- Pagination --}}
                <footer id="pagination" data-grid="standard"></footer>

                @include('templates/entries/irc/results10')
                @include('templates/entries/irc/no_results')
                @include('templates/entries/irc/pagination')
                @include('templates/entries/irc/filters')
                @include('templates/entries/irc/no_filters')
            </div>
        </div>
    </div>
        <!-- END PAGE CONTENT-->
    </div>
</div>
@stop