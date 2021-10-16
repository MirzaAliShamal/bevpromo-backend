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
                    <i class="fa fa-users"></i>Click on a Clearinghouse to Edit
                </div>
                <a href="/admin/clearinghouses/create" class="btn red pull-right" role="button">Add New Clearinghouse <i class="fa fa-plus"></i></a>
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

                    {{-- Results --}}
                    <div class="row">

                        <div class="col-lg-12">

                            <div class="table-responsive">

                                <table class="table table-striped table-bordered table-hover" data-source="{{ URL::to('clearinghouses_source') }}" data-grid="standard">

                                    <thead>
                                    <tr>
                                        <th class="sortable col-md-1" data-grid="standard" data-sort="id">ID</th>
                                        <th class="sortable col-md-5" data-grid="standard" data-sort="name">Clearinghouse Name</th>
                                        <th class="sortable col-md-2" data-grid="standard" data-sort="created_at">Created</th>
                                        <th class="sortable col-md-2" data-grid="standard" data-sort="updated_at">Updated</th>
                                        <th class="sortable col-md-2"></th>
                                    </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>

                            </div>

                        </div>

                    </div>

                    {{-- Pagination --}}
                    <footer id="pagination" data-grid="standard"></footer>

                    @include('templates/clearinghouses/results')
                    @include('templates/clearinghouses/no_results')
                    @include('templates/clearinghouses/pagination')
                    @include('templates/clearinghouses/filters')
                    @include('templates/clearinghouses/no_filters')
                </div>
            </div>
        </div>
        <!-- END PAGE CONTENT-->
    </div>
</div>
@stop
@push('page_specific_scripts')
<script>
$(document).ready(function(){
            var inline = "{{$inline}}";
            if(inline === '1') {
                window.close();
            }
        });
        </script>
@endpush