@extends('layouts.client-default')

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
                    <i class="fa fa-users"></i>IRC Records
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
                    

                    <div class="col-md-6">

                        <form data-search data-grid="standard" class="form-inline" role="form">
                            <div class="form-group">

                                <select name="column" class="form-control">
                                    <option value="f_month">Month</option>
                                    <option value="retailer">Retailer</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <input type="text" name="filter" placeholder="Type to Filter" class="form-control">
                                <button type="submit" class="btn btn-default">Add Filter</button>
                            </div>

                        </form>

                    </div>

                </div>

                {{-- Export button --}}
                <div class="col-md-2">

                    <div class="btn-group">

                        <button name="export" type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                            Export <span class="caret"></span>
                        </button>

                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#" data-grid="standard" data-download="csv">Export to CSV</a></li>
                            <li><a href="#" data-grid="standard" data-download="json">Export to JSON</a></li>
                            <li><a href="#" data-grid="standard" data-download="pdf">Export to PDF</a></li>
                        </ul>

                    </div>

                </div>

                {{-- Applied filters --}}
                <div class="row col-md-12 " id="filter-bar-bottom">

                    <div class="applied-filters" data-grid="standard"></div>

                </div>

                {{-- Results --}}
                <div class="row">

                    <div class="col-lg-12">

                        <div class="table-responsive">

                            <table class="table table-striped table-bordered table-hover" data-source="{{ URL::to('irc_entry_by_retaier_client_source') }}" data-grid="standard">

                                <thead>
                                <tr>
                                    <th class="sortable col-md-1" data-grid="standard" data-sort="f_month">Month</th>
                                    <th class="sortable col-md-2" data-grid="standard" data-sort="retailer">Retailer</th>
                                    <th class="sortable col-md-2" data-grid="standard" data-sort="total">Total</th>
                                </tr>
                                </thead>
                                <tbody></tbody>
                            </table>

                        </div>

                    </div>

                </div>

                {{-- Pagination --}}
                <footer id="pagination" data-grid="standard"></footer>

                @include('templates/reporting/entries/irc/by/retailer/results')
                @include('templates/reporting/entries/irc/by/retailer/no_results')
                @include('templates/reporting/entries/irc/by/retailer/pagination')
                @include('templates/reporting/entries/irc/by/retailer/filters')
                @include('templates/reporting/entries/irc/by/retailer/no_filters')
            </div>
        </div>
    </div>
        <!-- END PAGE CONTENT-->
    </div>
</div>
@stop