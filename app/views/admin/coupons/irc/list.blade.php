@extends('layouts.default')

@section('content')
    <style>
        .backgroundChange{
            background: red !important;
        }
    </style>
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
                    <i class="fa fa-users"></i>Instant Rebate Programs
                </div>
                <a href="/admin/coupons/irc/create" class="btn red pull-right" role="button">Add New IRC Coupon <i
                        class="fa fa-plus"></i></a>
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
                    {{-- Date picker : Start date --}}

                    <div class="col-md-2 top-5">

                        <div class="form-group">

                            <div class="input-group datePicker" data-grid="standard" data-range-filter>

                                <input type="text" data-format="MM DD, YYYY" disabled class="form-control"
                                    data-range-start data-range-filter="created_at" data-label="Created At"
                                    placeholder="Start Date">

                                <span class="input-group-addon" style="cursor: pointer;"><i
                                        class="fa fa-calendar"></i></span>

                            </div>

                        </div>

                    </div>

                    {{-- Date picker : End date --}}
                    <div class="col-md-2">

                        <div class="form-group">

                            <div class="input-group datePicker" data-grid="standard" data-range-filter>

                                <input type="text" data-format="MM DD, YYYY" disabled class="form-control"
                                    data-range-end data-range-filter="created_at" data-label="Created At"
                                    placeholder="End Date">

                                <span class="input-group-addon" style="cursor: pointer;"><i
                                        class="fa fa-calendar"></i></span>

                            </div>

                        </div>

                    </div>



                    <div class="col-md-6">

                        <form data-search data-grid="standard" class="form-inline" role="form">
                            <div class="form-group">

                                <select name="column" class="form-control">
{{--                                    <option value="id">ID</option>--}}
                                    <option value="active">Active</option>
                                    <option value="barcode">Barcode</option>
                                    <option value="brand">Brand</option>
                                    <option value="circulation">Circulation</option>
                                    <option value="coupon_type">Coupon Type</option>
                                    <option value="value">Dollar Value</option>
                                    <option value="expires">Expires</option>
                                    <option value="name">Program Name</option>
                                    <option value="user">Program Owner</option>
                                    <option value="receive_by">Receive by</option>
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

                        <button name="export" type="button" class="btn btn-default dropdown-toggle"
                            data-toggle="dropdown">
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

                            <table class="table table-striped table-bordered table-hover" id="tbldata"
                                data-source="{{ URL::to('coupon_irc_source') }}" data-grid="standard">

                                <thead>
                                    <tr>
                                        <th class="sortable col-md-1" data-grid="standard" data-sort="id">ID</th>
                                        <th class="sortable col-md-2" data-grid="standard" data-sort="name">Program Name
                                        </th>
                                        <th class="sortable col-md-1" data-grid="standard" data-sort="coupon_type">
                                            Coupon Type</th>
                                        <th class="sortable col-md-1" data-grid="standard" data-sort="expires">Expires
                                        </th>
                                        <th class="sortable col-md-1" data-grid="standard" data-sort="receive_by">
                                            Receive By
                                        </th>
                                        <th class="sortable col-md-1" data-grid="standard" data-sort="user">Program
                                            Owner</th>
                                        <th class="sortable col-md-1" data-grid="standard" data-sort="active">Active
                                        </th>
                                        <th class="sortable col-md-1" data-grid="standard" data-sort="created_at">
                                            Created</th>
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

                @include('templates/coupons/irc/results')
                @include('templates/coupons/irc/no_results')
                @include('templates/coupons/irc/pagination')
                @include('templates/coupons/irc/filters')
                @include('templates/coupons/irc/no_filters')
            </div>
        </div>
    </div>
    <!-- END PAGE CONTENT-->
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
    $(document).on('click', '.btndelt', function () {
        var id=$(this).data("id");
        let data = $('#tr-'+id).find('td').each (function() {
            $(this).addClass("backgroundChange");
        });
        var m = '#tr-'+id+' td'
        console.log(data.selector == m);

        setTimeout(function () {
            var r = window.confirm("Are you sure you want to delete this item?");
            console.log('check r status');
            console.log(r);
            if(r == false) {
                $('#tr-'+id).find('td').each (function() {
                    $(this).removeClass("backgroundChange");
                });
            }
        if (r == true) {
            //alert(id);
            data = {
            "_token": "{{ csrf_token() }}",
            "id":id,
            }
            var url = "/admin/coupons/irc/delete";

            $.ajax({
                type: "post",
                url: url,
                data:data,
                success: function(data) {
                    var responce = JSON.parse(data);
                    if (responce['success'] == true)
                    {
                        alert("Data deleted");
                        location.reload(true);
                    }
                    else
                        alert("There is an error")
                },
                error: function() {
                    alert("There is an Error");
                },
            });
            
        }
        },50);
    });
    // $(".btndelt").on('click', function() {
    //     alert("OK");
    //     var r = confirm("Confirm Delete!");
    //     if (r == true) {
    //         data = {
    //         "_token": "{{ csrf_token() }}",
    //         }
    //         var url = "coupons/irc/"+$(this).data("id");

    //         $.ajax({
    //             type: "post",
    //             url: url,
    //             data:data,


    //         });
            
    //     } else {
            
            
    //     }
    // });
</script>
@endpush