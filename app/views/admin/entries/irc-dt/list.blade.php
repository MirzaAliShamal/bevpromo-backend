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
                    <i class="fa fa-users"></i>IRC Entries
                </div>
                <div class="col-md-2 pull-right">
                    <a href="/admin/entries/irc/create" class="btn green " role="button">Add New Entry <i
                            class="fa fa-plus"></i></a>
                </div>
                <div class="col-md-2 pull-right">
                    <a href="/admin/invoice/irc/invoice_all" class="btn red" role="button">Invoice All IRC Entries <i
                            class="fa fa-money"></i></a>
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
                    {{-- Date picker : Start date --}}

                    <div class="col-md-2 top-5">

                        <div class="form-group">

                            <div class="input-group datePicker" data-grid="standard" data-range-filter>
                                <input autocomplete='off' placeholder='mm/dd/yyyy' id="startDate" type='text'
                                    class='form-control datepicker-jq' required='' />

                            </div>

                        </div>

                    </div>

                    {{-- Date picker : End date --}}
                    <div class="col-md-2">

                        <div class="form-group">

                            <div class="input-group datePicker" data-grid="standard" data-range-filter>
                                <input autocomplete='off' placeholder='mm/dd/yyyy' id="endDate" type='text'
                                    class='form-control datepicker-jq' required='' />

                            </div>

                        </div>

                    </div>



                    <div class="col-md-6">

                        <div class="form-inline">
                            <div class="form-group">

                                <select name="column" class="form-control" id="column">
                                    <option value="all">All</option>
                                    <option value="id">ID</option>
                                    <option value="retailer">Retailer</option>
                                    <option value="program">Program</option>
                                    <option value="coupon_quantity">Quantity</option>
                                    <option value="payable">Payable</option>
                                    <option value="clearinghouse">Clearinghouse</option>
                                    <option value="is_invoiced">Status</option>
                                    <option value="client_invoice">Invoice Number</option>
                                    <option value="shipping">Shipping Amount</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <input type="text" name="filter" placeholder="Type to Filter" class="form-control"
                                    id="filter-text">
                                <button type="button" class="btn btn-default" id="apply">Add Filter</button>
                            </div>

                        </div>

                    </div>

                </div>

                {{-- Export button --}}
                <div class="col-md-2">

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

                {{-- Applied filters --}}
                <div class="row col-md-12 " id="filter-bar-bottom">

                    <div class="applied-filters" data-grid="standard"></div>

                </div>

                {{-- Results --}}
                <div class="row">

                    <div class="col-lg-12">

                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="irc-data">

                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Retailer</th>
                                        <th>Program</th>
                                        {{-- <th>Campaign Type</th> --}}
                                        <th>Clearinghouse</th>
                                        <th>Status</th>
                                        <th>Quantity</th>
                                        <th>Payable</th>
                                        {{-- <th>Shipping</th> --}}
                                        <th>Created</th>
                                        {{-- <th>Program Type</th> --}}
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
</div>
</div>
@stop

@push('footer-script')
<script>
    function getIrcData() {
        let startDate = '';
        let endDate = '';
        let filters = [];
        $('.dates').each(function(i,obj) {
           startDate = $(obj).data("start");
           endDate = $(obj).data("end");
        });
        let dateF = $('.dates').length;
        let filterF = $('.filters').length;
        if(dateF == 0 && filterF == 0) {
            let html = '<i>There are no filters applied.</i>';
            addFilterHtml(html);
        }
        $('.filters').each(function(i,obj){
            let data = {key: $(obj).data('filter'), value: $(obj).data('filter-val') };
            filters.push(data);
        });
        $('#irc-data').DataTable({
                "processing": true,
                "serverSide": true,
                "searching":false,
                "bFilter":false,
                "lengthChange": false,
                "pageLength": 20,
                "ajax": {
                    "url": "/admin/entries/irc-data",
                    "type": "POST",
                    "data": {
                        "startDate": startDate,
                        "endDate": endDate,
                        'filters': filters
                    }
                },
                    columns: [
                {data: 'id', name: 'id'},
                {data: 'retailer', name: 'retailer'},
                {data: 'program', name: 'program'},
                // {data: 'campaign_type', name: 'campaign_type'},
                // { data: 'campaign_logo', name: 'campaign_logo',
                //     "render": function (data,type,row,meta) {
                //         if(row.campaign_logo != 'N/A') {
                //             let url = '<?php echo Constant::$assetLink ?>';
                //             url += row.campaign_logo;
                //             return "<a href='" + url + "' target='_blank'>Logo</a>"
                //         }
                //         else {
                //             return "N/A";
                //         }
                //     }

                // },
                {data: 'clearinghouse', name: 'clearinghouse'},
                {data: 'is_invoiced', name: 'is_invoiced'},
                {data: 'coupon_quantity', name: 'coupon_quantity'},
                {data: 'payable', name: 'payable'},
                // {data: 'shipping', name: 'shipping'},
                {data: 'created_at', name: 'created_at'},
                {
                    "data": "action",
                    "name": "action",
                    "render": function (data, type, row, meta) {
                        return "<td><a href='/admin/entries/irc/"+row.id+"/edit' target='_blank' data-id=" + row.id + " class='openEditForm'><i class='fa fa-pencil'></i>Edit </a>||<a href='javascript:;' class='btndelt' data-id="+row.id+" role='button'><i class='fa fa-trash-o'></i>Delete </a></td>";
                    },
                },
            ]
        });
    }
    $(document).on('click', '.btndelt', function () {
        var r = confirm("Confirm Delete!");
        if (r == true) {
            var id=$(this).data("id");
            //alert(id);
            data = {
            "_token": "{{ csrf_token() }}",
            "id":id,
            }
            var url = "/admin/entries/irc-dt/delete";

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
    });
    $(document).ready(function(){
        
        getIrcData();
        $(document).on('click','#apply',function(){
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
                $('#irc-data').DataTable().clear().destroy();
                getIrcData();
            }
        });

        $(document).on('keyup','#filter-text',function(e){
            if (e.keyCode === 13) {
                e.preventDefault();
                $('#apply').trigger('click');
            }
        });

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
                $('#irc-data').DataTable().clear().destroy();
                getIrcData();

        }

        $(document).on('click','.fa-times-circle',function() {
            $('#irc-data').DataTable().clear().destroy();
            $(this).closest('button').remove();
            getIrcData();
        });
        $(document).on('click','#exportCsv','click',function(){
            let startDate = '';
            let endDate = '';
            let filters = [];
            $('.dates').each(function(i,obj) {
            startDate = $(obj).data("start");
            endDate = $(obj).data("end");
            });
            $('.filters').each(function(i,obj){
                let data = {key: $(obj).data('filter'), value: $(obj).data('filter-val') };
                filters.push(data);
            });
            $('#exportForm input').remove();
            $('#exportForm').attr('action', '/admin/entries/export-irc-csv');
            $('#exportForm').append('<input type="hidden" name="startDate" value="'+startDate+'" />');
            $('#exportForm').append('<input type="hidden" name="endDate" value="'+endDate+'" />');
            $('#exportForm').append('<input type="hidden" name="filters" value=' +JSON.stringify(filters)+ ' />');
            $('#exportForm').submit();
        });

        $(document).on('click','#exportJson',function(){
            let startDate = '';
            let endDate = '';
            let filters = [];
            $('.dates').each(function(i,obj) {
            startDate = $(obj).data("start");
            endDate = $(obj).data("end");
            });
            $('.filters').each(function(i,obj){
                let data = {key: $(obj).data('filter'), value: $(obj).data('filter-val') };
                filters.push(data);
            });
            $('#exportForm input').remove();
            $('#exportForm').attr('action', '/admin/entries/export-irc-json');
            $('#exportForm').append('<input type="hidden" name="startDate" value="'+startDate+'" />');
            $('#exportForm').append('<input type="hidden" name="endDate" value="'+endDate+'" />');
            $('#exportForm').append('<input type="hidden" name="filters" value=' +JSON.stringify(filters)+ ' />');
            $('#exportForm').submit();
        });
        $(document).on('click','#exportPdf',function(){
            let startDate = '';
            let endDate = '';
            let filters = [];
            $('.dates').each(function(i,obj) {
            startDate = $(obj).data("start");
            endDate = $(obj).data("end");
            });
            $('.filters').each(function(i,obj){
                let data = {key: $(obj).data('filter'), value: $(obj).data('filter-val') };
                filters.push(data);
            });
            $('#exportForm input').remove();
            $('#exportForm').attr('action', '/admin/entries/export-irc-pdf');
            $('#exportForm').append('<input type="hidden" name="startDate" value="'+startDate+'" />');
            $('#exportForm').append('<input type="hidden" name="endDate" value="'+endDate+'" />');
            $('#exportForm').append('<input type="hidden" name="filters" value=' +JSON.stringify(filters)+ ' />');
            $('#exportForm').submit();
        });
    });
</script>
@endpush