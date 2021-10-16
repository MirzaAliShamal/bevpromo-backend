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
            <!-- BEGIN PAGE HEADER-->
            <div class="portlet box blue-hoki">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-users"></i>Reorders Coupons
                    </div>
                    <a href="/admin/reorder/coupons" class="btn red pull-right" role="button">
                        Reordering Coupons
                    </a>
                </div>
                <!-- END PAGE HEADER-->
                <!-- BEGIN PAGE CONTENT-->
                <div class="portlet-body form">
                    <div class="">
                        <div class="loader" >

                            <div>
                                <span></span>
                            </div>

                        </div>
                    </div>




                    {{-- Results --}}
                    <div class="row">

                        <div class="col-lg-12">

                            <div class="table-responsive">

                                <table class="display" style="width:100%"
                                       id="coupons">

                                    <thead>
                                    <tr>
                                        <th class="sortable col-md-1">ID</th>
                                        <th class="sortable col-md-3">Name
                                        </th>
                                        <th class="sortable col-md-3">
                                            Active</th>
                                    </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>

                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- END PAGE CONTENT-->
    </div>
    </div>
@stop

@push('footer-script')
    <script>
        $(document).ready(function() {
            $('#coupons').DataTable({
                "processing": true,
                "serverSide": true,
                "searching":false,
                "bFilter":false,
                "lengthChange": false,
                "pageLength": 20,
                "ajax": {
                    "url": "/admin/get/coupons",
                    "type": "GET",
                },
                columns: [
                    {data: 'id'},
                    {data: 'name'},
                    {data: 'active'},
                ]
            });
        });
    </script>
@endpush