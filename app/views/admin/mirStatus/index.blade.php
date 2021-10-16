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
            <!-- BEGIN PAGE HEADER-->
            <div class="portlet box blue-hoki">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-users"></i>Click on a Status to Edit
                    </div>
                    <a href="/admin/mir/status/add" class="btn red pull-right" role="button">Add New Status
                        <i class="fa fa-plus"></i></a>
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
                    </div>




                    {{-- Results --}}
                    <div class="row">

                        <div class="col-lg-12">

                            <div class="table-responsive">

                                <table class="table table-striped table-bordered table-hover"
                                       data-source="{{ URL::to('mir_status_c') }}" data-grid="standard">

                                    <thead>
                                    <tr>
                                        <th class="sortable col-md-1" data-grid="standard" data-sort="id">ID</th>
                                        <th class="sortable col-md-3" data-grid="standard" data-sort="name">Name
                                        </th>
                                        <th class="sortable col-md-3" data-grid="standard" data-sort="active">
                                            Active</th>

                                        {{-- <th class="sortable col-md-1" data-grid="standard" data-sort="created_at">Updated</th> --}}
                                        <th class="sortable col-md-1"></th>
                                    </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>

                            </div>

                        </div>

                    </div>

                    {{-- Pagination --}}
                    <footer id="pagination" data-grid="standard"></footer>
                    @include('templates/mirStatus/results')
                    @include('templates/mirStatus/no_results')
                    @include('templates/mirStatus/pagination')
                    @include('templates/mirStatus/filters')
                    @include('templates/mirStatus/no_filters')
                </div>
            </div>
        </div>
        <!-- END PAGE CONTENT-->
    </div>
    </div>
@stop