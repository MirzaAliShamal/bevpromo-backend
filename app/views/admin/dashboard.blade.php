@extends('layouts.default')

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
        <div class="row" style="margin-bottom: 5rem">
            <div class="col-md-12">
                <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                <h3 class="page-title">
                    Admin Dashboard
                </h3>

                <!-- END PAGE TITLE & BREADCRUMB-->
            </div>
        </div>
        <!-- END PAGE HEADER-->
        <!-- BEGIN PAGE CONTENT-->
        <!-- BEGIN DASHBOARD STATS -->



        <div class="row">
            <div class="col-md-4">
                <div class=" card shadow p-3 mb-5 bg-white rounded " style="width: 26rem;margin: 0 auto;">

                    <div class="card-body" align="center" style="margin-top: 25px;">
                        <span class="box b1 shadow p-3 mb-5 bg-white rounded">
                            <h2><b>IRC Panel</b> </h2>
                        </span>

                        <button onclick="window.open('/admin/entries/irc-dt')" class="buttonDash btn1"
                            style="border-radius:40px"><span>Entries
                            </span></button><br />
                        <button onclick="window.open('/admin/coupons/irc')"
                            class="buttonDash btn1"><span>Programs</span></button><br />
                        <button onclick="window.open('/admin/retailers/irc')" class="buttonDash btn1"><span>Retailers
                            </span></button>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class=" card shadow p-3 mb-5 bg-white rounded " style="width: 26rem;margin: 0 auto;">

                    <div class="card-body" align="center" style="margin-top: 25px;">
                        <span class="box b2 shadow p-3 mb-5 bg-white rounded">
                            <h2><b>MIR Panel</b> </h2>
                        </span>

                        <button onclick="window.open('/admin/entries/mir-dt')" class="buttonDash btn1"
                            style="border-radius:40px"><span>Entries
                            </span></button><br />
                        <button onclick="window.open('/admin/coupons/mir')"
                            class="buttonDash btn1"><span>Programs</span></button><br />
                        <button onclick="window.open('/admin/retailers/mir')" class="buttonDash btn1"><span>Retailers
                            </span></button>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class=" card shadow p-3 mb-5 bg-white rounded " style="width: 26rem;margin: 0 auto;">

                    <div class="card-body" align="center" style="margin-top: 25px;">
                        <span class="box b3 shadow p-3 mb-5 bg-white rounded">
                            <h2><b>Admin Panel</b> </h2>
                        </span>

                        <button onclick="window.open('/admin/retailers/irc')" class="buttonDash btn3"><span>IRC
                                Retailers </span></button>
                        <button onclick="window.open('/admin/retailers/mir')" class="buttonDash btn3"><span>MIR
                                Retailers </span></button>
                        <button onclick="window.open('/admin/suppliers')"
                            class="buttonDash btn3"><span>Suppliers</span></button>
                        <button onclick="window.open('/admin/brands')" class="buttonDash btn3"><span>Brands
                            </span></button>
                        <button onclick="window.open('/admin/clients')"
                            class="buttonDash btn3"><span>Clients</span></button>
                        <button onclick="window.open('/admin/clearinghouses')" class="buttonDash btn3"><span>Clearing
                                House </span></button>
                        <button onclick="window.open('/admin/admins')" class="buttonDash btn3"><span>Admin
                                Users</span></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class=" card shadow p-3 mb-5 bg-white rounded " style="width: 26rem;margin: 0 auto;">

                    <div class="card-body" align="center" style="margin-top: 25px;">
                        <span class="box b4 shadow p-3 mb-5 bg-white rounded">
                            <h2><b>DR Panel</b> </h2>
                        </span>
                        <button onclick="window.open('/admin/entries/all?campaign=dmir&&program=mir')"
                            class="buttonDash btn4"><span>Entries </span></button><br />
                        <button onclick="window.open('/admin/coupons/all?campaign=dmir')"
                            class="buttonDash btn4"><span>Programs</span></button><br />
                        <button onclick="window.open('#')" class="buttonDash btn4"><span>Retailers
                            </span></button>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class=" card shadow p-3 mb-5 bg-white rounded " style="width: 26rem;margin: 0 auto;">

                    <div class="card-body" align="center" style="margin-top: 25px;">
                        <span class="box b5 shadow p-3 mb-5 bg-white rounded">
                            <h2><b>Sweeps Panel</b> </h2>
                        </span>
                        <button style="margin-top: 2rem;"
                            onclick="window.open('/admin/entries/all?campaign=sweepstakes&&program=mir')"
                            class="buttonDash btn5"><span>Entries </span></button><br />
                        <button style="margin-top: 2rem;margin-bottom:2rem"
                            onclick="window.open('/admin/coupons/all?campaign=sweepstakes')"
                            class="buttonDash btn5"><span>Programs</span></button><br />

                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class=" card shadow p-3 mb-5 bg-white rounded " style="width: 26rem;margin: 0 auto;">

                    <div class="card-body" align="center" style="margin-top: 25px;">
                        <span class="box b6 shadow p-3 mb-5 bg-white rounded">
                            <h2><b>Reports Panel</b> </h2>
                        </span>

                        <button style="margin-top: 2rem;" onclick="window.open('#')"
                            class="buttonDash btn6"><span>Report Builder </span></button><br />
                        <button style="margin-top: 2rem;margin-bottom:2rem" onclick="window.open('#')"
                            class="buttonDash btn6"><span>Redemption</span></button><br />
                    </div>
                </div>
            </div>
        </div>








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
                    <a class="more" href="/admin/entries/irc">
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
                    <a class="more" href="/admin/entries/irc">
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
                    <a class="more" href="/admin/entries/mir">
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
                    <a class="more" href="/admin/entries/mir">
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