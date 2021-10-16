@extends('layouts.default-dt')

@section('content')
<style>
    .img-wraps .closes {
        position: absolute;
        top: 5px;
        right: 8px;
        z-index: 100;
        background-color: #FFF;
        padding: 4px 3px;
        color: #000;
        font-weight: bold;
        cursor: pointer;
        text-align: center;
        font-size: 22px;
        line-height: 10px;
        border-radius: 50%;
        border: 1px solid red;
    }
</style>

<div class="page-content-wrapper">
    <div class="loader_new" style="display:none;"></div>
    <div class="page-content">

        <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
        <div class="modal fade" id="send_payment" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="alert payment_msg" role="alert" style="display: none;"></div>
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h4 class="modal-title">Send Payment</h4>
                    </div>
                    <div class="modal-body">

                        <div class="">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Enter Amount</label>
                                <input type="text" class="form-control" id="amount" aria-describedby="emailHelp"
                                    placeholder="Enter amount">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="user_row_id" id="user_row_id" value="">
                        <button type="button" class="btn blue" onclick="send_paypal();">Send Payment</button>
                        <button type="button" class="btn default" data-dismiss="modal">Close</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->


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
                    <i class="fa fa-users"></i>Digital Rebate Programs
                </div>
                {{-- Export button --}}
                <div class="pull-right">
                    @if( Request::get('campaign'))

                    @else
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
                    @endif
                    <button id="openAddPopup" style="margin-left: 5px" class="btn red pull-right">Add New <i
                            class="fa fa-plus"></i></button>
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


                    <div class="row">
                        @if( Request::get('campaign'))
                        <div class="col-md-2" style="display: none">
                            <!-- Make it dynamic -->
                            <label>Campaign Type</label>
                            <div class="form-group">
                                <select class="form-control" id="campaign-type">
                                    <option value="0">All Campaign Type</option>
                                    @foreach ($campaigns as $key=>$value)
                                    @if($value != 'N/A')
                                    @if($campaign == 'dmir')
                                    <option value="{{ $key }}" data-filter-val="{{ $key }}" data-filter="campaign_type"
                                        @if($key==3) selected="selected" @endif>{{ $value }}</option>

                                    @elseif($campaign == 'sweepstakes')
                                    <option value="{{ $key }}" data-filter-val="{{ $key }}" data-filter="campaign_type"
                                        @if($key==4) selected="selected" @endif>{{ $value }}</option>
                                    @else
                                    <option value="{{ $key }}" data-filter-val="{{ $key }}" data-filter="campaign_type">
                                        {{ $value }}</option>
                                    @endif
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2" style="display: none">
                            <!-- Make it dynamic -->
                            <label>Select Program</label>
                            <div class="form-group">
                                <select class="form-control" id="program-type">
                                    <option value="0">All</option>
                                    @foreach ($programs as $item)
                                    {{ $program }}
                                    @if($item->name != '')
                                    @if($program == 'mir')
                                    <option value="{{ $item->id }}" data-filter="{{ $item->name }}" @if($item->id == 17)
                                        selected="selected" @endif>{{ $item->name }}
                                    </option>
                                    @else
                                    <option value="{{ $item->id }}" data-filter="{{ $item->name }}">{{ $item->name }}
                                    </option>
                                    @endif
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4" style="display: none">
                            <!-- Make it dynamic -->
                            <label>Select Coupon</label>
                            <div class="form-group">
                                <select class="form-control" id="couponSearch">
                                </select>
                            </div>
                        </div>
                        @else

                        <div class="col-md-2">
                            <!-- Make it dynamic -->
                            <label>Campaign Type</label>
                            <div class="form-group">
                                <select class="form-control" id="campaign-type">
                                    <option value="0">All Campaign Type</option>
                                    @foreach ($campaigns as $key=>$value)
                                    @if($value != 'N/A')
                                    @if($campaign == 'dmir')
                                    <option value="{{ $key }}" data-filter-val="{{ $key }}" data-filter="campaign_type"
                                        @if($key==3) selected="selected" @endif>{{ $value }}</option>

                                    @elseif($campaign == 'sweepstakes')
                                    <option value="{{ $key }}" data-filter-val="{{ $key }}" data-filter="campaign_type"
                                        @if($key==4) selected="selected" @endif>{{ $value }}</option>
                                    @else
                                    <option value="{{ $key }}" data-filter-val="{{ $key }}" data-filter="campaign_type">
                                        {{ $value }}</option>
                                    @endif
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <!-- Make it dynamic -->
                            <label>Select Program</label>
                            <div class="form-group">
                                <select class="form-control" id="program-type">
                                    <option value="0">All</option>
                                    @foreach ($programs as $item)
                                    {{ $program }}
                                    @if($item->name != '')
                                    @if($program == 'mir')
                                    <option value="{{ $item->id }}" data-filter="{{ $item->name }}" @if($item->id == 17)
                                        selected="selected" @endif>{{ $item->name }}
                                    </option>
                                    @else
                                    <option value="{{ $item->id }}" data-filter="{{ $item->name }}">{{ $item->name }}
                                    </option>
                                    @endif
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


                        @endif

                        {{-- Date picker : Start date --}}
                        <div class="col-md-2">

                            <div class="form-group">

                                <div class="input-group datePicker" data-grid="standard" data-range-filter>
                                    <label>Start Date</label>
                                    <input autocomplete='off' placeholder='mm/dd/yyyy' id="startDate" type='text'
                                        class='form-control datepicker-jq' required='' />

                                </div>

                            </div>

                        </div>
                        {{-- Date picker : End date --}}
                        <div class="col-md-2">

                            <div class="form-group">

                                <div class="input-group datePicker" data-grid="standard" data-range-filter>
                                    <label>End Date</label>
                                    <input autocomplete='off' placeholder='mm/dd/yyyy' id="endDate" type='text'
                                        class='form-control datepicker-jq1' required='' />
                                </div>

                            </div>

                        </div>

                        @if( Request::get('campaign'))
                        <div class="col-md-2 pull-right" style="padding-top:25px;">
                            <div class="form-inline">
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
                        @endif



                        <div class="col-md-4 irc-filter" style="display: none;">

                            <div class="form-inline">
                                <div class="form-group">

                                    <select name="column-irc" class="form-control" id="column">
                                        <option value="all">All</option>
                                        <option value="id">ID</option>
                                        <option value="retailer">Retailer</option>
                                        <option value="program">Coupon</option>
                                        <option value="coupon_id">Coupon Id</option>
                                        <option value="program">Program</option>
                                        <option value="coupon_quantity">Quantity</option>
                                        <option value="payable">Payable</option>
                                        <option value="clearinghouse">Clearinghouse</option>
                                        <option value="is_invoiced">Invoiced</option>
                                        <option value="campaign_type">Campaign Type</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <input type="text" name="text-irc" placeholder="Type to Filter"
                                        class="form-control">
                                    <button id="filter-text" type="button" class="btn btn-default apply">Add
                                        Filter</button>
                                </div>

                            </div>

                        </div>
                        <div class="col-md-4 mir-filter" style="display: none;">

                            <div class="form-inline">
                                <div class="form-group">

                                    <select name="column-mir" class="form-control">
                                        <option value="all">All</option>
                                        <option value="id">ID</option>
                                        <option value="retailer">Retailer</option>
                                        <option value="dollar_value">Dollar Value</option>
                                        <option value="first_name">First Name</option>
                                        <option value="last_name">Last Name</option>
                                        <option value="address">Address</option>
                                        <option value="city">City</option>
                                        <option value="state">State</option>
                                        <option value="zip">Zip</option>
                                        <option value="email">Email Address</option>
                                        <option value="birth_date">Birth Date</option>
                                        <option value="status">Status</option>
                                        <option value="denial_reason_id">Denial Reason</option>
                                        <option value="is_invoiced">Invoiced</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <input type="text" name="text-mir" placeholder="Type to Filter" class="form-control"
                                        id="filter-text">
                                    <button type="button" class="btn btn-default apply">Add Filter</button>
                                </div>

                            </div>

                        </div>
                        <div class="col-md-4 coupon-type-filter" style="display: none; padding-top:25px;">

                            <div class="form-inline">
                                <div class="form-group">

                                    <select name="column-coupon-type" class="form-control">
                                        <option value="all">All</option>
                                        <option value="id">ID</option>
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

                            <div class="applied-filters" data-grid="standard">
                                @if($campaign == 'dmir')
                                <button class="btn btn-default filters" data-filter="campaign_type" style="display:none"
                                    data-filter-val="3"><em>DIGITAL MIR in campaign_type </em> <span><i
                                            class="fa fa-times-circle"></i></span></button>
                                @elseif($campaign == 'sweepstakes')
                                <button class="btn btn-default filters" data-filter="campaign_type" style="display:none"
                                    data-filter-val="4"><em>SWEEPSTAKES in campaign_type </em> <span><i
                                            class="fa fa-times-circle"></i></span></button>
                                @elseif($campaign == 'MIR')
                                <button class="btn btn-default filters" data-filter="campaign_type" style="display:none"
                                    data-filter-val="4"><em>SWEEPSTAKES in campaign_type </em> <span><i
                                            class="fa fa-times-circle"></i></span></button>
                                @endif
                            </div>

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
                                        <th>Retailer</th>
                                        <th>Program</th>
                                        <th>Campaign Type</th>
                                        {{-- <th>Campaign Logo</th> --}}
                                        <th>Url</th>
                                        <th>Clearinghouse</th>
                                        <th>Invoiced?</th>
                                        <th>Quantity</th>
                                        <th>Payable</th>
                                        <th>Shipping</th>
                                        <th>Created</th>
                                        <th>Program Type</th>
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
    @include('admin.coupons.customer-details-popup');
    <!-- END PAGE CONTENT-->

    <!-- Modal -->
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header" style="background-color:#67809f;color:#fff;">
                    <h4 class="modal-title" style="font-size: 15px;
    font-weight: bold;">Add Denial Reasons</h4>
                    <i class="fa fa-times" data-dismiss="modal" aria-hidden="true" style="float: right;
    bottom: 20px;
    position: relative;"></i>
                </div>
                <form id="formData">
                    <div class="modal-body">
                        <div class="row">
                            <label class="col-md-2 control-label">Denial Reasons: </label>
                            <div class="radio-list col-md-10">
                                <input type="text" name="name" value="" id="reason_name" class="form-control" />
                            </div>
                        </div>
                        <br>
                        <br>
                        <div class="row">
                            <label class="col-md-2 control-label">Active: </label>
                            <div class="radio-list col-md-10">
                                <label class="radio-inline">
                                    <div class="radio"><span class="checked"><input id="active" class="radio-inline" checked="checked" name="active" type="radio" value="1"></span></div> Yes
                                    <div class="radio"><span><input class="radio-inline" id="in-active" style="margin-left: -9px;" name="active" type="radio" value="0"></span></div>
                                    No
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" onclick="submitForm()">save</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
</div>
@stop
@push('footer-script')
<script>

    function openDenialReasonPoPup(){
        $('#myModal').modal('show');
    }
    function submitForm(){
        let reason_name = $('#reason_name').val();
        let active = $('#active').prop('checked');
        let inActive = $('#in-active').prop('checked');
        let value = '';
        if(active) {
            value = 1;
        }
        if(inActive) {
            value = 0;
        }
        let form = new FormData();
        form.append('_token','{{csrf_token()}}');
        form.append('name',reason_name);
        form.append('value',value);
        $.ajax({
            method: 'post',
            processData: false,
            contentType: false,
            cache: false,
            url:'/admin/entries/mir/add/denial-reason',
            data:form,

            success: function (response){
                console.log('response');
                console.log(response);
                $('#myModal').modal('hide');
            },
            error: function (error){
                console.log('error');
                console.log(error);
            },
        });
    }

    function getFiltersArray() {
        let type = $("#program-type").find(':selected').data('filter');

        let campaignId = $("#campaign-type").find(':selected').val();

        let filters = [];
        let isExist = false;
        if (type == 'Mail-In Rebate') {
            $('.filters').each(function (i, obj) {
                $("select[name=column-mir] option").each(function () {
                    if ($(this).val() == $(obj).data('filter')) {
                        let data = {key: $(obj).data('filter'), value: $(obj).data('filter-val')};
                        filters.push(data);
                        $(obj).addClass('keepMe');
                        return false;
                    }
                });
            });
        } else if (type == 'IRC' || campaignId == '2') {
            $('.filters').each(function (i, obj) {
                $("select[name=column-irc] option").each(function () {
                    if ($(this).val() == $(obj).data('filter')) {
                        let data = {key: $(obj).data('filter'), value: $(obj).data('filter-val')};
                        filters.push(data);
                        $(obj).addClass('keepMe');
                        return false;
                    }
                });
            });
        }
            
        else {

            $('.filters').each(function (i, obj) { 
                // Below code does not executes 
                $("select[name=column-coupon-type] option").each(function () {
                    if ($(this).val() == $(obj).data('filter')) {
                        let data = {key: $(obj).data('filter'), value: $(obj).data('filter-val')};
                        filters.push(data);
                        $(obj).addClass('keepMe');
                        return false;
                    }
                });       
            });
        }
        var campaign = $('#campaign-type').val();
        if(campaign != 0) {
            $('.filters').each(function (i, obj) {
                $("#campaign-type").each(function () {
                    console.log(obj);
                    if ($(this).val() == $(obj).data('filter-val')) {
                        let data = {key: $(obj).data('filter'), value: $(obj).data('filter-val')};
                        filters.push(data);
                        $(obj).addClass('keepMe');
                        return false;
                    }
                });
            });
        }
        $('.filters').not('.keepMe').remove();
        return filters;
    }

    function noFilterMessage() {
        let dateF = $('.dates').length;
        let filterF = $('.filters').length;
        if (dateF == 0 && filterF == 0) {
            let html = '<i>There are no filters applied.</i>';
            addFilterHtml(html);
        }
    }

    function populateIrcTable() {
        let filter = $('#program-type').find(':selected').data('filter');
        let programId = $('#program-type').find(':selected').val();
        let campaignId = $('#campaign-type').find(':selected').val();
        let startDate = '';
        let endDate = '';
        let filters = getFiltersArray();

        // let filters = getFiltersArray();
        if (filters.length == 0) {
            noFilterMessage();
        }
        $('.dates').each(function (i, obj) {
            startDate = $(obj).data("start");
            endDate = $(obj).data("end");
        });
        $('#all-data').DataTable({
            "processing": true,
            "searching": false,
            "lengthChange": false,
            "serverSide": true,
            "bStateSave": true,
            "columnDefs": [
                {"width": "15px", "targets": 0},
                {"width": "60px", "targets": 1},
                {"width": "45px", "targets": 2},
                {"width": "30px", "targets": 8},
            ],
            "ajax": {
                "url": "/admin/entries/data",
                "type": "POST",
                "data": {
                    "program-type": filter,
                    "program-id": programId,
                    "campaign-id": campaignId, 
                    "filters": filters,
                    "startDate": startDate,
                    "endDate": endDate
                }
            },
            columns: [
                {data: 'id', name: 'id'},
                {data: 'retailer', name: 'retailer'},
                {data: 'program', name: 'program'},
                {data: 'campaign_type', name: 'campaign_type'},
                {data: 'clearinghouse', name: 'clearinghouse'},
                {data: 'is_invoiced', name: 'is_invoiced'},
                {data: 'coupon_quantity', name: 'coupon_quantity'},
                {data: 'payable', name: 'payable'},
                {data: 'shipping', name: 'shipping'},
                {data: 'created_at', name: 'created_at'},
                {
                    "data": "program_type",
                    "name": "program_type",
                    "render": function (data, type, row, meta) {
                        return "IRC"
                    },
                },
                {
                    "data": "action",
                    "name": "action",
                    "render": function (data, type, row, meta) {
                        return "<div class='btn-group'><button type='button' class='btn btn-default dropdown-toggle' data-toggle='dropdown'>Action <span class='caret'></span></button><ul class='dropdown-menu' role='menu'><li><a href='#' data-id=" + row.id + " class='openEditForm'><i class='fa fa-pencil'></i> Edit </a></li><li><a href='javascript:;' data-id=" + row.id + " class='openCustomerDetails'> Details </a></li><li class='divider'></li><li><a href='#'>Make Payment</a></li></ul></div>";
                    },
                },
            ]
        });
    }
    function populateMirTable() {
        let filter = $('#program-type').find(':selected').data('filter');
        let startDate = '';
        let endDate = '';
        let programId = $('#program-type').find(':selected').val();
        let campaignId = $('#campaign-type').find(':selected').val();
        let filters = getFiltersArray();
         
        if (filters.length == 0) {
            noFilterMessage();
        }
        $('.dates').each(function (i, obj) {
            startDate = $(obj).data("start");
            endDate = $(obj).data("end");
        });
        $('#all-data').DataTable({
            "processing": true,
            "searching": false,
            "lengthChange": false,
            "serverSide": true,
            "bStateSave": true,
            "columnDefs": [
                {"width": "15px", "targets": 0},
                {"width": "60px", "targets": 1},
                {"width": "45px", "targets": 2},
                {"width": "30px", "targets": 8},
            ],
            "ajax": {
                "url": "/admin/entries/data",
                "type": "POST",
                "data": {
                    "program-type": filter,
                    "program-id": programId,
                    "campaign-id": campaignId, 
                    "filters": filters,
                    "startDate": startDate,
                    "endDate": endDate
                }
            },
            columns: [
                {data: 'id', name: 'id'},
                {data: 'retailer', name: 'retailer'},
                {data: 'coupon', name: 'coupon'},
                {data: 'owner', name: 'owner'},
                {data: 'first_name', name: 'first_name'},
                {data: 'last_name', name: 'last_name'},
                {data: 'address', name: 'address'},
                {data: 'city', name: 'city'},
                {data: 'state', name: 'state'},
                {data: 'zip', name: 'zip'},
                {data: 'status', name: 'status'},
                {data: 'status', name: 'paid_status'},
                {data: 'created_at', name: 'created_at'},
                {
                    "data": "action",
                    "name": "action",
                    "render": function (data, type, row, meta) {
                        return "<div class='btn-group'><button type='button' class='btn btn-default dropdown-toggle' data-toggle='dropdown'>Action <span class='caret'></span></button><ul class='dropdown-menu' role='menu'><li><a href='#' data-id=" + row.id + " class='openEditForm'><i class='fa fa-pencil'></i> Edit </a></li><li><a href='javascript:;' data-id=" + row.id + " class='openCustomerDetails'> Details </a></li><li class='divider'></li><li><a href='#'>Make Payment</a></li></ul></div>";
                    },
                },
            ]
        });
    }
    function populateTable() {
        // filter to apply filter on program type like programId
        let filter = $('#program-type').find(':selected').data('filter');
        let programId = $('#program-type').find(':selected').val();
        let campaignId = $('#campaign-type').find(':selected').val();
        let startDate = '';
        let endDate = '';

        let filters = getFiltersArray();
        

        if (filters.length == 0) {
            noFilterMessage();
        }
        $('.dates').each(function (i, obj) {
            startDate = $(obj).data("start");
            endDate = $(obj).data("end");
        });
        $('#all-data').DataTable({
            "processing": true,
            "searching": false,
            "lengthChange": false,
            "serverSide": true,
            "bStateSave": true,
            "columnDefs": [
                {"width": "15px", "targets": 0},
                {"width": "60px", "targets": 1},
                {"width": "45px", "targets": 2},
                {"width": "30px", "targets": 8},
            ],
            "ajax": {
                "url": "/admin/entries/data",
                "type": "POST",
                "data": {
                    "program-type": filter,
                    "program-id": programId,
                    "campaign-id": campaignId, 
                    "filters": filters,
                    "startDate": startDate,
                    "endDate": endDate
                }
            },
            columns: [
                {data: 'id', name: 'id'},
                {data: 'retailer', name: 'retailer'},
                {data: 'coupon', name: 'coupon'},
                {data: 'owner', name: 'owner'},
                {data: 'first_name', name: 'first_name'},
                {data: 'last_name', name: 'last_name'},
                {data: 'address', name: 'address'},
                {data: 'city', name: 'city'},
                {data: 'state', name: 'state'},
                {data: 'zip', name: 'zip'},
                {data: 'status', name: 'status'},
                {data: 'created_at', name: 'created_at'},
                {
                    "data": "action",
                    "name": "action",
                    "render": function (data, type, row, meta) {
                        return "<div class='btn-group'><button type='button' class='btn btn-default dropdown-toggle' data-toggle='dropdown'>Action <span class='caret'></span></button><ul class='dropdown-menu' role='menu'><li><a href='#' data-id=" + row.id + " class='openEditForm'><i class='fa fa-pencil'></i> Edit </a></li><li><a href='javascript:;' data-id=" + row.id + " class='openCustomerDetails'> Details </a></li><li class='divider'></li><li><a href='#'>Make Payment</a></li></ul></div>";
                    },
                },
            ]
        });
    }

    function send_paypal() {
        var amount = $("#amount").val();
        var row_id = $("#user_row_id").val();
        var count_error = 0;
        if (amount == '' || amount == 0) {
            $("#amount").parent('div').addClass('has-error')
        } else {
            $("#amount").parent('div').removeClass('has-error')
        }

        if (count_error == 0) {
            $(".loader_new").show();
            $.ajax({
                type: 'POST',
                url: '/admin/entries/payment',
                data: 'row_id=' + row_id + '&amount=' + amount,
                dataType: 'json',
                success: function (msg) {
                    if (msg.status == '1') {
                        $(".payment_msg").addClass('alert-success');
                        $(".payment_msg").removeClass('alert-danger');
                    } else {
                        $(".payment_msg").removeClass('alert-success');
                        $(".payment_msg").addClass('alert-danger');
                    }
                    $(".payment_msg").html(msg.msg);
                    $(".payment_msg").show();
                    $(".loader_new").hide();
                },
                error: function (msg) {
                    $(".loader_new").hide();
                }
            })
        }

    }

    function send_payment(id) {
        //alert(id)
        $(".payment_msg").hide();
        $("#amount").val('');
        $("#send_payment").modal('show');
        $("#user_row_id").val(id);
    }

    function showFilters() {
        let selection = $('#campaign-type').find(':selected').data('filter-val');
        
        if (selection == 1) {
            $('.mir-filter').show();
            $('.irc-filter').hide();
            $('.coupon-type-filter').hide();
        } else if (selection == 2) {
            $('.irc-filter').show();
            $('.mir-filter').hide();
            $('.coupon-type-filter').hide();
        } else {
            $('.coupon-type-filter').show();
            $('.irc-filter').hide();
            $('.mir-filter').hide();
        }
    }

    

    $(document).ready(function () {
        
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
        $('#program-type').change(function (e, i) {
            $('#all-data').DataTable().clear().destroy();
            
            // Below method shows columns in Add Filter selectBox
            // According to campaign type selected.
            showFilters();

            // dateF = 1 if dates are given
            let dateF = $('.dates').length;
            
            let filterF = $('.filters').length;
            // track the number f filters applied except date
            // if coupon search and add filter are given then 
            // its length would be 2. if one of them is given then length // would be 1
            
            
            // true if no filters are applied.
            if (dateF == 0 && filterF == 0) {
                let html = '<i>There are no filters applied.</i>';
                // where is below method defined?
                addFilterHtml(html);
            }
            //data-name
            let type = $(this).find(':selected').data('filter');
            let campaignId = $('#campaign-type').find(':selected').val(); 
            let programId = $('#program-type').find(':selected').val(); 
            

            if (type == 'Mail-In Rebate') {
                let tr = '';
                tr += '<tr>';
                tr += '<th>ID</th>';
                tr += '<th>Retailer</th>';
                tr += '<th>Program</th>';
                tr += '<th>Owner</th>';
                tr += '<th>FName</th>';
                tr += '<th>LName</th>';
                tr += '<th>Address</th>';
                tr += '<th>City</th>';
                tr += '<th>State</th>';
                // tr += '<th>Logo</th>';
                tr += '<th>Zip</th>';
                tr += '<th>Status</th>';
                tr += '<th>Paid Status</th>';
                tr += '<th>Created</th>';
                tr += '<th>Action</th>';
                tr += '</tr>';
                $('#all-data thead').html(tr);
                populateMirTable();
            } else if (type == 'IRC' || campaignId == '2') {
                
                let tr = '';
                tr += '<tr>';
                tr += '<th>ID</th>';
                tr += '<th>Retailer</th>';
                tr += '<th>Program</th>';
                tr += '<th>Campaign Type</th>'
                // tr += '<th>Campaign Logo</th>'
                tr += '<th>Clearinghouse</th>';
                tr += '<th>Invoiced?</th>';
                tr += '<th>Quantity</th>';
                tr += '<th>Payable</th>';
                tr += '<th>Shipping</th>';
                tr += '<th>Created</th>';
                tr += '<th>Program Type</th>';
                tr += '<th>Action</th>';
                tr += '</tr>';
                $('#all-data thead').html(tr);
                populateIrcTable();
            }
            // else if (campaignId == '1'){
                
            //     let tr = '';
            //     tr += '<tr>';
            //     tr += '<th>ID</th>';
            //     tr += '<th>Retailer</th>';
            //     tr += '<th>Coupon</th>';
            //     tr += '<th>Owner</th>';
            //     tr += '<th>FName</th>';
            //     tr += '<th>LName</th>';
            //     tr += '<th>Address</th>';
            //     tr += '<th>City</th>';
            //     tr += '<th>State</th>';
            //     tr += '<th>CType</th>';
            //     // tr += '<th>Logo</th>';
            //     tr += '<th>Zip</th>';
            //     tr += '<th>Status</th>';
            //     tr += '<th>Created</th>';
            //     tr += '<th>Action</th>';
            //     tr += '</tr>';
            //     $('#all-data thead').html(tr);
            //     populateMirTable();
            // }
            // else if (campaignId == '2'){
                
            //     let tr = '';
            //     tr += '<tr>';
            //     tr += '<th>ID</th>';
            //     tr += '<th>Retailer</th>';
            //     tr += '<th>Coupon</th>';
            //     tr += '<th>Campaign Type</th>'
            //     // tr += '<th>Campaign Logo</th>'
            //     tr += '<th>Clearinghouse</th>';
            //     tr += '<th>Invoiced?</th>';
            //     tr += '<th>Quantity</th>';
            //     tr += '<th>Payable</th>';
            //     tr += '<th>Shipping</th>';
            //     tr += '<th>Created</th>';
            //     tr += '<th>Program Type</th>';
            //     tr += '<th>Action</th>';
            //     tr += '</tr>';
            //     $('#all-data thead').html(tr);
            //     populateIrcTable();
            // }
            else {
                let tr = '';
                tr += '<tr>';
                tr += '<th>ID</th>';
                tr += '<th>Retailer</th>';
                tr += '<th>Program</th>';
                tr += '<th>Owner</th>';
                tr += '<th>FName</th>';
                tr += '<th>LName</th>';
                tr += '<th>Address</th>';
                tr += '<th>City</th>';
                tr += '<th>State</th>';
                // tr += '<th>Logo</th>';
                tr += '<th>Zip</th>';
                tr += '<th>Status</th>';
                tr += '<th>Created</th>';
                tr += '<th>Action</th>';
                tr += '</tr>';
                $('#all-data thead').html(tr);
                populateTable();
            }
        });
        $('#program-type').trigger('change');
        $('#couponSearch').on("select2:select", function (e) {
            let id = e.params.data.id;
            let text = e.params.data.text;
            
            //data-filter = id, data-filter-val = e.params.data.id
            let filterVal = id;
            let filterExist = false;
            $('.filters').each(function (i, obj) {
                if ($(obj).data('filter-val') == filterVal) {
                    filterExist = true;
                }
            });
            
            // Code to Apply Filter
            if (!filterExist) {
                let filterHtml = '<button class="btn btn-default filters" data-filter="coupon_id" data-filter-val="' + id + '"><em>' + id + ' in coupons_id </em> <span><i class="fa fa-times-circle"></i></span></button>';
                addFilterHtml(filterHtml);
                $('#program-type').trigger('change');
            }
        });

        $(document).on('click','.openCustomerDetails', function() {
            var id = $(this).data('id');
            $.ajax({
                url: '/admin/entries/mir/details/' + id,
                success: function(data) {
                    var finalHtml = JSON.parse(data);
                    $('#customerData').html(finalHtml);
                },
                error: function() {
                    alert("There is an Error");
                },
                complete: function() {
                    $('#customerDetailsModel').modal();
                }
            });
        });

        $(document).on('click', '.openEditForm', function () {
            let id = $(this).data('id');
            $('.clsLoader').show();
            let type = $('#program-type').find(':selected').data('filter');
            let url = '';
            if (type == 'Mail-In Rebate') {
                url = '/admin/entries/mir/' + id + '/ajax-add-edit';
            } else if (type == 'IRC') {
                url = '/admin/entries/irc/' + id + '/ajax-add-edit';
            } else {
                url = '/admin/entries/mir/' + id + '/ajax-add-edit';
            }
            $.ajax({
                url: url,
                success: function (html) {
                    let finalHtml = JSON.parse(html);
                    $('#addEditForm').html(finalHtml);
                    $('.clsLoader').hide();
                },
                error: function () {
                    $('.clsLoader').hide();
                    alert("There is an error");
                },
                complete: function () {
                    $('.clsLoader').hide();
                    $('#addEditModelPopup').modal();
                    let dropzoneControl = $('#upc-upload')[0].dropzone;
                    if(dropzoneControl) {
                        dropzoneControl.destroy();
                    }
                    Dropzone.autoDiscover = false;
                    var myDropzone = new Dropzone("div#upc-upload", {
                        addRemoveLinks: true,
                        url: "/admin/upc-upload",
                        init: function() {
                            this.on("sending", function(file, xhr, formData) {
                                var customer_id = $('#customer_id').val();
                                formData.append("customer_id", customer_id);
                            });
                            this.on('removedfile', function(file){
                                var id = file.id;
                                var customer_id = $('#customer_id').val();
                                //There can be an issue if user two users at the same time uploaded to the
                                //server same type of images
                                //Need to handle this scenario in sweepstakes.
                                $.ajax({
                                    type: "POST",
                                    url: '/admin/delete-upc-image',
                                    data: {'id': id, 'customer_id': customer_id },
                                    success: function (data) {
                                        res = JSON.parse(data);
                                        var html = res['html'];
                                        $('#upc_uploaded_images').html(html);
                                    },
                                    error: function (error) {
                                        let response = error['responseText'];
                                        alert("Sorry, There is An error " + response);
                                    }
                                });
                            });
                            this.on('success',function(file, response) {
                                res = JSON.parse(response);
                                if(res['success'] == true) {
                                    file.id = res['id'];
                                    var html = res['html'];
                                    $('#upc_uploaded_images').html(html);
                                }
                            });
                        },
                    });

                    myDropzone.on('complete', function (response)
                    {
                        $(".dz-preview").remove();
                        $(".dz-message").show();
                    });

                    let dropzoneControl1 = $('#rec-upload')[0].dropzone;
                    if(dropzoneControl1) {
                        dropzoneControl1.destroy();
                    }
                    Dropzone.autoDiscover = false;
                    var myDropzone2 = new Dropzone("div#rec-upload", {
                        addRemoveLinks: true,
                        url: "/admin/rec-upload",
                        init: function() {
                            this.on("sending", function(file, xhr, formData) {
                                var customer_id = $('#customer_id').val();
                                formData.append("customer_id", customer_id);
                            });
                            this.on('removedfile', function(file){
                                var id = file.id;
                                var customer_id = $('#customer_id').val();
                                //There can be an issue if user two users at the same time uploaded to the
                                //server same type of images
                                //Need to handle this scenario in sweepstakes.
                                $.ajax({
                                    type: "POST",
                                    url: '/admin/delete-rec-image',
                                    data: {'id': id, 'customer_id': customer_id },
                                    success: function (data) {
                                        res = JSON.parse(data);
                                        var html = res['html'];
                                        $('#rec_uploaded_images').html(html);
                                    },
                                    error: function (error) {
                                        let response = error['responseText'];
                                        alert("Sorry, There is An error " + response);
                                    }
                                });
                            });
                            this.on('success',function(file, response) {
                                res = JSON.parse(response);
                                if(res['success'] == true) {
                                    file.id = res['id'];
                                    var html = res['html'];
                                    $('#rec_uploaded_images').html(html);
                                }
                            });
                        },
                    });

                    myDropzone2.on('complete', function (response)
                    {
                        $(".dz-preview").remove();
                        $(".dz-message").show();
                    });

                    $('.clsLoader').hide();
                }
            });
        });

        $(document).on('click','.deleteUpcImage',function(){
            $(this).remove();
            var imageId = $(this).data('id');
            var customerId = $(this).data('customer-id');
            var formData = {'id':imageId, 'customer_id': customerId};
            url = '/admin/delete-upc-image';
            $.ajax({
                type: "POST",
                url: url,
                data: formData,
                dataType: "json",
                /* processData: false,
                contentType: false, */
                success: function(data) {
                    $('.delete_'+imageId).remove();
                },
                error: function(error) {
                    let response = error['responseText'];
                    alert("Sorry, There is An error " + response);
                }
            });

        });

        $(document).on('click','.deleteRecImage',function(){
            $(this).remove();
            var imageId = $(this).data('id');
            var customerId = $(this).data('customer-id');
            var formData = {'id':imageId, 'customer_id': customerId};
            url = '/admin/delete-rec-image';
            $.ajax({
                type: "POST",
                url: url,
                data: formData,
                dataType: "json",
                /* processData: false,
                contentType: false, */
                success: function(data) {
                    $('.delete_'+imageId).remove();
                },
                error: function(error) {
                    let response = error['responseText'];
                    alert("Sorry, There is An error " + response);
                }
            });

        });

        $(document).on('click', '#openAddPopup', function () {
            $('.clsLoader').show();
            let type = $('#program-type').find(':selected').data('filter');
            let id = 0;
            let url = '';
            console.log(type);
            let campaign = '{{$campaign}}';
            console.log('campaign');
            console.log(campaign);
            if (type == 'Mail-In Rebate') {
                url = '/admin/entries/mir/' + id + '/ajax-add-edit?campaign='+campaign;
            } else if (type == 'IRC') {
                url = '/admin/entries/irc/' + id + '/ajax-add-edit?campaign='+campaign;
            } else {
                url = '/admin/entries/mir/' + id + '/ajax-add-edit?campaign='+campaign;
            }
            $.ajax({
                url: url,
                success: function (html) {
                    let finalHtml = JSON.parse(html);
                    $('#addEditForm').html(finalHtml);
                    $('.clsLoader').hide();
                },
                error: function () {
                    $('.clsLoader').hide();
                    alert("There is an error");
                },
                complete: function () {
                    $('.clsLoader').hide();
                    $('#addEditModelPopup').modal();
                    let dropzoneControl = $('#upc-upload1')[0].dropzone;
                    if(dropzoneControl) {
                        dropzoneControl.destroy();
                    }
                    Dropzone.autoDiscover = false;
                    var myDropzone = new Dropzone("div#upc-upload1", {
                        addRemoveLinks: true,
                        url: "/admin/upc-upload",
                        init: function() {
                            this.on("sending", function(file, xhr, formData) {
                                var customer_id = $('#customer_id').val();
                                formData.append("customer_id", customer_id);
                            });
                            this.on('removedfile', function(file){
                                var id = file.id;
                                var customer_id = $('#customer_id').val();
                                //There can be an issue if user two users at the same time uploaded to the
                                //server same type of images
                                //Need to handle this scenario in sweepstakes.
                                $.ajax({
                                    type: "POST",
                                    url: '/admin/delete-upc-image',
                                    data: {'id': id, 'customer_id': customer_id },
                                    success: function (data) {
                                        res = JSON.parse(data);
                                        var html = res['html'];
                                        $('#upc_uploaded_images1').html(html);
                                    },
                                    error: function (error) {
                                        let response = error['responseText'];
                                        alert("Sorry, There is An error " + response);
                                    }
                                });
                            });
                            this.on('success',function(file, response) {
                                res = JSON.parse(response);
                                if(res['success'] == true) {
                                    file.id = res['id'];
                                    var html = res['html'];
                                    $('#upc_uploaded_images1').html(html);
                                }
                            });
                        },
                    });

                    myDropzone.on('complete', function (response)
                    {
                        $(".dz-preview").remove();
                        $(".dz-message").show();
                    });

                    let dropzoneControl1 = $('#rec-upload1')[0].dropzone;
                    if(dropzoneControl1) {
                        dropzoneControl1.destroy();
                    }
                    Dropzone.autoDiscover = false;
                    var myDropzone3 = new Dropzone("div#rec-upload1", {
                        addRemoveLinks: true,
                        url: "/admin/rec-upload",
                        init: function() {
                            this.on("sending", function(file, xhr, formData) {
                                var customer_id = $('#customer_id').val();
                                formData.append("customer_id", customer_id);
                            });
                            this.on('removedfile', function(file){
                                var id = file.id;
                                var customer_id = $('#customer_id').val();
                                //There can be an issue if user two users at the same time uploaded to the
                                //server same type of images
                                //Need to handle this scenario in sweepstakes.
                                $.ajax({
                                    type: "POST",
                                    url: '/admin/delete-rec-image',
                                    data: {'id': id, 'customer_id': customer_id },
                                    success: function (data) {
                                        res = JSON.parse(data);
                                        var html = res['html'];
                                        $('#rec_uploaded_images1').html(html);
                                    },
                                    error: function (error) {
                                        let response = error['responseText'];
                                        alert("Sorry, There is An error " + response);
                                    }
                                });
                            });
                            this.on('success',function(file, response) {
                                res = JSON.parse(response);
                                if(res['success'] == true) {
                                    file.id = res['id'];
                                    var html = res['html'];
                                    $('#rec_uploaded_images1').html(html);
                                }
                            });
                        },
                    });

                    myDropzone3.on('complete', function (response)
                    {
                        $(".dz-preview").remove();
                        $(".dz-message").show();
                    });

                    $('.clsLoader').hide();
                }
            });

        });
        $(document).on('click', '#addEditModel', function () {
            $('.clsLoader').show();
            let type = $('#program-type').find(':selected').data('filter');
            let url = '';
            let form = '';
            let formData = '';
            if (type == 'Mail-In Rebate') {
                form = $("#addEditMirForm").closest("form");
                formData = new FormData(form[0]);
                url = '/admin/entries/mir/ajax-store';
            } else if (type == 'IRC') {
                form = $("#addEditIrcForm").closest("form");
                formData = new FormData(form[0]);
                url = '/admin/entries/irc/ajax-store';
            } else {
                form = $("#addEditMirForm").closest("form");
                formData = new FormData(form[0]);
                url = '/admin/entries/mir/ajax-store';
            }
            $.ajax({
                type: "POST",
                url: url,
                data: formData,
                dataType: "json",
                processData: false,
                contentType: false,
                success: function (data) {
                    $('.clsLoader').hide();
                    if (data['success'] == false) {
                        alert('Domain name already taken');
                        return;
                    }
                    $('#addEditModelPopup').modal('hide');
                    $('#program-type').trigger('change');
                },
                error: function (error) {
                    $('.clsLoader').hide();
                    let response = error['responseText'];
                    alert("Sorry, There is An error " + response);
                }
            });
        });

        $('#addEditModelPopup').on('keypress', function (event) {
            var keycode = (event.keyCode ? event.keyCode : event.which);
            if(keycode == '13'){
                $('#addEditModel').trigger('click');
            }});
        $(document).on('click', '#editModel', function () {
            let type = $('#program-type').find(':selected').data('filter');
            let url = '';
            let form = '';
            let formData = '';
            if (type == 'Mail-In Rebate') {
                form = $("#editMirForm").closest("form");
                formData = new FormData(form[0]);
                url = '/admin/entries/mir/ajax-update';
            } else if (type == 'IRC') {
                form = $("#editIrcForm").closest("form");
                formData = new FormData(form[0]);
                url = '/admin/entries/irc/ajax-update';
            } else {
                form = $("#editCouponForm").closest("form");
                formData = new FormData(form[0]);
                url = '/admin/coupons/ajax-edit';
            }
            $.ajax({
                type: "POST",
                url: url,
                data: formData,
                dataType: "json",
                processData: false,
                contentType: false,
                success: function (data) {
                    if (data['success'] == false) {
                        alert('Domain name already taken');
                        return;
                    }
                    $('#editModelPopup').modal('hide');
                    $('#program-type').trigger('change');
                },
                error: function () {
                    alert("Sorry, There is An error");
                },
            });
        });

        $('#campaign-type').change(function () {
            if ($(this).val() == '0') {
                $('.filters').filter(function () {
                    return  $(this).data('filter') === "campaign_type"
                }).remove();
                $('#program-type').trigger('change');
                return;
            }
        
            let column = $("#campaign-type").find(':selected').data('filter');
            
            let filterText = $("#campaign-type").find(':selected').data('filter-val');

            
            $('#all-data').DataTable().clear().destroy();
            $('#program-type').trigger('change');
        });
        
        $(document).on('click', '.apply', function () {
            //Check for dropdown then, Get appropriate column and filter text:
            let type = $("#program-type").find(':selected').data('filter');
            
            let programId = $('#program-type').find(':selected').val();
            let campaignId = $('#campaign-type').find(':selected').val();

            
            
            let column = '';
            let filterText = '';
            if (type == 'Mail-In Rebate') {
                column = $("select[name=column-mir]").val();
                filterText = $("input[name=text-coupon-type]").val();

            } else if (type == 'IRC') {
                column = $("select[name=column-irc]").val();
                filterText = $("input[name=text-coupon-type]").val();
             }
            else if (campaignId == '1'){
                column = $("select[name=column-mir]").val();
                filterText = $("input[name=text-mir]").val(); 
            } 
            else if (campaignId == '2') {
                column = $("select[name=column-irc]").val();
                filterText = $("input[name=text-irc]").val();
            }
            else {
                column = $("select[name=column-coupon-type]").val();
                filterText = $("input[name=text-coupon-type]").val();
            }
            let filterExist = false;
            if (filterText == '') {
                return;
            }
            $('.filters').each(function (i, obj) {
                if ($(obj).data('filter') == column) {
                    filterExist = true;
                }
            });
            if (!filterExist) {
                let filterHtml = '<button class="btn btn-default filters" data-filter="' + column + '" data-filter-val="' + filterText + '"><em>' + filterText + ' in ' + column + ' </em> <span><i class="fa fa-times-circle"></i></span></button>';
                addFilterHtml(filterHtml);
                $('#program-type').trigger('change');
            }
        });
        $('input[name=text-irc]').on('keyup', function (e) {
            if (e.keyCode === 13) {
                e.preventDefault();
                $('.apply').trigger('click');
            }
        });

        $('input[name=text-mir]').on('keyup', function (e) {
           
            if (e.keyCode === 13) {
                e.preventDefault();
                $('.apply').trigger('click');
            }
        });

        $('input[name=text-coupon-type]').on('keyup', function (e) {
            if (e.keyCode === 13) {
                e.preventDefault();
                $('.apply').trigger('click');
            }
        });

        $(document).on('changeDate', '#endDate', function () {
            let sDate = $('#startDate').val();
            let eDate = $('#endDate').val();
            if (sDate == '') {
                return;
            }
            startDate = new Date(sDate);
            endDate = new Date(eDate);
            if (startDate > endDate) {
                return;
            } else {
                let formattedStartDate = formateDate(startDate);
                let formattedEndDate = formateDate(endDate);
                $('.dates').remove();
                filterDates(sDate,eDate);
                
            }
        });

        $(document).on('changeDate', '#startDate', function () {
            let sDate = $('#startDate').val();
            let eDate = $('#endDate').val();
            if (eDate == '') {
                return;
            }
            startDate = new Date(sDate);
            endDate = new Date(eDate);
            if (startDate > endDate) {
                return;
            } else {
                startDate = new Date(startDate);
                endDate = new Date(endDate);
                let formattedStartDate = formateDate(startDate);
                let formattedEndDate = formateDate(endDate);
                $('.dates').remove();
                filterDates(sDate,eDate);
                
            }
        });

        function filterDates(sDate,eDate) {
                var newformate_start_date    = new Date($('#startDate').val()),
                yr      = newformate_start_date.getFullYear(),
                month   = newformate_start_date.getMonth() < 10 ? '0' + newformate_start_date.getMonth() : newformate_start_date.getMonth(),
                day     = newformate_start_date.getDate()  < 10 ? '0' + newformate_start_date.getDate()  : newformate_start_date.getDate(),
                newStartDate = yr + '-' + month + '-' + day;


                var newformate_end_date    = new Date($('#endDate').val()),
                yr      = newformate_end_date.getFullYear(),
                month   = newformate_end_date.getMonth() < 10 ? '0' + newformate_end_date.getMonth() : newformate_end_date.getMonth(),
                day     = newformate_end_date.getDate()  < 10 ? '0' + newformate_end_date.getDate()  : newformate_end_date.getDate(),
                newEndDate = yr + '-' + month + '-' + day;
                let filterHtml = '<button class="btn btn-default dates" data-start= "'+ newStartDate +'" data-end="' + newEndDate + '"><em>' + sDate + ' To ' + eDate + ' </em> <span><i class="fa fa-times-circle"></i></span></button>';
                addFilterHtml(filterHtml);
                $('#program-type').trigger('change');
                
                

        }

        $(document).on('click', '.fa-times-circle', function () {
            $(this).closest('button').remove();
            $('#program-type').trigger('change');
        });

        $(document).on('click', '#exportCsv', 'click', function () {
            let filter = $('#program-type').find(':selected').data('filter');
            let id = $('#program-type').find(':selected').val();
            let campaignId = $('#campaign-type').find(':selected').val();

            let startDate = '';
            let endDate = '';
            let filters = getFiltersArray();
            $('.dates').each(function (i, obj) {
                startDate = $(obj).data("start");
                endDate = $(obj).data("end");
            });
            $('#exportForm input').remove();
            $('#exportForm').attr('action', '/admin/entries-all/export-csv');
            $('#exportForm').append('<input type="hidden" name="startDate" value="' + startDate + '" />');
            $('#exportForm').append('<input type="hidden" name="program-type" value="' + filter + '" />');
            $('#exportForm').append('<input type="hidden" name="program-id" value="' + id + '" />');
            $('#exportForm').append('<input type="hidden" name="campaign-id" value="' + campaignId + '" />');
            $('#exportForm').append('<input type="hidden" name="endDate" value="' + endDate + '" />');
            $('#exportForm').append('<input type="hidden" name="filters" value=' + JSON.stringify(filters) + ' />');
            $('#exportForm').submit();
        });

        $(document).on('click', '#exportJson', function () {
            let filter = $('#program-type').find(':selected').data('filter');
            let id = $('#program-type').find(':selected').val();
            let campaignId = $('#campaign-type').find(':selected').val();
            let startDate = '';
            let endDate = '';
            let filters = getFiltersArray();
            $('.dates').each(function (i, obj) {
                startDate = $(obj).data("start");
                endDate = $(obj).data("end");
            });
            $('#exportForm input').remove();
            $('#exportForm').attr('action', '/admin/entries-all/export-json');
            $('#exportForm').append('<input type="hidden" name="startDate" value="' + startDate + '" />');
            $('#exportForm').append('<input type="hidden" name="program-type" value="' + filter + '" />');
            $('#exportForm').append('<input type="hidden" name="campaign-id" value="' + campaignId + '" />');
            $('#exportForm').append('<input type="hidden" name="program-id" value="' + id + '" />');
            $('#exportForm').append('<input type="hidden" name="endDate" value="' + endDate + '" />');
            $('#exportForm').append('<input type="hidden" name="filters" value=' + JSON.stringify(filters) + ' />');
            $('#exportForm').submit();
        });
        $(document).on('click', '#exportPdf', function () {
            let filter = $('#program-type').find(':selected').data('filter');
            let id = $('#program-type').find(':selected').val();
            let campaignId = $('#campaign-type').find(':selected').val();
            let startDate = '';
            let endDate = '';
            let filters = getFiltersArray();
            $('.dates').each(function (i, obj) {
                startDate = $(obj).data("start");
                endDate = $(obj).data("end");
            });
            $('#exportForm input').remove();
            $('#exportForm').attr('action', '/admin/entries-all/export-pdf');
            $('#exportForm').append('<input type="hidden" name="startDate" value="' + startDate + '" />');
            $('#exportForm').append('<input type="hidden" name="program-type" value="' + filter + '" />');
            $('#exportForm').append('<input type="hidden" name="program-id" value="' + id + '" />');
            $('#exportForm').append('<input type="hidden" name="campaign-id" value="' + campaignId + '" />');
            $('#exportForm').append('<input type="hidden" name="endDate" value="' + endDate + '" />');
            $('#exportForm').append('<input type="hidden" name="filters" value=' + JSON.stringify(filters) + ' />');
            $('#exportForm').submit();
        });
    });
</script>
@endpush