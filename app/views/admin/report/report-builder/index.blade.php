@extends('layouts.default-dt')

@section('content')
    <style>
        table.dataTable {
            width: 100%;
            margin: 0 auto;
            clear: both;
            border-collapse: collapse !important;
            border-spacing: 0;
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
                        <i class="fa fa-users"></i>Click on an Entry to Edit
                    </div>
                    <div class="col-md-2 pull-right">
                        <a class="btn green " data-toggle="modal" data-target="#saveSearchPoUp">Saved Searched
{{--                            <i class="fa fa-plus"></i>--}}
                        </a>
                    </div>
                    <div class="col-md-2 pull-right">
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

{{--                        <div class="col-md-2 top-5">--}}

{{--                            <div class="form-group">--}}

{{--                                <div class="input-group datePicker" data-grid="standard" data-range-filter>--}}
{{--                                    <input autocomplete='off' placeholder='mm/dd/yyyy' id="startDate" type='text'--}}
{{--                                           class='form-control datepicker-jq' required='' />--}}

{{--                                </div>--}}

{{--                            </div>--}}

{{--                        </div>--}}

                        {{-- Date picker : End date --}}
{{--                        <div class="col-md-2">--}}

{{--                            <div class="form-group">--}}

{{--                                <div class="input-group datePicker" data-grid="standard" data-range-filter>--}}
{{--                                    <input autocomplete='off' placeholder='mm/dd/yyyy' id="endDate" type='text'--}}
{{--                                           class='form-control datepicker-jq' required='' />--}}

{{--                                </div>--}}

{{--                            </div>--}}

{{--                        </div>--}}


                        <div class="col-md-2">

                            <div class="form-inline">
                                <div class="form-group">
                                    <select name="column" class="form-control" id="column">
                                        <option data-db="entries_irc_view" value="retailer">IRC Retailer</option>
                                        <option data-db="entries_mir_view" value="retailer">MIR Retailer</option>
                                        <option data-db="entries_irc_view" value="clearinghouse">Clearinghouse</option>
                                        <option data-db="coupons_view" value="brand">Brand</option>
                                        <option data-db="coupons_view" value="supplier_name">Supplier</option>
                                        <option data-db="coupons_view" value="coupon_type">Coupon Type</option>
                                        <option data-db="coupons_view" value="name">Program Name</option>
                                        <option data-db="coupons_view" value="value">Dollar Value (program)</option>
                                        <option data-db="entries_mir_view" value="dollar_value">Dollar Value (entry)</option>
                                        <option data-db="coupons_view" value="expires">Expiration Date</option>
                                        <option data-db="coupons_view" value="receive_by">Receive By Date</option>
                                        <option data-db="coupons_view" value="barcode">Barcode</option>
                                        <option data-db="coupons_view" value="circulation">Circulation</option>
                                        <option data-db="coupons_view" value="active">Active (YES, N0 or both only)</option>
                                        <option data-db="entries_irc_view" value="owner">Program Owner</option>
                                        <option data-db="entries_mir_view" value="first_name">Coupon Entry First Name</option>
                                        <option data-db="entries_mir_view" value="last_name">Coupon Entry Last Name</option>
                                        <option data-db="entries_mir_view" value="address">Coupon Entry Address</option>
                                        <option data-db="entries_mir_view" value="city">Coupon City</option>
                                        <option data-db="entries_mir_view" value="state">Coupon State</option>
                                        <option data-db="entries_mir_view" value="zip">Coupon Zip</option>
                                        <option data-db="entries_mir_view" value="email">Coupon email</option>
                                        <option data-db="entries_mir_view" value="birth_date">Coupon birth date</option>
                                        <option data-db="entries_mir_view" value="status">Coupon Status</option>
                                        <option data-db="entries_mir_view" value="denial_reason_id">Coupon Denial Reason</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div style="display:flex;width:46%;" class="col-md-4">
                            <div class="form-inline">
                                <div class="form-group">
                                    <select name="column" class="form-control" id="columnSelect" onchange="selectOption()">
                                        <option value="all" selected>All</option>
                                        <option value="none">None</option>
                                        <option value="equals">Equals</option>
                                        <option value="does-not-equal">Does Not Equal</option>
                                        <option value="contains">Contains</option>
                                        <option value="begins-with">Begins With</option>
                                        <option value="ends-with">Ends With</option>
                                        <option value="is-not-empty">Is Not Empty</option>
                                        <option value="is-empty">Is Empty</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <input type="text" style="display: none;" name="filter" placeholder="Type to Filter" class="form-control"
                                           id="filter-text">
                                    <button type="button" class="btn btn-default" id="apply">Add Filter</button>
                                    <button type="button" class="btn btn-default" data-toggle="modal" data-target="#savefilterPoUp">Save Search</button>
                                </div>

                            </div>
                        </div>

                    </div>

                    {{-- Export button --}}
                    <div class="col-md-1">

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
                                </ul>
                            </form>

                        </div>

                    </div>

                    {{-- Applied filters --}}
                    <div class="row col-md-12 " id="filter-bar-bottom">

                        <div class="applied-filters" data-grid="standard"><i>There are no filters applied.</i></div>

                    </div>

                    {{-- Results --}}
                    <div class="row">

                        <div class="col-lg-12">

                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" style="width: 100% !important;" id="irc-data">

                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Retailer</th>
                                        <th>Coupon Type</th>
                                        <th>Brand</th>
                                        <th>Name</th>
                                        <th>Active</th>
                                        <th>Clearing House</th>
                                        <th>Supplier Name</th>
                                        <th>Program Owner</th>
                                        <th>Dollar Value (program)</th>
                                        <th>Dollar Value (entry)</th>
                                        <th>Receive By</th>
                                        <th>Barcode</th>
                                        <th>Circulation</th>
                                        <th>Coupon First Name</th>
                                        <th>Coupon City</th>
                                        <th>Birth Date</th>
                                        <th>Date</th>
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


    <!-- Modal -->
    <div id="savefilterPoUp" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Save Filters Data</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <label>Enter Filter Name;</label>
                            <input type="text" required id="filter_name" name="name" placeholder="enter filter name" class="form-control" />
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="saveSearch">Save Filter</button>
                </div>
            </div>

        </div>
    </div>


    <!-- Modal -->
    <div id="saveSearchPoUp" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Favourite Search</h4>
                </div>
                    <input type="hidden" name="_token" value="{{csrf_token()}}" />
                <div class="modal-body" id="modal-body">

                </div>
            </div>

        </div>
    </div>
@stop

@push('footer-script')
    <script>

        function selectOption(){
            let value = $('#columnSelect').val();
            if(value === 'is-not-empty' || value === 'is-empty' || value === 'all' || value === 'none') {
                $('#filter-text').val('');
                $('#filter-text').hide();
            } else {
                $('#filter-text').val('');
                $('#filter-text').show();
            }
        }

        function getIrcData() {
            let startDate = '';
            let endDate = '';
            let filters = [];
            $('.dates').each(function(i,obj) {
                startDate = $(obj).data("start");
                endDate = $(obj).data("end");
            });
            let filterF = $('.filters').length;
            if(filterF == 0) {
                let html = '<i>There are no filters applied.</i>';
                addFilterHtml(html);
            }
            $('.filters').each(function(i,obj){
                let data = {key: $(obj).data('filter'), value: $(obj).data('filter-val') , db:$(obj).data('db-name'), column:$(obj).data('sec-col')};
                filters.push(data);
            });
            console.log(filters);
            let arrayFilters1 = [];
            let arrayFilters2 = [];
            let arrayFilters3 = [];
            filters.map((data) => {
                if(data.db == 'entries_irc_view') {
                    if(arrayFilters1.length <= 0) {
                        let dataArr = {key: [], value: [], db: data.db, column: []};
                        dataArr.key.push({'key': data.key});
                        dataArr.value.push({'value': data.value});
                        dataArr.column.push({'column': data.column});
                        arrayFilters1.push(dataArr);
                    } else {
                        if(arrayFilters1[0].column[0].column != data.column) {
                            // if(arrayFilters1[0].key[0].key != data.key) {
                                arrayFilters1[0].key.push({'key': data.key})
                            // }
                            if(arrayFilters1[0].value.length < 0 || arrayFilters1[0].value[0].value != data.value) {
                                arrayFilters1[0].value.push({'value': data.value})
                            }
                            arrayFilters1[0].column.push({'column': data.column})
                        }
                    }
                }
                if(data.db == 'entries_mir_view') {
                    if(arrayFilters2.length <= 0) {
                        let dataArr = {key: [], value: [], db: data.db, column: []};
                        dataArr.key.push({'key': data.key});
                        dataArr.value.push({'value': data.value});
                        dataArr.column.push({'column': data.column});
                        arrayFilters2.push(dataArr);
                    } else {
                        if(arrayFilters2[0].column[0].column != data.column) {
                            // if(arrayFilters2[0].key[0].key != data.key) {
                                arrayFilters2[0].key.push({'key': data.key})
                            // }
                            if(arrayFilters2[0].value.length < 0 || arrayFilters2[0].value[0].value != data.value) {
                                arrayFilters2[0].value.push({'value': data.value})
                            }
                            arrayFilters2[0].column.push({'column': data.column})
                        }
                    }
                }
                if(data.db == 'coupons_view') {
                    if(arrayFilters3.length <= 0) {
                        let dataArr = {key: [], value: [], db: data.db, column: []};
                        dataArr.key.push({'key': data.key});
                        dataArr.value.push({'value': data.value});
                        dataArr.column.push({'column': data.column});
                        arrayFilters3.push(dataArr);
                    } else {
                        if(arrayFilters3[0].column[0].column != data.column) {
                            // if(arrayFilters3[0].key[0].key != data.key) {
                                arrayFilters3[0].key.push({'key': data.key})
                            // }
                            if(arrayFilters3[0].value.length < 0 || arrayFilters3[0].value[0].value != data.value) {
                                arrayFilters3[0].value.push({'value': data.value})
                            }
                            arrayFilters3[0].column.push({'column': data.column})
                        }
                    }
                }
            });
            let oneArray = arrayFilters1.concat(arrayFilters2);
            let mergeThreeArray = oneArray.concat(arrayFilters3);
            console.log('mergeThreeArray');
            console.log(mergeThreeArray);
            if(mergeThreeArray.length < 0) {
                console.log('length is zero');
                return;
            }
            $('#irc-data').DataTable({
                "processing": true,
                "serverSide": true,
                "searching":false,
                "bFilter":false,
                "lengthChange": false,
                "pageLength": 20,
                "ajax": {
                    "url": "/admin/report-builder/search",
                    "type": "POST",
                    "data": {
                        "startDate": startDate,
                        "endDate": endDate,
                        'filters': mergeThreeArray
                    }
                },
                columns: [
                    {data: 'id'},
                    {data: 'retailer'},
                    {data: 'coupon_type'},
                    {data: 'brand'},
                    {data: 'name'},
                    {data: 'active'},
                    {data: 'clearinghouse'},
                    {data: 'supplier_name'},
                    {data: 'owner'},
                    {data: 'value'},
                    {data: 'dollar_value'},
                    {data: 'receive_by'},
                    {data: 'barcode'},
                    {data: 'circulation'},
                    {data: 'first_name'},
                    {data: 'city'},
                    {data: 'birth_date'},
                    {data: 'created_at'},
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
        function applySaveSearch(id) {
            let filters = [];
            $('.filtersSaveSearch-'+id).each(function(i,obj){
                console.log(i,obj);
                let data = {key: $(obj).data('filter'), value: $(obj).data('filter-val') , db:$(obj).data('db-name'), column:$(obj).data('sec-col')};
                filters.push(data);
            });
            console.log('filters');
            console.log(filters);
            filters.map((data) => {
                let textData = data.key + ' ' + data.column + ' ' + data.value + ' in ' + data.db;
                let filterHtml = '<button class="btn btn-default filters" data-sec-col="' + data.value + '" data-db-name="' + data.db + '" data-filter="' + data.key + '" data-filter-val="' + data.value + '"><em>' + textData + ' </em> <span><i class="fa fa-times-circle"></i></span></button>';
                addFilterHtml(filterHtml);
                $('#irc-data').DataTable().clear().destroy();
            });
            $('#saveSearchPoUp').modal('hide');
            getIrcData();
        }
        function renderSaveDataRecord(){
            $.ajax({
                type: 'GET',
                url: '/admin/report-builder/get/searchData',

                success: function (response) {
                    console.log('response');
                    console.log(response);
                    console.log('JSON.parse(response)');
                    let responseData = JSON.parse(response);
                    console.log(responseData);
                    $('#modal-body').append('');
                    $('#modal-body').html('');
                    if (responseData.length <= 0) {
                        let html = '<p>No Favourite Search Found Data</p>';
                        $('#modal-body').append(html);
                    } else {
                        $('#modal-body').append('');
                        $('#modal-body').html('');
                        responseData.map((data) => {
                            let html = '<div class="row"><div class="col-md-12" style="margin-bottom:7px;"><p><b>' + data.name + '</b></p>' +
                                    data.data.map((d) => {
                                        let textData = d.key + ' ' + d.column + ' ' + d.value + ' in ' + d.db;
                                        return '<button style="margin-right: 5px;" class="btn btn-default filtersSaveSearch-'+data.id+'" data-sec-col="' + d.value + '" data-db-name="' + d.db + '" data-filter="' + d.key + '" data-filter-val="' + d.value + '"><em>' + textData + ' </em></button>';
                                    })
                                    +'<button class="btn btn-success btn-sm" style="margin-right: 5px;" onclick="applySaveSearch('+data.id+')">Apply</button>' +
                                    '<button class="btn btn-danger btn-sm" onclick="deleteSaveFilter('+data.id+')">Delete</button>';
                                +'</div></div><br>';
                            $('#modal-body').append(html);
                        });
                    }
                }
            });
        }

        function deleteSaveFilter(id){
            $.ajax({
                type: 'GET',
                url: '/admin/report-builder/delete/filter/'+id,

                success: function (response) {
                    console.log('response');
                    console.log('JSON.parse(response)');
                    console.log(response);
                    let responseData = JSON.parse(response);
                    console.log(responseData);
                    $('#modal-body').append('');
                    $('#modal-body').html('');
                    if (responseData.length <= 0) {
                        let html = '<p>No Favourite Search Found Data</p>';
                        $('#modal-body').append(html);
                    } else {
                        $('#modal-body').append('');
                        $('#modal-body').html('');
                        responseData.map((data) => {
                            let html = '<div class="row"><div class="col-md-12" style="margin-bottom:7px;"><p><b>' + data.name + '</b></p>' +
                                data.data.map((d) => {
                                    let textData = d.key + ' ' + d.column + ' ' + d.value + ' in ' + d.db;
                                    return '<button style="margin-right: 5px;" class="btn btn-default filtersSaveSearch-'+data.id+'" data-sec-col="' + d.value + '" data-db-name="' + d.db + '" data-filter="' + d.key + '" data-filter-val="' + d.value + '"><em>' + textData + ' </em></button>';
                                })
                                +'<button class="btn btn-success btn-sm" style="margin-right: 5px;" onclick="applySaveSearch('+data.id+')">Apply</button>' +
                                '<button class="btn btn-danger btn-sm" onclick="deleteSaveFilter('+data.id+')">Delete</button>';
                            +'</div></div><br>';
                            $('#modal-body').append(html);
                        });
                    }
                },
                error: function (error) {
                    console.log('error');
                    console.log(error);
                }
            });
        }

        $(document).keypress(function(event){

            var keycode = (event.keyCode ? event.keyCode : event.which);
            if(keycode == '13'){
                $('#apply').trigger();
            }

        });

        $(document).ready(function(){
            // renderSaveDataRecord();

            $(document).on('click','#saveSearch', function (){
                let filters = [];
                $('.filters').each(function(i,obj){
                    let data = {key: $(obj).data('filter'), value: $(obj).data('filter-val') , db:$(obj).data('db-name'), column:$(obj).data('sec-col')};
                    filters.push(data);
                });
                console.log('filters');
                console.log(filters);
                let filter_name = $('#filter_name').val();
                let dataFilters = JSON.stringify(filters);
                let formData = new FormData();
                formData.append('_token','{{csrf_token()}}');
                formData.append('search_data',dataFilters);
                let data = {
                    '_token':'{{csrf_token()}}',
                    'search_data':dataFilters,
                    'filter_name':filter_name
                }
                $.ajax({
                    type:'POST',
                    url:'/admin/report-builder/save/search',
                    data:data,

                    success: function (response) {
                        console.log('response');
                        console.log(response);
                        console.log('JSON.parse(response)');
                        let responseData = JSON.parse(response);
                        console.log(responseData);
                        $('#modal-body').append('');
                        $('#modal-body').html('');
                        if (responseData.length <= 0) {
                            let html = '<p>No Favourite Search Found Data</p>';
                            $('#modal-body').append(html);
                        } else {
                            $('#modal-body').append('');
                            $('#modal-body').html('');
                            responseData.map((data) => {
                                let html = '<div class="row"><div class="col-md-12" style="margin-bottom:7px;"><p><b>' + data.name + '</b></p>' +
                                    data.data.map((d) => {
                                        let textData = d.key + ' ' + d.column + ' ' + d.value + ' in ' + d.db;
                                        return '<button style="margin-right: 5px;" class="btn btn-default filtersSaveSearch-'+data.id+'" data-sec-col="' + d.value + '" data-db-name="' + d.db + '" data-filter="' + d.key + '" data-filter-val="' + d.value + '"><em>' + textData + ' </em></button>';
                                    })
                                    +'<button class="btn btn-success btn-sm" style="margin-right: 5px;" onclick="applySaveSearch('+data.id+')">Apply</button>' +
                                    '<button class="btn btn-danger btn-sm" onclick="deleteSaveFilter('+data.id+')">Delete</button>';
                                +'</div></div><br>';
                                $('#modal-body').append(html);
                            });
                        }
                        $('#filter_name').val('');
                        $('#savefilterPoUp').modal('hide');
                    },
                    error: function (error) {
                        console.log('error');
                        console.log(error);
                    }
                });
            });
            $(document).on('click','#apply',function(){
                let column = $('#column').val();
                let column2 = $('#columnSelect').val();
                let dbName = $('#column option:selected').data('db');
                console.log(dbName);
                console.log('column2');
                console.log(column2);
                let filterText = $('#filter-text').val();
                let newTextData = column + ' ' + filterText + ' ' + column2 +' in ' + dbName;
                let oldTextData2 = sessionStorage.getItem('oldTextData');
                if(newTextData != oldTextData2) {
                    let textData = column + ' ' + filterText + ' ' + column2 + ' in ' + dbName;
                    let filterHtml = '<button class="btn btn-default filters" data-sec-col="' + column2 + '" data-db-name="' + dbName + '" data-filter="' + column + '" data-filter-val="' + filterText + '"><em>' + textData + ' </em> <span><i class="fa fa-times-circle"></i></span></button>';
                    addFilterHtml(filterHtml);
                    $('#irc-data').DataTable().clear().destroy();

                    sessionStorage.setItem('oldTextData', textData);
                    getIrcData();
                } else {
                    getIrcData();
                }
                // }
            });

            $(document).ready(function() {
                $.fn.dataTable.ext.errMode = 'none';
                sessionStorage.removeItem('oldTextData');
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

                sessionStorage.removeItem('oldTextData');
                $(this).closest('button').remove();
                getIrcData();
            });
            $(document).on('click','#exportCsv','click',function(){
                let startDate = '';
                let endDate = '';
                let filters = [];
                $('.filters').each(function(i,obj){
                    let data = {key: $(obj).data('filter'), value: $(obj).data('filter-val') , db:$(obj).data('db-name'), column:$(obj).data('sec-col')};
                    filters.push(data);
                });
                let arrayFilters1 = [];
                let arrayFilters2 = [];
                let arrayFilters3 = [];
                filters.map((data) => {
                    if(data.db == 'entries_irc_view') {
                        if(arrayFilters1.length <= 0) {
                            let dataArr = {key: [], value: [], db: data.db, column: []};
                            dataArr.key.push({'key': data.key});
                            dataArr.value.push({'value': data.value});
                            dataArr.column.push({'column': data.column});
                            arrayFilters1.push(dataArr);
                        } else {
                            if(arrayFilters1[0].column[0].column != data.column) {
                                // if(arrayFilters1[0].key[0].key != data.key) {
                                arrayFilters1[0].key.push({'key': data.key})
                                // }
                                if(arrayFilters1[0].value.length < 0 || arrayFilters1[0].value[0].value != data.value) {
                                    arrayFilters1[0].value.push({'value': data.value})
                                }
                                arrayFilters1[0].column.push({'column': data.column})
                            }
                        }
                    }
                    if(data.db == 'entries_mir_view') {
                        if(arrayFilters2.length <= 0) {
                            let dataArr = {key: [], value: [], db: data.db, column: []};
                            dataArr.key.push({'key': data.key});
                            dataArr.value.push({'value': data.value});
                            dataArr.column.push({'column': data.column});
                            arrayFilters2.push(dataArr);
                        } else {
                            if(arrayFilters2[0].column[0].column != data.column) {
                                // if(arrayFilters2[0].key[0].key != data.key) {
                                arrayFilters2[0].key.push({'key': data.key})
                                // }
                                if(arrayFilters2[0].value.length < 0 || arrayFilters2[0].value[0].value != data.value) {
                                    arrayFilters2[0].value.push({'value': data.value})
                                }
                                arrayFilters2[0].column.push({'column': data.column})
                            }
                        }
                    }
                    if(data.db == 'coupons_view') {
                        if(arrayFilters3.length <= 0) {
                            let dataArr = {key: [], value: [], db: data.db, column: []};
                            dataArr.key.push({'key': data.key});
                            dataArr.value.push({'value': data.value});
                            dataArr.column.push({'column': data.column});
                            arrayFilters3.push(dataArr);
                        } else {
                            if(arrayFilters3[0].column[0].column != data.column) {
                                // if(arrayFilters3[0].key[0].key != data.key) {
                                arrayFilters3[0].key.push({'key': data.key})
                                // }
                                if(arrayFilters3[0].value.length < 0 || arrayFilters3[0].value[0].value != data.value) {
                                    arrayFilters3[0].value.push({'value': data.value})
                                }
                                arrayFilters3[0].column.push({'column': data.column})
                            }
                        }
                    }
                });




                let oneArray = arrayFilters1.concat(arrayFilters2);

                let mergeThreeArray = oneArray.concat(arrayFilters3);

                $('#exportForm input').remove();
                $('#exportForm').attr('action', '/admin/report/export-irc-csv');
                $('#exportForm').append('<input type="hidden" name="filters" value=' +JSON.stringify(mergeThreeArray)+ ' />');
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