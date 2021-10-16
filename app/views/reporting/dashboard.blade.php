@extends('layouts.client-default')

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
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                <h3 class="page-title">
                    Reporting Dashboard
                </h3>

                <!-- END PAGE TITLE & BREADCRUMB-->
            </div>
        </div>
        <!-- END PAGE HEADER-->
        <!-- BEGIN PAGE CONTENT-->
        <!-- BEGIN DASHBOARD STATS -->
        <div class="row">
            <h3>IRC Entries At A Glance</h3>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="dashboard-stat blue-madison">
                    <div class="visual">
                        <i class="fa fa-barcode"></i>
                    </div>
                    <div class="details">
                        <div class="number">
                             {{$monthlyIrcCount}}
                        </div>
                        <div class="desc">
                             IRC Entries in {{ date('M') }}
                        </div>
                    </div>
                    <a class="more" href="/reporting/entries/irc">
                    View more <i class="m-icon-swapright m-icon-white"></i>
                    </a>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="dashboard-stat red-intense">
                    <div class="visual">
                        <i class="fa fa-barcode"></i>
                    </div>
                    <div class="details">
                        <div class="number">
                             {{$yearlyIrcCount}}
                        </div>
                        <div class="desc">
                             IRC Entries in {{ date('Y') }}
                        </div>
                    </div>
                    <a class="more" href="/reporting/entries/irc">
                    View more <i class="m-icon-swapright m-icon-white"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="row">
            <h3>MIR Entries At A Glance</h3>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="dashboard-stat green-haze">
                    <div class="visual">
                        <i class="fa fa-envelope"></i>
                    </div>
                    <div class="details">
                        <div class="number">
                             {{$monthlyMirCount}}
                        </div>
                        <div class="desc">
                             MIR Entries in {{ date('M') }}
                        </div>
                    </div>
                    <a class="more" href="/reporting/entries/mir">
                    View more <i class="m-icon-swapright m-icon-white"></i>
                    </a>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="dashboard-stat purple-plum">
                    <div class="visual">
                        <i class="fa fa-envelope"></i>
                    </div>
                    <div class="details">
                        <div class="number">
                             {{$yearlyMirCount}}
                        </div>
                        <div class="desc">
                             MIR Entries in {{ date('Y') }}
                        </div>
                    </div>
                    <a class="more" href="/reporting/entries/mir">
                    View more <i class="m-icon-swapright m-icon-white"></i>
                    </a>
                </div>
            </div>
        </div>


        <!-- END DASHBOARD STATS -->
        <!-- END PAGE CONTENT-->
    </div>
</div>
@stop