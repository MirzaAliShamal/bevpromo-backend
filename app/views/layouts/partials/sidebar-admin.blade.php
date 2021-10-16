{{-- <div class="page-sidebar-wrapper">
    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
    <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
    <div class="page-sidebar navbar-collapse collapse">
        <!-- BEGIN SIDEBAR MENU -->
        <ul class="page-sidebar-menu page-sidebar-menu-closed" data-auto-scroll="true" data-slide-speed="200">
            <!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
            <li class="sidebar-toggler-wrapper">
                <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
                <div class="sidebar-toggler">
                </div>
                <!-- END SIDEBAR TOGGLER BUTTON -->
            </li>
            <li class="start {{ Request::is('dashboard') ? 'active' : '' }}">
<a href="/admin/dashboard">
    <i class="fa fa-home"></i>
    <span class="title">Dashboard</span>
</a>
</li>
<li {{ Request::is('entry/*') ? 'active open' : '' }}>
    <a href="javascript:;">
        <i class="fa fa-pencil-square-o"></i>
        <span class="title">Program Entries</span>
        <span class="arrow "></span>
    </a>
    <ul class="sub-menu">
        <li>
            <a href="/admin/entries/irc">
                <i class="fa fa-barcode"></i>
                IRC Entry</a>
        </li>
        <li>
            <a href="/admin/entries/irc-dt">
                <i class="fa fa-barcode"></i>
                IRC V2.0 Entry</a>
        </li>
        <li>
            <a href="/admin/entries/mir">
                <i class="fa fa-envelope"></i>
                MIR Entry</a>
        </li>
        <li>
            <a href="/admin/entries/mir-dt">
                <i class="fa fa-barcode"></i>
                MIR V2.0 Entry</a>
        </li>
        <li>
            <a href="/admin/entries/all">
                <i class="fa fa-barcode"></i>
                All Entries</a>
        </li>
        <li>
            <a href="/admin/entries/campaigns">
                <i class="fa fa-barcode"></i>
                Campaigns</a>
        </li>
        <li>
            <a href="/admin/entries/irc10">
                <i class="fa fa-barcode"></i>
                IRC Entry (Entry Only, 10 records)</a>
        </li>
    </ul>
</li>
<li {{ Request::is('entry/*') ? 'active open' : '' }}>
    <a href="javascript:;">
        <i class="fa fa-pencil-square-o"></i>
        <span class="title">Entries</span>
        <span class="arrow "></span>
    </a>
    <ul class="sub-menu">
        <li>
            <a href="/admin/entries/irc-dt">
                <i class="fa fa-barcode"></i>
                IRC Entry</a>
        </li>
        <li>
            <a href="/admin/entries/mir-dt">
                <i class="fa fa-barcode"></i>
                MIR Entry</a>
        </li>
        <li>
            <a href="/admin/entries/all?campaign=dmir&&program=mir">
                <i class="fa fa-barcode"></i>
                Digital MIR Entry</a>
        </li>
        <li>
            <a href="/admin/entries/all?campaign=sweepstakes&&program=mir">
                <i class="fa fa-barcode"></i>
                Sweepstakes Entry</a>
        </li>
    </ul>
</li>
<!--
            <li>
                <a href="javascript:;">
                    <i class="fa fa-dollar"></i>
                    <span class="title">Program Invoices</span>
                    <span class="arrow "></span>
                </a>
                <ul class="sub-menu">
                    <li>
                        <a href="/admin/invoices/irc">
                            <i class="fa fa-barcode"></i>
                            IRC Invoices</a>
                    </li>
                    <li>
                        <a href="/admin/invoices/mir">
                            <i class="fa fa-envelope"></i>
                            MIR Invoices</a>
                    </li>
                </ul>
            </li>
            !-->
<!-- <li>
                <a href="javascript:;">
                    <i class="fa fa-ticket"></i>
                    <span class="title">Program Coupons</span>
                    <span class="arrow "></span>
                </a>
                <ul class="sub-menu">
                    <li>
                        <a href="/admin/coupons/irc">
                            <i class="fa fa-barcode"></i>
                            IRC Coupons</a>
                    </li>
                    <li>
                        <a href="/admin/coupons/mir">
                            <i class="fa fa-envelope"></i>
                            MIR Coupons</a>
                    </li>
                    
                    <li>
                        <a href="/admin/coupons/all">
                            <i class="fa fa-envelope"></i>
                            Coupons V2.0</a>
                    </li>
                    
                </ul>
            </li> -->
<li>
    <a href="javascript:;">
        <i class="fa fa-ticket"></i>
        <span class="title">Programs</span>
        <span class="arrow "></span>
    </a>
    <ul class="sub-menu">
        <li>
            <a href="/admin/coupons/irc">
                <i class="fa fa-barcode"></i>
                IRC</a>
        </li>
        <li>
            <a href="/admin/coupons/mir">
                <i class="fa fa-envelope"></i>
                MIR</a>
        </li>
        <li>
            <a href="/admin/coupons/all?campaign=dmir">
                <i class="fa fa-envelope"></i>
                Digital MIR</a>
        </li>
        <li>
            <a href="/admin/coupons/all?campaign=sweepstakes">
                <i class="fa fa-envelope"></i>
                Sweepstakes</a>
        </li>

        <!--                    <li>
                        <a href="/admin/coupons/all?campaign=goldencork">
                            <i class="fa fa-envelope"></i>
                            Golder Cork</a>
                    </li>-->
        <li>
            <a href="/admin/coupons/all">
                <i class="fa fa-envelope"></i>
                All</a>
        </li>

    </ul>
</li>
<li>
    <a href="javascript:;"><i class="fa fa-user"></i>
        <span class="title">Admin</span>
        <span class="arrow "></span></a>
    <ul class="sub-menu">
        <li>
            <a href="/admin/retailers/irc">
                <i class="fa fa-barcode"></i>
                IRC Retailers</a>
        </li>
        <li>
            <a href="/admin/retailers/mir">
                <i class="fa fa-envelope"></i>
                MIR Retailers</a>
        </li>
        <li>
            <a href="/admin/suppliers">
                <i class="fa fa-tag"></i>
                Edit Suppliers</a>
        </li>
        <li>
            <a href="/admin/brands">
                <i class="fa fa-tags"></i>
                Edit Brands</a>
        </li>
        <li>
            <a href="/admin/clients">
                <i class="fa fa-users"></i>
                Edit Clients</a>
        </li>
        <li>
            <a href="/admin/admins">
                <i class="fa fa-users"></i>
                Edit Administrators</a>
        </li>
        <li>
            <a href="/admin/clearinghouses">
                <i class="fa fa-building"></i>
                <span class="title">Edit Clearinghouses</span>
            </a>
        </li>
    </ul>
</li>
<li>
    <a href="/admin/settings">
        <i class="fa fa-cog"></i>
        <span class="title">Settings</span>
        <span class="arrow "></span>
    </a>
</li>
<li>
    <a href="javascript:;"><i class="fa fa-file-text"></i>
        <span class="title">Reports</span>
        <span class="arrow "></span></a>
    <ul class="sub-menu">
        <li>
            <a href="/admin/entries/all">
                <i class="fa fa-barcode"></i>
                Entries Reports</a>
        </li>
        <li>
            <a href="/admin/coupons/all">
                <i class="fa fa-envelope"></i>
                Programs Reports</a>
        </li>

    </ul>
</li>
<li>
    <a href="javascript:;"><i class="fa fa-pencil-square-o"></i>
        <span class="title"> Edit Defaults</span>
        <span class="arrow "></span></a>
    <ul class="sub-menu">
        <li>
            <a href="/admin/coupons/default-text">
                <i class="fa fa-comments-o"></i>
                Default Texts</a>
        </li>
        <li>
            <a href="/admin/coupons/default-faq">
                <i class="fa fa-question-circle"></i>
                Default Faqs</a>
        </li>
    </ul>
</li>
</ul>
<!-- END SIDEBAR MENU -->
</div>
</div> --}}