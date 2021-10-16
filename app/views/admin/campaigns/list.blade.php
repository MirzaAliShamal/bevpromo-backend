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
                    <i class="fa fa-users"></i>All Campaigns
                </div>
                {{-- Export button --}}
                <div class="pull-right">

                    <div class="btn-group">

                        <form target="_blank" method="POST" action="" id="exportForm">
                            <button name="export" type="button" class="btn btn-default dropdown-toggle"
                                data-toggle="dropdown">
                                Export <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="javascript:void(0)" id="exportCsv" data-grid="standard"
                                        data-download="csv">Export to CSV</a>
                                </li>
                                <li><a href="javascript:void(0)" id="exportJson" data-grid="standard"
                                        data-download="json">Export to JSON</a>
                                </li>
                                <li><a href="javascript:void(0)" id="exportPdf" data-grid="standard"
                                        data-download="pdf">Export to PDF</a>
                                </li>
                            </ul>
                        </form>
                    </div>
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
                    <div class="row">
                        <div class="col-md-2">
                            <!-- Make it dynamic -->
                            <label>Campaign Type</label>
                            <div class="form-group">
                                <select name="campaign-type" class="form-control" id="campaign-type">
                                    <option value="0">All Campaign Type</option>
                                    @foreach ($campaigns as $key=>$value)
                                    @if($value != 'N/A')
                                    <option value="{{ $key }}" data-filter-val="{{ $value }}"
                                        data-filter="campaign_type">{{ $value }}</option>
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <!-- Make it dynamic -->
                            <label>Select Coupon</label>
                            <div class="form-group">
                                <select class="form-control" id="couponSearch">
                                </select>
                            </div>
                        </div>

                        {{-- Date picker : Start date --}}
                        <div class="col-md-2">

                            <div class="form-group">

                                <div class="input-group datePicker" data-grid="standard" data-range-filter>
                                    <label>Start Date</label>
                                    <input type="date" class="form-control" id="startDate">

                                </div>

                            </div>

                        </div>
                        {{-- Date picker : End date --}}
                        <div class="col-md-2">

                            <div class="form-group">

                                <div class="input-group datePicker" data-grid="standard" data-range-filter>
                                    <label>End Date</label>
                                    <input type="date" class="form-control" id="endDate">
                                </div>

                            </div>

                        </div>
                    </div>
                    <div class="row" style="padding-bottom: 10px;">
                        <div class="col-md-4 coupon-type-filter">

                            <div class="form-inline">
                                <div class="form-group">

                                    <select name="column-coupon-type" class="form-control">
                                        <option value="customer_id">ID</option>
                                        <option value="coupon_id">Coupon Id</option>
                                        <option value="name">Program Name</option>
                                        <option value="coupon_type">Type</option>
                                        <option value="barcode">Barcode</option>
                                        <option value="active">Active</option>
                                        <option value="user">Program Owner</option>
                                        <option value="brand">Brand</option>
                                        <option value="campaign_type">Campaign Type</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <input type="text" name="text-coupon-type" placeholder="Type to Filter"
                                        class="form-control">
                                    <button type="button" class="btn btn-default apply">Add Filter</button>
                                </div>

                            </div>

                        </div>
                        {{-- Applied filters --}}
                        <div class="col-md-8" id="filter-bar-bottom">

                            <div class="applied-filters" data-grid="standard"></div>

                        </div>
                    </div>

                </div>

                {{-- Results --}}
                <div class="row">

                    <div class="col-lg-12">

                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover"
                                style="table-layout: fixed; width: 100%;word-wrap:break-word;" id="all-data">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Upc Images</th>
                                        <th>Rec Images</th>
                                        <th>DOB</th>
                                       <th>Gender</th>
                                        <th>Rebate Method</th>
                                        <th>Company Name</th>
                                        <th>Phone Num</th>
                                        <th>Email</th>
                                        <th>Street Address</th>
                                        <th>State</th>
                                        <th>Created</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>

                            </table>
                        </div>
                    </div>

                </div>

                {{-- Pagination --}}
                <footer id="pagination" data-grid="standard">

                </footer>
            </div>
        </div>
    </div>
    @include('admin.coupons.add-edit-model-popup');
    <!-- END PAGE CONTENT-->
</div>
</div>
@stop
@push('footer-script')
<script>
   function getFiltersArray() {
        let filters = [];
            $('.filters').each(function(i,obj) {
                    let data = {key: $(obj).data('filter'), value: $(obj).data('filter-val') };
                    filters.push(data);
                    return false;
                });
            return filters;    
        }

    function noFilterMessage() {
        let dateF = $('.dates').length;
            let filterF = $('.filters').length;
            if(dateF == 0 && filterF == 0) {
                let html = '<i>There are no filters applied.</i>';
                addFilterHtml(html);
                }
    }

    function populateTable() {
        $('#all-data').DataTable().clear().destroy();
        let campaign = $('#campaign-type').find(':selected').val();
        let startDate = '';
        let endDate = '';
        let filters = getFiltersArray();
        if(filters.length == 0) {
            noFilterMessage();
        }
        $('.dates').each(function(i,obj) {
            startDate = $(obj).data("start");
            endDate = $(obj).data("end");
        });
        $('#all-data').DataTable({
                "processing": true,
                "searching": false,
                "lengthChange":false,
                "serverSide": true,
                "bStateSave": true,
                "columnDefs": [
                    { "width": "15px", "targets": 0 },
                    { "width": "60px", "targets": 7 },
                    { "width": "44px", "targets": 8 },
                    { "width": "47px", "targets": 9 },  
                    { "width": "44px", "targets": 10 },                 
                    ],
                "ajax": {
                    "url": "/admin/entries/campaigns/data",
                    "type": "POST",
                    "data": {
                        "campaign": campaign,
                        "filters": filters,
                        "startDate": startDate,
                        "endDate": endDate
                    }
                },
                columns: [
                    { data: 'customer_id', name: 'customer_id' },
                    { data: 'customer_name', name: 'customer_name' },
                    { data: "upc_images", "name": "upc_images", "render": function(data, type, row, meta) {
                        if(row.upc_images != 'N/D') {
                            let ul = "<ul>";
                            $.each(row.upc_images, function(i, item) {
                                let url = '<?php echo Constant::$assetLink ?>';
                                url += "entries/" + row.coupon_id + "/" + item;
                                ul += "<li><a href="+ url +" target='_blank'>Image - " + i + "</a></li>";
                            });
                            ul += "</ul>";
                            return ul;
                        }
                        else {
                            return "N/D";
                        }
                    }, 
                    },
                    { data: "rec_images", "name": "rec_images", "render": function(data, type, row, meta) {
                        if(row.rec_images != 'N/D') {
                            let ul = "<ul>";
                            $.each(row.rec_images, function(i, item){
                                let url = '<?php echo Constant::$assetLink ?>';
                                url += "entries/" + row.coupon_id + "/" + item;
                                ul += "<li><a href="+ url +" target='_blank'>Image - " + i + "</a></li>";
                            });
                            ul += "</ul>";
                            return ul;
                        }
                        else {
                            return "N/D";
                        }
                    }, 
                    },
                    { data: 'dob', name: 'dob' },
                    { data: 'gender', name: 'gender' },
                    { data: 'rebate_method', name: 'rebate_method' },
                    { data: 'company_name', name: 'company_name' },
                    { data: 'phone_num', name: 'phone_num' },
                    { data: 'email', name: 'email' },
                    { data: 'street_address', name: 'street_address' },
                    { data: 'state', name: 'state' },
                    { data: 'created_at', name: 'created_at'},
                    {
                        "data": "action",
                        "name": "action",
                        "render": function ( data, type, row, meta ) {
                                return "<div class='btn-group'><button type='button' class='btn btn-default dropdown-toggle' data-toggle='dropdown'>Action <span class='caret'></span></button><ul class='dropdown-menu' role='menu'><li class='divider'></li><li><a href='#'>Make Payment</a></li></ul></div>";
                         },
                    },
                ]
            });
    }
    $(document).ready(function() {
            $("#couponSearch").select2({
                minimumInputLength: 2,
                ajax: {
                    url: '/admin/all-coupons-opt',
                    dataType: 'json',
                    type: "POST",
                    data: function (term) {
                        return {
                            term: term
                            };
                            },
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.name,
                            id: item.id,
                        }
                    })
                };
            }

        }
    });

        $('#campaign-type').change(function() {
            if($(this).val() == '0') {
                $('.filters').filter(function() {
                    return $(this).data('filter') === "campaign_type"
                    }).remove();
                    populateTable();
                    return;  
            }
            let column = $("#campaign-type").find(':selected').data('filter');
            let filterText = $("#campaign-type").find(':selected').data('filter-val');
            let filterExist = false;
            $('.filters').each(function(i,obj){
                if($(obj).data('filter-val') == filterText) {
                    filterExist = true;
                }
            });
            if(!filterExist) {
                let filterHtml = '<button class="btn btn-default filters" data-filter="'+ column +'" data-filter-val="'+ filterText +'"><em>' + filterText + ' in ' + column + ' </em> <span><i class="fa fa-times-circle"></i></span></button>';
                addFilterHtml(filterHtml);
            }
            populateTable();
        });

        $('#couponSearch').on("select2:select", function(e) { 
            let id = e.params.data.id;
            let text = e.params.data.text;
            //data-filter = id, data-filter-val = e.params.data.id
                let filterVal = id;
                let filterExist = false;
                $('.filters').each(function(i,obj){
                if($(obj).data('filter-val') == filterVal) {
                    filterExist = true;
                }
            });
            if(!filterExist) {
                let filterHtml = '<button class="btn btn-default filters" data-filter="id" data-filter-val="'+ id +'"><em>' + id + ' in coupons_id </em> <span><i class="fa fa-times-circle"></i></span></button>';
                addFilterHtml(filterHtml);
               $('#campaign-type').trigger('change');
            }
        });

        $('#campaign-type').trigger('change');

        $(document).on('click','.apply',function() {
            //Check for dropdown then, Get appropriate column and filter text:
            let type = $("#program-type").find(':selected').data('filter');
            let column = '';
            let filterText = '';
            column = $("select[name=column-coupon-type]").val();
            filterText = $("input[name=text-coupon-type]").val();
            let filterExist = false;
            if(filterText == '') {
                return;
            }
            $('.filters').each(function(i,obj){
                if($(obj).data('filter') == column) {
                    filterExist = true;
                }
            });
            if(!filterExist) {
                let filterHtml = '<button class="btn btn-default filters" data-filter="'+ column +'" data-filter-val="'+ filterText +'"><em>' + filterText + ' in ' + column + ' </em> <span><i class="fa fa-times-circle"></i></span></button>';
                addFilterHtml(filterHtml);
                $('#campaign-type').trigger('change');
            }
        });

        $('input[name=text-coupon-type]').on('keyup',function(e){
            if (e.keyCode === 13) {
                e.preventDefault();
                $('.apply').trigger('click');
            }
        });

        $(document).on('change','#endDate',function(){
            let sDate = $('#startDate').val();
            let eDate = $('#endDate').val();
            if(sDate == '') {
                return;
            }
            startDate = new Date(sDate);
            endDate = new Date(eDate);
            if(startDate > endDate) {
                return;
            } 
            else {
                let formattedStartDate = formateDate(startDate);
                let formattedEndDate = formateDate(endDate);
                $('.dates').remove();
                let filterHtml = '<button class="btn btn-default dates" data-start= "'+ $('#startDate').val() +'" data-end="' + $('#endDate').val() + '"><em>' + sDate + ' TO ' + eDate + ' </em> <span><i class="fa fa-times-circle"></i></span></button>';
                addFilterHtml(filterHtml);
                $('#campaign-type').trigger('change');
            }
        });

        $(document).on('change','#startDate',function(){
            let sDate = $('#startDate').val();
            let eDate = $('#endDate').val();
            if(eDate == '') {
                return;
            }
            startDate = new Date(sDate);
            endDate = new Date(eDate);
            if(startDate > endDate) {
                return;
            } 
            else {
                startDate = new Date(startDate);
                endDate = new Date(endDate);
                let formattedStartDate = formateDate(startDate);
                let formattedEndDate = formateDate(endDate);
                $('.dates').remove();
                let filterHtml = '<button class="btn btn-default dates" data-start= "'+ $('#startDate').val() +'" data-end="' + $('#endDate').val() + '"><em>' + sDate + ' TO ' + eDate + ' </em> <span><i class="fa fa-times-circle"></i></span></button>';
                addFilterHtml(filterHtml);
                $('#campaign-type').trigger('change');
            }
        });

        $(document).on('click','.fa-times-circle',function() {
            $(this).closest('button').remove();
            $('#campaign-type').trigger('change');
        });

        $(document).on('click','#exportCsv','click',function(){
            let startDate = '';
            let endDate = '';
            let filters = getFiltersArray();
            $('.dates').each(function(i,obj) {
                startDate = $(obj).data("start");
                endDate = $(obj).data("end");
            });
            $('#exportForm input').remove();
            $('#exportForm').attr('action', '/admin/entries/campaigns/export-csv');
            $('#exportForm').append('<input type="hidden" name="startDate" value="'+startDate+'" />');
            $('#exportForm').append('<input type="hidden" name="endDate" value="'+endDate+'" />');
            $('#exportForm').append('<input type="hidden" name="filters" value=' +JSON.stringify(filters)+ ' />');
            $('#exportForm').submit();
        });

        $(document).on('click','#exportJson',function(){
            let startDate = '';
            let endDate = '';
            let filters = getFiltersArray();
            $('.dates').each(function(i,obj) {
                startDate = $(obj).data("start");
                endDate = $(obj).data("end");
            });
            $('#exportForm input').remove();
            $('#exportForm').attr('action', '/admin/entries/campaigns/export-json');
            $('#exportForm').append('<input type="hidden" name="startDate" value="'+startDate+'" />');
            $('#exportForm').append('<input type="hidden" name="endDate" value="'+endDate+'" />');
            $('#exportForm').append('<input type="hidden" name="filters" value=' +JSON.stringify(filters)+ ' />');
            $('#exportForm').submit();
        });
        $(document).on('click','#exportPdf',function(){
            let startDate = '';
            let endDate = '';
            let filters = getFiltersArray();
            $('.dates').each(function(i,obj) {
                startDate = $(obj).data("start");
                endDate = $(obj).data("end");
            });
            $('#exportForm input').remove();
            $('#exportForm').attr('action', '/admin/entries/campaigns/export-pdf');
            $('#exportForm').append('<input type="hidden" name="startDate" value="'+startDate+'" />');
            $('#exportForm').append('<input type="hidden" name="endDate" value="'+endDate+'" />');
            $('#exportForm').append('<input type="hidden" name="filters" value=' +JSON.stringify(filters)+ ' />');
            $('#exportForm').submit();
        });
    });
</script>
@endpush