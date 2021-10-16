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
        <!-- BEGIN PAGE CONTENT-->
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="portlet box blue-hoki ">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-reorder"></i> Beverage Promotions Status
                        </div>
                    </div>
                    <div>
                        <div class="table-scrollable">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>
                                             ID
                                        </th>
                                        <th>
                                             First Name
                                        </th>
                                        <th>
                                             Last Name
                                        </th>
                                        <th>
                                             Status
                                        </th>
                                        <th>
                                             Date Entered
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($entries as $entry)
                                        <tr>
                                            <td>{{$entry->id}}</td>
                                            <td>{{$entry->first_name}}</td>
                                            <td>{{$entry->last_name}}</td>
                                            <td>{{$entry->status}}</td>
                                            <td>{{$entry->created_at}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="portlet box blue-hoki ">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-reorder"></i> Check Processing Status
                        </div>
                    </div>
                    <div>
                        <div class="table-scrollable">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>
                                             ID
                                        </th>
                                        <th>
                                             Name
                                        </th>
                                        <th>
                                             Status
                                        </th>
                                        <th>
                                             Last Updated
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($imports as $import)
                                        <tr>
                                            <td>{{$import->transaction_id}}</td>
                                            <td>{{$import->payee}}</td>
                                            <td>{{$import->status_name}}</td>
                                            <td>{{$import->timestamp}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 col-md-offset-5">
                <a type="button" href="/lookup" class="demo-loading-btn btn btn-primary"> Go Back To Search </a>
            </div>
        </div>
    </div>
</div>

@stop