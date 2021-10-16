<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->

<head>

    @include('layouts.partials.head')
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<!-- in BODY
page-sidebar-closed
page-quick-sidebar-over-content
-->

<body class="page-header-fixed page-header-fixed-mobile page-footer-fixed1 ">
    <!-- BEGIN HEADER -->
    @include('layouts.partials.header')
    <!-- END HEADER -->
    <div class="clearfix">
    </div>
    <!-- BEGIN CONTAINER -->
    <div class="page-container">
        <!-- BEGIN SIDEBAR -->
        <!-- /////////layouts.partials.sidebar-admin//////////// -->


        <!-- END SIDEBAR -->
        <!-- BEGIN CONTENT -->
        @yield('content')
        <!-- END CONTENT -->
    </div>
    <!-- END CONTAINER -->
    <!-- BEGIN FOOTER -->
    @include('layouts.partials.footer')
    <!-- END FOOTER -->
    <!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
    @include('layouts.partials.scripts')
    <!-- BEGIN PAGE SPECIFIC SCRIPTS -->
    @yield('page_specific_scripts')
    <!-- END PAGE SPECIFIC SCRIPTS -->
    <!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->

</html>