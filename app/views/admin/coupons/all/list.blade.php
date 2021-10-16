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
                        @if( Request::get('campaign'))
                        <div class="col-md-2" style="display: none">
                            <!-- Make it dynamic -->
                            <label>Select Campaign</label>
                            <div class="form-group">
                                <select class="form-control" id="campaign-type">
                                    <option value="">Select Campaign</option>
                                    @foreach ($campaigns as $key=>$value)

                                    <?php 
                                            $selected = ''; 
                                            switch($campaign)
                                            {
                                                case 'dmir':
                                                    if($key == 3)
                                                        $selected = "selected='selected'";
                                                break;
                                                case 'sweepstakes':
                                                    if($key == 4)
                                                        $selected = "selected='selected'";
                                                break;
                                                
                                                default:
                                                
                                                break;
                                            }
                                            ?>

                                    @if($value != 'N/A')
                                    <option value="{{ $key }}" <?php echo $selected; ?> data-filter-val="{{ $key }}"
                                        data-filter="campaign_type">{{ $value }}</option>
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <!-- Make it dynamic -->

                        <div class="col-md-2" style="display: none">
                            <label>Select Program</label>
                            <div class="form-group">
                                <select class="form-control" id="program-type">
                                    <option value="all">All</option>
                                    @foreach ($programs as $item)
                                    @if($item->name != '')
                                    <option value="{{ $item->id }}" data-filter="{{ $item->name }}">{{ $item->name }}
                                    </option>
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @else
                        <div class="col-md-2">
                            <!-- Make it dynamic -->
                            <label>Select Campaign</label>
                            <div class="form-group">
                                <select class="form-control" id="campaign-type">
                                    <option value="">Select Campaign</option>
                                    @foreach ($campaigns as $key=>$value)

                                    <?php 
                                            $selected = ''; 
                                            switch($campaign)
                                            {
                                                case 'dmir':
                                                    if($key == 3)
                                                        $selected = "selected='selected'";
                                                break;
                                                case 'sweepstakes':
                                                    if($key == 4)
                                                        $selected = "selected='selected'";
                                                break;
                                                
                                                default:
                                                
                                                break;
                                            }
                                            ?>

                                    @if($value != 'N/A')
                                    <option value="{{ $key }}" <?php echo $selected; ?> data-filter-val="{{ $key }}"
                                        data-filter="campaign_type">{{ $value }}</option>
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <!-- Make it dynamic -->

                        <div class="col-md-2">
                            <label>Select Program</label>
                            <div class="form-group">
                                <select class="form-control" id="program-type">
                                    <option value="all">All</option>
                                    @foreach ($programs as $item)
                                    @if($item->name != '')
                                    <option value="{{ $item->id }}" data-filter="{{ $item->name }}">{{ $item->name }}
                                    </option>
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @endif


                        {{-- Date picker : Start date --}}
                        <div class="col-md-2 top-5">

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


                        <div class="col-md-4 coupon-type-filter" style="padding-top:25px;">

                            <div class="form-inline">
                                <div class="form-group">

                                    <select name="column-coupon-type" id="column" class="form-control">
                                        <option value="all">All</option>
                                        <option value="id">ID</option>
                                        <option value="name">Program Name</option>
                                        <option value="coupon_type">Type</option>
                                        <option value="barcode">Barcode</option>
                                        <option value="active">Active</option>
                                        <option value="user">Program Owner</option>
                                        <option value="brand">Brand</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <input type="text" name="text-coupon-type" id="filter-text"
                                        placeholder="Type to Filter" class="form-control">
                                    <button type="button" class="btn btn-default apply" id="apply">Add Filter</button>
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



                    </div>
                    {{-- Applied filters --}}
                    <div class="row col-md-12 " id="filter-bar-bottom" style="padding-bottom:10px;">

                        <div class="applied-filters" data-grid="standard">
                            @if($campaign == 'dmir')
                            <button class="btn btn-default filters" data-filter="campaign_type" data-filter-val="3"
                                style="display:none"><em>DIGITAL MIR in campaign_type </em> <span><i
                                        class="fa fa-times-circle"></i></span></button>
                            @elseif($campaign == 'sweepstakes')
                            <button class="btn btn-default filters" data-filter="campaign_type" data-filter-val="4"
                                style="display:none"><em>SWEEPSTAKES in campaign_type </em> <span><i
                                        class="fa fa-times-circle"></i></span></button>
                            @endif
                        </div>

                    </div>
                </div>

                {{-- Results --}}
                <div class="row">

                    <div class="col-lg-12">

                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="all-data">

                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Program Name</th>
                                        {{-- <th>Campaign Type</th> --}}
                                        <th>Url</th>
                                        <th>Expires</th>

                                        {{-- <th>Receive By</th> --}}
                                        {{-- <th>Barcode</th> --}}

                                        <th>Owner</th>
                                        <th>Active</th>
                                        {{-- <th>Brand</th> --}}
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
            </div>
        </div>
    </div>
    <!-- END PAGE CONTENT-->
    @include('admin.coupons.add-edit-model-popup');
    @include('admin.coupons.generate_code_popup');
</div>
<style>
    .img-wraps {
        position: relative;
        display: inline-block;

        font-size: 0;
    }

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

    .img-wraps:hover .closes {
        opacity: 1;
    }

    .cke_skin_kama .cke_dialog_body {
        z-index: 102000 !important;
    }
</style>
@stop
@push('footer-script')
<script src="/assets/js/dropzone.js"></script>
<script type='text/javascript'>
    var code_generator_limit = <?php echo $code_generator_limit; ?>
</script>
<script src="/assets/admin/pages/scripts/coupon_generator.js"></script>

<script>
    bevpromo.coupon_generator.initialize();
    
    function getFiltersArray() {
        let type = $("#program-type").find(':selected').data('filter');
        let filters = [];
            $('.filters').each(function(i,obj) {
                    let data = {key: $(obj).data('filter'), value: $(obj).data('filter-val') };
                    filters.push(data);
                    //return false;
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
        let filter = $('#program-type').find(':selected').val();
        let id = $('#program-type').find(':selected').val();
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
                "serverSide": true,
                "searching": false,
                "ajax": {
                    "url": "/admin/coupons/data",
                    "type": "POST",
                    "data": {
                        "program-type": filter,
                        "program-id": id,
                        "filters": filters,
                        "startDate": startDate,
                        "endDate": endDate
                    }
                },
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'name', name: 'name' },
                    
                    // { data: 'campaign_type', name: 'campaign_type' },
                    { data: 'campaign_url', name: 'campaign_url',
                        "render": function (data,type,row,meta) {
                            if(row.campaign_url != 'N/D') {
                                let url = '<?php echo Constant::$frontEndUrl ?>';
                                url += row.campaign_url + '/' + row.id;
                                return "<a href='" + url +"' target='_blank'>Open</a>"
                            }
                            else {
                                return "N/D";
                            }
                        }

                    },
                    { data: 'expires', name: 'expires' },
                    //{ data: 'owner', name: 'owner' },
                    // { data: 'barcode', name: 'barcode' },
                    
                     { data: 'user', name: 'user' },
                     { data: 'active', name: 'active' },
                    // { data: 'brand', name: 'brand' },
                    { data: 'created_at', name: 'created_at' },
                    {
                        "data": "action",
                        "name": "action",
                        "render": function ( data, type, row, meta ) {
                                return "<a href='javascript:;' data-id=" + row.id + " class='openEditForm'><i class='fa fa-pencil'></i> Edit </a>";
                         },
                    }
                ]
            });
    }

    $(document).ready(function() {
       
        $('#program-type').change(function(){
            $('#all-data').DataTable().clear().destroy();
            let dateF = $('.dates').length;
            let filterF = $('.filters').length;
            if(dateF == 0 && filterF == 0) {
            let html = '<i>There are no filters applied.</i>';
            addFilterHtml(html);
            }
            populateTable();
        });

        $('#campaign-type').change(function(){
            if($(this).val() == '') {
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
                var text = $( "#campaign-type option:selected" ).text();
                let filterHtml = '<button class="btn btn-default filters" data-filter="'+ column +'" data-filter-val="'+ filterText +'"><em>' + text + ' in ' + column + ' </em> <span><i class="fa fa-times-circle"></i></span></button>';
                let datesLength = $('.dates').length;
                let filtersLength = $('.filters').length;
                if(datesLength == 0 && filtersLength == 0) {
                    //First Filter
                    $('.applied-filters').html(filterHtml);
                }
                else {
                    $('.applied-filters').html(filterHtml);
                }
                $('#all-data').DataTable().clear().destroy();
                $('#program-type').trigger('change');
            }
        });
        
        $(document).on('click', '.openEditForm', function () {
            $('.clsLoader').show();
            let id = $(this).data('id');
            url = '/admin/coupons/' + id + '/ajax-add-edit';
            $.ajax({
                url: url,
                success: function (html) {
                    let finalHtml = JSON.parse(html);
                    $('#addEditForm').html(finalHtml);
                    // $('#campaignType')
                    //     .val('4')
                    //     .trigger('change');
                    $('#display_campaign_type').hide();
                    const urlParams = new URLSearchParams(window.location.search);
                    const myParam = urlParams.get('campaign');
                    $('.clsLoader').hide();
                    if(myParam==='dmir')
                    {
                        $('#campaignType')
                        .val('3')
                        .trigger('change');

                    }
                    else if(myParam==='sweepstakes')
                    {
                        $('#campaignType')
                        .val('4')
                        .trigger('change');
                    }
                },
                error: function () {
                    $('.clsLoader').hide();
                    alert("There is an error");
                },
                complete: function () {
                    $('#addEditModelPopup').modal();
                    Dropzone.autoDiscover = false;
                    var myDropzone = new Dropzone("div#logo-upload", {
                        addRemoveLinks: true,
                        url: "/admin/coupons/upload-dmir-logo",
                        maxFiles: 1,
                        init: function() {
                            this.on("maxfilesexceeded", function(file) {
                                alert("You are not allowed to chose more than 1 file!");
                                this.removeFile(file);
                            });
                            this.on('removedfile', function(file){
                                var fileName = $('#file_name').val();
                                var imageCouponId = $('#image_coupon_id').val();
                                $.ajax({
                                    type: "POST",
                                    url: '/admin/coupons/delete-dmir-logo',
                                    data: {'file_name': fileName, 'image_coupon_id': imageCouponId},
                                    success: function (data) {

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
                                    $('#file_name').val(res['file_name']);
                                    $('#image_coupon_id').val(res['image_coupon_id']);
                                }
                            });
                        },
                    });
                    $('#campaignType').trigger('change');

                    var myyDropzone = new Dropzone("div#favicon-upload", {
                        addRemoveLinks: true,
                        url: "/admin/coupons/upload-favicon",
                        maxFiles: 1,
                        init: function() {
                            this.on("maxfilesexceeded", function(file) {
                                alert("You are not allowed to chose more than 1 file!");
                                this.removeFile(file);
                            });
                            this.on('removedfile', function(file){
                                var favicon = $('#fav_icon').val();
                                var imageCouponId = $('#fav_image_coupon_id').val();
                                $.ajax({
                                    type: "POST",
                                    url: '/admin/coupons/delete-favicon',
                                    data: {'fav_icon': favicon, 'fav_image_coupon_id': imageCouponId},
                                    success: function (data) {

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
                                    $('#fav_icon').val(res['fav_icon']);
                                    $('#fav_image_coupon_id').val(res['fav_image_coupon_id']);
                                }
                            });
                        },
                    });
                }
            });
        });

        $(document).on('click', '#openAddPopup', function () {
            $('.clsLoader').show();
            id = 0;
            let url = '';
            url = '/admin/coupons/' + id + '/ajax-add-edit';
            $.ajax({
                url: url,
                success: function (html) {
                    let finalHtml = JSON.parse(html);
                    $('#addEditForm').html(finalHtml);
                    $('#display_campaign_type').hide();
                    $('.clsLoader').hide();
                    const urlParams = new URLSearchParams(window.location.search);
                    const myParam = urlParams.get('campaign');
                    if(myParam==='dmir')
                    {
                        $('#campaignType')
                        .val('3')
                        .trigger('change');

                    }
                    else if(myParam==='sweepstakes')
                    {
                        $('#campaignType')
                        .val('4')
                        .trigger('change');
                    }

                },
                error: function () {
                    alert("There is an error");
                },
                complete: function () {
                    $('#addEditModelPopup').modal();
                    Dropzone.autoDiscover = false;
                    var myDropzone = new Dropzone("div#logo-upload", {
                        addRemoveLinks: true,
                        url: "/admin/coupons/upload-dmir-logo",
                        maxFiles: 1,
                        init: function() {
                            this.on("maxfilesexceeded", function(file) {
                                alert("You are not allowed to chose more than 1 file!");
                                this.removeFile(file);
                            });
                            this.on('removedfile', function(file){
                                var fileName = $('#file_name').val();
                                var imageCouponId = $('#image_coupon_id').val();
                                $.ajax({
                                    type: "POST",
                                    url: '/admin/coupons/delete-dmir-logo',
                                    data: {'file_name': fileName, 'image_coupon_id': imageCouponId},
                                    success: function (data) {

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
                                    $('#file_name').val(res['file_name']);
                                    $('#image_coupon_id').val(res['image_coupon_id']);
                                }
                            });
                        },
                    });

                    var myyDropzone = new Dropzone("div#favicon-upload", {
                        addRemoveLinks: true,
                        url: "/admin/coupons/upload-favicon",
                        maxFiles: 1,
                        init: function() {
                            this.on("maxfilesexceeded", function(file) {
                                alert("You are not allowed to chose more than 1 file!");
                                this.removeFile(file);
                            });
                            this.on('removedfile', function(file){
                                var favicon = $('#fav_icon').val();
                                var imageCouponId = $('#fav_image_coupon_id').val();
                                $.ajax({
                                    type: "POST",
                                    url: '/admin/coupons/delete-favicon',
                                    data: {'fav_icon': favicon, 'fav_image_coupon_id': imageCouponId},
                                    success: function (data) {

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
                                    $('#fav_icon').val(res['fav_icon']);
                                    $('#fav_image_coupon_id').val(res['fav_image_coupon_id']);
                                }
                            });
                        },
                    });

                    // $('#logo-upload').dropzone({ url: "/file/post" });
                }
            });
        });


        (function() {
            'use strict';
            window.addEventListener('load', function() {


            }, false);
        })();


        $(document).on('click', '#addEditModel, #addEditModelAndGenerateCode', function () {

            $('.clsLoader').show();
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementById('addEditCouponForm');

                if (forms.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                    var reqMessage="Enter data in required* fields";
                    alert(reqMessage);
                    return;
                }
                forms.classList.add('was-validated');


            //This is to identify button
            var type = $(this).data("type");
            $("#addEditCouponForm #btnType").val(type);

            $('#addEditModel, #addEditModelAndGenerateCode').attr("disabled", true);
            let url = '';
            let form = '';
            let formData = '';
            form = $("#addEditCouponForm").closest("form");
            for (instance in CKEDITOR.instances) {
                CKEDITOR.instances[instance].updateElement();
            }
            formData = new FormData(form[0]);
            url = '/admin/coupons/ajax-store';
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
                        var message = data['messages'];
                        alert(message);
                        $('#addEditModel, #addEditModelAndGenerateCode').attr("disabled", false);
                        return;
                    }
                    
                    if(type == 1)
                    {
                        $('#addEditModelPopup').modal('hide');
                        $('#program-type').trigger('change');
                        $('#addEditModel, #addEditModelAndGenerateCode').attr("disabled", false);
                    } else if(type == 2){
                        $('#addEditModelPopup').modal('hide');
                        $('#program-type').trigger('change');
                        $('#addEditModel, #addEditModelAndGenerateCode').attr("disabled", false);
                        bevpromo.coupon_generator.get_code_generator_form(data.coupon_id);
                        $("#frmCouponGenerate #coupon_id").val(data.coupon_id);
                        $('#c_id').val(data.coupon_id);
                        $("#btnConfigurations").data("coupon_id", data.coupon_id);
                        $('#generateCodeModel').modal('show');
                    }
                },
                error: function (error) {
                    let response = error['responseText'];
                    alert("Sorry, There is An error " + response);
                    $('#addEditModel, #addEditModelAndGenerateCode').attr("disabled", false);
                }
            });
        });

        $(document).on('click', '#btnImport', function () {

            $('#generateCodeModel, #btnImport').attr("disabled", true);
            $('.clsLoader').show();
            let url = '';
            let form = '';
            let formData = '';
            var fd = new FormData();
            var files = $('#file')[0].files[0];
            fd.append('file',files);
            url = '/admin/coupons/upload_csv/'+$('#c_id').val();
            $.ajax({
                type: "POST",
                url: url,
                data: fd,
                dataType: "json",
                processData: false,
                contentType: false,
                success: function (data) {
                    console.log(data);
                    $('.clsLoader').hide();
                    $('#file').val("");
                    $('#generateCodeModel, #btnImport').attr("disabled", false);
                    $('#generateCodeModel').modal('hide');
                    $('#addEditModelPopup').modal('hide');
                },
                error: function (error) {
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

        $('#program-type').trigger('change');
        
        $(document).on('click','.apply',function() {
            //Check for dropdown then, Get appropriate column and filter text:
            let type = $("#program-type").find(':selected').data('filter');
            let column = $('#column').val();
            let filterText = $('#filter-text').val();
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
                $('#program-type').trigger('change');
            }
        });

        $('input[name=text-coupon-type]').on('keyup',function(e){
            if (e.keyCode === 13) {
                e.preventDefault();
                $('.apply').trigger('click');
            }
        });
        //End Date
        $(document).on('changeDate','#endDate',function(){
           
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
                filterDates(sDate,eDate);
            }
        });
        //Start Date
        $(document).on('changeDate','#startDate',function(){
           
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

        $(document).on('click','.fa-times-circle',function() {
            $(this).closest('button').remove();
            $('#program-type').trigger('change');
        });

        $(document).on('click','#exportCsv','click',function(){
            let filter = $('#program-type').find(':selected').data('filter');
            let id = $('#program-type').find(':selected').val();
            let startDate = '';
            let endDate = '';
            let filters = getFiltersArray();
            $('.dates').each(function(i,obj) {
            startDate = $(obj).data("start");
            endDate = $(obj).data("end");
            });
            $('#exportForm input').remove();
            $('#exportForm').attr('action', '/admin/entries-all/export-csv');
            $('#exportForm').append('<input type="hidden" name="startDate" value="'+startDate+'" />');
            $('#exportForm').append('<input type="hidden" name="program-type" value="'+filter+'" />');
            $('#exportForm').append('<input type="hidden" name="program-id" value="'+id+'" />');
            $('#exportForm').append('<input type="hidden" name="endDate" value="'+endDate+'" />');
            $('#exportForm').append('<input type="hidden" name="filters" value=' +JSON.stringify(filters)+ ' />');
            $('#exportForm').submit();
        });

        $(document).on('click','#exportJson',function(){
            let filter = $('#program-type').find(':selected').data('filter');
            let id = $('#program-type').find(':selected').val();
            let startDate = '';
            let endDate = '';
            let filters = getFiltersArray();
            $('.dates').each(function(i,obj) {
            startDate = $(obj).data("start");
            endDate = $(obj).data("end");
            });
            $('#exportForm input').remove();
            $('#exportForm').attr('action', '/admin/entries-all/export-json');
            $('#exportForm').append('<input type="hidden" name="startDate" value="'+startDate+'" />');
            $('#exportForm').append('<input type="hidden" name="program-type" value="'+filter+'" />');
            $('#exportForm').append('<input type="hidden" name="program-id" value="'+id+'" />');
            $('#exportForm').append('<input type="hidden" name="endDate" value="'+endDate+'" />');
            $('#exportForm').append('<input type="hidden" name="filters" value=' +JSON.stringify(filters)+ ' />');
            $('#exportForm').submit();
        });
        $(document).on('click','#exportPdf',function(){
            let filter = $('#program-type').find(':selected').data('filter');
            let id = $('#program-type').find(':selected').val();
            let startDate = '';
            let endDate = '';
            let filters = getFiltersArray();
            $('.dates').each(function(i,obj) {
            startDate = $(obj).data("start");
            endDate = $(obj).data("end");
            });
            $('#exportForm input').remove();
            $('#exportForm').attr('action', '/admin/entries-all/export-pdf');
            $('#exportForm').append('<input type="hidden" name="startDate" value="'+startDate+'" />');
            $('#exportForm').append('<input type="hidden" name="program-type" value="'+filter+'" />');
            $('#exportForm').append('<input type="hidden" name="program-id" value="'+id+'" />');
            $('#exportForm').append('<input type="hidden" name="endDate" value="'+endDate+'" />');
            $('#exportForm').append('<input type="hidden" name="filters" value=' +JSON.stringify(filters)+ ' />');
            $('#exportForm').submit();
        });
        
        
        
        <?php if($campaign != '') { ?>
            $(".campaign-type").trigger('change');
        <?php } ?>
        

    });

    function spanColor(t) {
        $('#field_span_color').val(t.value);
    }


    
</script>
@endpush