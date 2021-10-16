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
                    <i class="fa fa-users"></i>MIR Entries
                </div>
                <div class="col-md-2 pull-right">
                    <a href="/admin/entries/mir/create" class="btn green " role="button">Add New Entry <i
                            class="fa fa-plus"></i></a>
                </div>
                <div class="col-md-2 pull-right">
                    <a href="/admin/invoice/mir/invoice_all" class="btn red" role="button">Invoice All MIR Entries <i
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
                                    class='form-control datepicker-jq1' required='' />

                            </div>

                        </div>

                    </div>



                    <div class="col-md-6">

                        <div class="form-inline">
                            <div class="form-group">

                                <select name="column" class="form-control" id="column">
                                    <option value="all">All</option>
                                    <option value="address">Address</option>
                                    <option value="birth_date">Birth Date</option>
                                    <option value="city">City</option>
                                    <option value="denial_reason_id">Denial Reason</option>
                                    <option value="dollar_value">Dollar Value</option>
                                    <option value="email">Email Address</option>
                                    <option value="first_name">First Name</option>
                                    <option value="id">ID</option>
                                    <option value="last_name">Last Name</option>
                                    <option value="retailer">Retailer</option>
                                    <option value="state">State</option>
                                    <option value="status">Status</option>
                                    <option value="zip">Zip</option>
{{--                                    <option value="is_invoiced">Invoiced</option>--}}
                                </select>
                            </div>
                            <div class="form-group">
                                <input type="text" name="filter" placeholder="Type to Filter" class="form-control"
                                    id="filter-text">
                                <button type="button" class="btn btn-default" id="apply">Add Filter</button>
                                <button type="button" class="btn btn-default" onclick="changeStatusPopUp('a')">Change Status</button>
                                <button type="button" class="btn btn-default" onclick="changeStatusPopUp('b')">Change Paid Status</button>
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
                            <table class="table table-striped table-bordered table-hover" id="mir-data">

                                <thead>
                                    <tr>
                                        <th style="text-align: center;"><input type="checkbox" name="select_all" value="1" id="example-select-all"></th>
                                        <th>ID</th>
                                        <th>Retailer</th>
                                        <th>Program</th>
                                        {{-- <th>Owner</th> --}}
                                        <th>FName</th>
                                        <th>LName</th>
                                        <th>Address</th>
                                        <th>City</th>
                                        <th>State</th>
                                        {{-- <th>CType</th> --}}
                                        <th>Zip</th>
                                        <th>Status</th>
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
</div>
</div>


<!-- Modal -->
<div id="changePaidStatusPopUp" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Change Paid Status</h4>
            </div>
            <div class="modal-body">
               <div class="row">
                  <div class="col-md-12">
                      <?php
                        $paid_status = Constant::$paid_status;
                      ?>
                      <label>Select Paid Status</label>
                      <select class="form-control" name="paid_status" id="paid_status">
                            @foreach($paid_status as $status)
                                <option value="{{$status}}">{{$status}}</option>
                            @endforeach
                      </select>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" onclick="submitChangeStatus('a')">Submit</button>
            </div>
        </div>

    </div>
</div>

<div id="changeStatusPopUp" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Change Status</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <?php
                            $status = MirStatus::where('active','=',MirStatus::active)->get();
                        ?>
                        <label>Select Status</label>
                        <select class="form-control" name="s_status" id="s_status">
                            @foreach($status as $st)
                                <option value="{{$st->id}}">{{$st->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" onclick="submitChangeStatus('b')">Submit</button>
            </div>
        </div>

    </div>
</div>
@stop
@push('footer-script')
    <script>

    function changeStatusPopUp(val){
        if(window.checkboxIsSelected) {
            if (val == 'a') {
                $('#changeStatusPopUp').modal('show');
            } else {
                $('#changePaidStatusPopUp').modal('show');
            }
        }
    }
    function checkboxSelected(id) {
       let checked = $('#checkbox-'+id).prop('checked');
       console.log(checked,id);
       $.ajax({
           type:'GET',
           url:'/admin/update/entry?checked='+checked+'&id='+id,
           success: function (response){
               console.log('response');
               console.log(response);
           },
           error: function (error){
               console.log('error');
               console.log(error);
           }

       });
        getMirData();
        if(checked) {
           window.checkboxIsSelected = true;
       } else {
           window.checkboxIsSelected = false;
       }
    }

    window.checkboxIsSelected = false;
    function getMirData() {
        $.fn.dataTable.ext.errMode = 'none';
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
            let data = {key: $(obj).data('filter'), value: $(obj).data('filter-val'), paid_status: $(obj).data('paid-status') };
            filters.push(data);
        });

        table = $('#mir-data').DataTable({
                "processing": true,
                "serverSide": true,
                "lengthChange": false,
                "searching":false,
                "bFilter":false,
                "pageLength": 20,
                "pagingType": "full_numbers",
                "ajax": {
                    "url": "/admin/entries/mir-data",
                    "type": "POST",
                    "data": {
                        "startDate": startDate,
                        "endDate": endDate,
                        'filters': filters
                    }
                },
            'columnDefs': [{
                'targets': 0,
                'searchable': false,
                'orderable': false,
                'className': 'dt-body-center',
                'render': function (data, type, full, meta){
                    return '<input type="checkbox" name="id[]" data-id="'+data.id+'" class="check_quality" id="checkbox-'+data.id+'" onclick="checkboxSelected('+data.id+')" value="' + $('<div/>').text(data.id).html() + '">';
                }
            }],
            columns: [
                {data: null, defaultContent:''},
                {data: 'id', name: 'id'},
                {data: 'retailer', name: 'retailer'},
                {data: 'coupon', name: 'coupon'},
                // {data: 'owner', name: 'owner'},
                {data: 'first_name', name: 'first_name'},
                {data: 'last_name', name: 'last_name'},
                {data: 'address', name: 'address'},
                {data: 'city', name: 'city'},
                {data: 'state', name: 'state'},
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
                {data: 'zip', name: 'zip'},
                {data: 'status', name: 'status'},
               {data: 'created_at', name: 'created_at'},
                {
                    "data": "action",
                    "name": "action",
                    "render": function (data, type, row, meta) { 
                        return "<td><a href='/admin/entries/mir/"+row.id+"/edit' data-id=" + row.id + " class='openEditForm'><i class='fa fa-pencil'></i>Edit </a></td>";
                        // ||<a href='javascript:;' class='btndelt' data-id="+row.id+" role='button'><i class='fa fa-trash-o'></i>Delete </a>
                    },
                },
            ],
            rowCallback: function ( row, data ) {
                updateStatus(data);
                // Set the checked state of the checkbox in the table
                if(data.checkbox == 1) {
                    window.checkboxIsSelected = true;
                }
                $('input.check_quality', row).prop( 'checked', data.checkbox == 1 );
            }
        });
    }
    // Handle click on "Select all" control
    $('#example-select-all').on('click', function(){
        // Get all rows with search applied
        var rows = table.rows({ 'search': 'applied' }).nodes();
        console.log('rows');
        console.log(rows);
        // Check/uncheck checkboxes for all rows in the table
        let checkboxes = $('input[type="checkbox"]', rows).prop('checked', this.checked);
        window.checkboxIsSelected = true;
        getData();
    });


    function updateStatus(data){

    }

    function submitChangeStatus(val){
        $('.clsLoader').show();
        // var oTable = $("#mir-data").dataTable();
        // var allPages = oTable.fnGetNodes();
        // var rowcollection = oTable.$("input:checked", {"page":"all"});
        var arrayData = [];
        // rowcollection.each(function (index, elem) {
        //     var checkbox_value = $(elem).val();
        //     //Do something with 'checkbox_value'
        //     arrayData.push({id:checkbox_value,checked:1})
        // });

            $.ajax({
                type:'GET',
                url:'/admin/get/checked/data',
                success: function (response) {
                    console.log('response');
                    let parseData = JSON.parse(response);
                    parseData.map(function (data){
                        arrayData.push({id:data.id,checkbox:data.active});
                    });
                },
                error: function (error) {
                    console.log('error');
                    console.log(error);
                }
            })
        setTimeout(function () {
            console.log('please wait');
            console.log(arrayData);

            if(val == 'b') {
            let value = $('#s_status').val();
            console.log('value select s status');
            console.log(value);
            console.log(arrayData);
            let form = new FormData();
            form.append('array',JSON.stringify(arrayData));
            form.append('value',value);
            $.ajax({
                method: 'post',
                processData: false,
                contentType: false,
                cache: false,
                url:  '/admin/simple/status/update',
                data: form,

                success: function (response){
                    $('.clsLoader').hide();
                    console.log('response');
                    console.log(response);
                    window.location.reload();
                },
                error: function (error){
                    $('.clsLoader').hide();
                    console.log('error');
                    console.log(error);
                }

            });
        }

            if(val == 'a') {
            let value = $('#paid_status').val();
            console.log('value select paid status');
            console.log(value);
            console.log(arrayData);
            let form = new FormData();
            form.append('array',JSON.stringify(arrayData));
            form.append('value',value);
            $.ajax({
                method: 'post',
                processData: false,
                contentType: false,
                cache: false,
                url:  '/admin/paid/status/update',
                data: form,

                success: function (response){
                    console.log('response');
                    console.log(response);
                    $('.clsLoader').hide();
                    window.location.reload();
                },
                error: function (error){
                    $('.clsLoader').hide();
                    console.log('error');
                    console.log(error);
                }

            });
        }
        },2000);
    }

    function checkCheckboxChecked(){
        let prefilled = $('#example-select-all').prop('checked');
        if(prefilled) {
            console.log('checkbox checked');
            $('#example-select-all').prop('checked',true);
        } else {
            $('#example-select-all').prop('checked',false);
        }
    }


    function getData(){
        var bulkArray = [];
        var id = '';
        var oTable = $("#mir-data").dataTable();

        $(".check_quality:checked", oTable.fnGetNodes()).each(function() {
            if (id != "") {
                id = id + "," + $(this).data('id');
            } else {
                id = $(this).data('id');
            }
        });
        console.log('id id id id id');
        let splitData = id.split(',');
        splitData.map(function (data){
            bulkArray.push({id:data});
        });
        let checkValueAll = $('#example-select-all').prop('checked');
        let value;
        if(checkValueAll) {
            value = 1;
        } else {
            value = 0;
        }
        console.log(bulkArray);
        let form = new FormData();
        form.append('array',JSON.stringify(bulkArray));
        form.append('value',value);
        $.ajax({
           method: 'post',
           processData: false,
           contentType: false,
           cache: false,
           url:  '/admin/update/full/page/checkbox',
           data: form,

           success: function (response){
               console.log('response');
               console.log(response);
           },
           error: function (error){
              console.log('error');
              console.log(error);
           }

        });
    }
    $('#mir-data').on('draw.dt', function(data) {
        // do action here
        console.log('working');
        console.log(data);
    });
    // $(document).on('click', '.btndelt', function () {
    //     var r = confirm("Confirm Delete!");
    //     if (r == true) {
    //         var id=$(this).data("id");
    //         //alert(id);
    //         data = {
    //         "_token": "{{ csrf_token() }}",
    //         "id":id,
    //         }
    //         var url = "/admin/entries/mir-dt/delete";

    //         $.ajax({
    //             type: "post",
    //             url: url,
    //             data:data,
    //             success: function(data) {
    //                 var responce = JSON.parse(data);
    //                 if (responce['success'] == true)
    //                 {
    //                     alert("Data deleted");
    //                     location.reload(true);
    //                 }
    //                 else
    //                     alert("There is an error")
    //             },
    //             error: function() {
    //                 alert("There is an Error");
    //             },
    //         });
            
    //     } 
    // });
    function formateDate(date) {
        let monthNames = [ "Jan", "Feb", "Mar", "Apr", "May", "Jun", 
        "Jul", "Aug", "Sep", "Oct", "Nov", "Dec" ];
        let month = date.getMonth();
        let day = date.getDate();
        let year = date.getFullYear();
        let returnDate = monthNames[month] + ' ' + day +', ' + year;
        return returnDate;
    }
    function addFilterHtml(html) {
        let datesLength = $('.dates').length;
        let filtersLength = $('.filters').length;
        if(datesLength == 0 && filtersLength == 0) {
                //First Filter
                $('.applied-filters').html(html);
            }
            else {
                $('.applied-filters').append(html);
            }
    }
    $(document).ready(function(){
        getMirData();
        $(document).on('click','#apply',function(){
            let column = $('#column').val();
            let filterText = $('#filter-text').val();
            let paid_status = $('#paid_status').val();
            let filterExist = false;
            if(paid_status == '' && filterText == '') {
                return;
            }
            $('.filters').each(function(i,obj){
                if($(obj).data('filter') == column) {
                    filterExist = true;
                }
            });
            if(!filterExist) {
                let filterHtml = '<button class="btn btn-default filters" data-paid-status="'+ paid_status +'" data-filter="'+ column +'" data-filter-val="'+ filterText +'"><em>' + filterText + ' in ' + column + ' </em> <span><i class="fa fa-times-circle"></i></span></button>';
                addFilterHtml(filterHtml);
                $('#mir-data').DataTable().clear().destroy();
                getMirData();
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
                $('#mir-data').DataTable().clear().destroy();
                getMirData();

        }

        $(document).on('click','.fa-times-circle',function() {
            $('#mir-data').DataTable().clear().destroy();
            $(this).closest('button').remove();
            getMirData();
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
            $('#exportForm').attr('action', '/admin/entries/export-mir-csv');
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
            $('#exportForm').attr('action', '/admin/entries/export-mir-json');
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
            $('#exportForm').attr('action', '/admin/entries/export-mir-pdf');
            $('#exportForm').append('<input type="hidden" name="startDate" value="'+startDate+'" />');
            $('#exportForm').append('<input type="hidden" name="endDate" value="'+endDate+'" />');
            $('#exportForm').append('<input type="hidden" name="filters" value=' +JSON.stringify(filters)+ ' />');
            $('#exportForm').submit();
        });
    });
</script>
@endpush