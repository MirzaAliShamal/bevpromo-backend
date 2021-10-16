@extends('layouts.main_dashboard')

@section('content')
<div class="fullscreen">
    <div class="row" style="margin: 2rem;text-align: center;">
        <div class="col-md-12">
            <!-- BEGIN PAGE TITLE & BREADCRUMB-->
            <h3 class="page-title">
                Admin Dashboard
            </h3>

            <!-- END PAGE TITLE & BREADCRUMB-->
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-xl-auto" style="margin: 5px;">
            <div class="card shadow p-3 mb-5 bg-white rounded" style="width: 25rem; margin: 0rem;">
                <div class="card-body" align="center" style="margin-top: 25px;">
                    <span class="box b1 shadow p-3 mb-5 bg-white rounded">
                        <h2><b>IRC Panel</b></h2>
                    </span>
                    {{-- onclick="window.open('/admin/coupons/irc')" --}}
                    {{-- onclick="window.location.href='/admin/entries/irc-dt'" --}}
                    <button onclick="window.location.href='/admin/entries/irc-dt'" class="button btn1">
                        <span>Entries </span></button><br />
                    <button onclick="window.location.href='/admin/coupons/irc'" class="button btn1">
                        <span>Programs</span></button><br />
                    <button onclick="window.location.href=('/admin/retailers/irc')" class="button btn1">
                        <span>Retailers </span>
                    </button>
                </div>
            </div>
        </div>
        <div class="col-xl-auto" style="margin: 5px;">
            <div class="card shadow p-3 mb-5 bg-white rounded" style="width: 25rem; margin: 0rem;">
                <div class="card-body" align="center" style="margin-top: 25px;">
                    <span class="box b2 shadow p-3 mb-5 bg-white rounded">
                        <h2><b>MIR Panel</b></h2>
                    </span>

                    <button onclick="window.location.href=('/admin/entries/mir-dt')" class="button btn2">
                        <span>Entries </span></button><br />
                    <button onclick="window.location.href=('/admin/coupons/mir')" class="button btn2">
                        <span>Programs</span></button><br />
                    <button onclick="window.location.href=('/admin/retailers/mir')" class="button btn2">
                        <span>Retailers </span>
                    </button>
                </div>
            </div>
        </div>
        <div class="col-xl-auto" style="margin: 5px;">
            <div class="card shadow p-3 mb-5 bg-white rounded" style="width: 25rem; margin: 0rem;">
                <div class="card-body" align="center" style="margin-top: 25px;">
                    <span class="box b3 shadow p-3 mb-5 bg-white rounded">
                        <h2><b>Admin Panel</b></h2>
                    </span>
                    <div class="row" align="center">
                        <button onclick="window.location.href=('/admin/retailers/irc')" class="button btn3">
                            <span>IRC Retailers </span>
                        </button>

                        <button onclick="window.location.href=('/admin/retailers/mir')" class="button btn3">
                            <span>MIR Retailers</span>
                        </button>
                    </div>
                    <div class="row">
                        <button onclick="window.location.href=('/admin/suppliers')" class="button btn3">
                            <span>Suppliers </span>
                        </button>

                        <button onclick="window.location.href=('/admin/brands')" class="button btn3">
                            <span>Brands </span>
                        </button>
                    </div>
                    <div class="row">
                        <button onclick="window.location.href=('/admin/clients')" class="button btn3">
                            <span>Clients </span>
                        </button>

                        <button onclick="window.location.href=('/admin/clearinghouses')" class="button btn3">
                            <span>Clearing House</span>
                        </button>
                    </div>
                    <div class="row ">
                        <button onclick="window.location.href=('/admin/admins')" class="button btn3">
                            <span>Users </span>
                        </button>
                        <button onclick="window.location.href=('/admin/coupons/types')" class="button btn3">
                            <span>Coupon Type </span>
                        </button>
                    </div>
                    <div class="row ">
                        <button onclick="window.location.href=('/admin/coupons/default-text')" class="button btn3">
                            <span>Default Fileds </span>
                        </button>
                        <button onclick="window.location.href=('/admin/coupons/default-faq')" class="button btn3">
                            <span>Default Faqs </span>
                        </button>
                    </div>
                    <div class="row ">
                        <button onclick="window.location.href=('/admin/denial/reasons')" class="button btn3">
                            <span>Denial Reasons</span>
                        </button>
                        <button onclick="window.location.href=('/admin/mir/status')" class="button btn3">
                            <span>Mir Status</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-xl-auto" style="margin: 5px;">
            <div class="card shadow p-3 mb-5 bg-white rounded" style="width: 25rem; margin: 0rem;">
                <div class="card-body" align="center" style="margin-top: 25px;">
                    <span class="box b4 shadow p-3 mb-5 bg-white rounded">
                        <h2><b>DR Panel</b></h2>
                    </span>
                    <button onclick="window.location.href=('/admin/entries/all?campaign=dmir&&program=mir')"
                        class="button btn4">
                        <span>Entries </span></button><br />
                    <button onclick="window.location.href=('/admin/coupons/all?campaign=dmir')" class="button btn4">
                        <span>Programs</span></button><br />
                    <button onclick="window.location.href=('/admin/retailers/mir')" class="button btn4">
                        <span>Retailers </span>
                    </button>
                </div>
            </div>
        </div>
        <div class="col-xl-auto" style="margin: 5px;">
            <div class="card shadow p-3 mb-5 bg-white rounded" style="width: 25rem; margin: 0rem;">
                <div class="card-body" align="center" style="margin-top: 25px;">
                    <span class="box b5 shadow p-3 mb-5 bg-white rounded">
                        <h2><b>Sweeps Panel</b></h2>
                    </span>
                    <button onclick="window.location.href=('/admin/entries/all?campaign=sweepstakes&&program=mir')"
                        class="button btn5">
                        <span>Entries </span></button><br />
                    <button onclick="window.location.href=('/admin/coupons/all?campaign=sweepstakes')"
                        class="button btn5">
                        <span>Programs</span></button><br />
                </div>
            </div>
        </div>
        <div class="col-xl-auto" style="margin: 5px;">
            <div class="card shadow p-3 mb-5 bg-white rounded" style="width: 25rem; margin: 0rem;">
                <div class="card-body" align="center" style="margin-top: 25px;">
                    <span class="box b6 shadow p-3 mb-5 bg-white rounded">
                        <h2><b>Reports Panel</b></h2>
                    </span>

                    <button onclick="window.location.href=('/admin/report-builder')" class="button btn6">
                        <span>Report Builder </span></button><br />
                    <button onclick="window.location.href=('#')" class="button btn6">
                        <span>Redemption</span></button><br />
                </div>
            </div>
        </div>
    </div>
</div>

@stop