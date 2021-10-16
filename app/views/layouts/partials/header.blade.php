<style type="text/css">
  /* Absolute Center Spinner */
  .clsLoader {
    position: fixed;
    z-index: 99999;
    height: 2em;
    width: 2em;
    overflow: visible;
    margin: auto;
    top: 0;
    left: 0;
    bottom: 0;
    right: 0;
    display: none;
  }

  #processedCounts {
    position: fixed;
    z-index: 999999;
    padding-top: 25px;
    margin-left: -105px;

  }

  #processedCounts label,
  #processedCounts span {
    font-size: 22px;
  }

  #processedCounts span {
    color: #FFF;
  }

  /* Transparent Overlay */
  .loading:before {
    content: '';
    display: block;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.3);
  }

  /* :not(:required) hides these rules from IE9 and below */
  .loading:not(:required) {
    /* hide "loading..." text */
    font: 0/0 a;
    color: transparent;
    text-shadow: none;
    background-color: transparent;
    border: 0;
  }

  .loading:not(:required):after {
    content: '';
    display: block;
    font-size: 10px;
    width: 1em;
    height: 1em;
    margin-top: -0.5em;
    -webkit-animation: spinner 1500ms infinite linear;
    -moz-animation: spinner 1500ms infinite linear;
    -ms-animation: spinner 1500ms infinite linear;
    -o-animation: spinner 1500ms infinite linear;
    animation: spinner 1500ms infinite linear;
    border-radius: 0.5em;
    -webkit-box-shadow: rgba(0, 0, 0, 0.75) 1.5em 0 0 0, rgba(0, 0, 0, 0.75) 1.1em 1.1em 0 0, rgba(0, 0, 0, 0.75) 0 1.5em 0 0, rgba(0, 0, 0, 0.75) -1.1em 1.1em 0 0, rgba(0, 0, 0, 0.5) -1.5em 0 0 0, rgba(0, 0, 0, 0.5) -1.1em -1.1em 0 0, rgba(0, 0, 0, 0.75) 0 -1.5em 0 0, rgba(0, 0, 0, 0.75) 1.1em -1.1em 0 0;
    box-shadow: rgba(0, 0, 0, 0.75) 1.5em 0 0 0, rgba(0, 0, 0, 0.75) 1.1em 1.1em 0 0, rgba(0, 0, 0, 0.75) 0 1.5em 0 0, rgba(0, 0, 0, 0.75) -1.1em 1.1em 0 0, rgba(0, 0, 0, 0.75) -1.5em 0 0 0, rgba(0, 0, 0, 0.75) -1.1em -1.1em 0 0, rgba(0, 0, 0, 0.75) 0 -1.5em 0 0, rgba(0, 0, 0, 0.75) 1.1em -1.1em 0 0;
  }

  /* Animation */

  @-webkit-keyframes spinner {
    0% {
      -webkit-transform: rotate(0deg);
      -moz-transform: rotate(0deg);
      -ms-transform: rotate(0deg);
      -o-transform: rotate(0deg);
      transform: rotate(0deg);
    }

    100% {
      -webkit-transform: rotate(360deg);
      -moz-transform: rotate(360deg);
      -ms-transform: rotate(360deg);
      -o-transform: rotate(360deg);
      transform: rotate(360deg);
    }
  }

  @-moz-keyframes spinner {
    0% {
      -webkit-transform: rotate(0deg);
      -moz-transform: rotate(0deg);
      -ms-transform: rotate(0deg);
      -o-transform: rotate(0deg);
      transform: rotate(0deg);
    }

    100% {
      -webkit-transform: rotate(360deg);
      -moz-transform: rotate(360deg);
      -ms-transform: rotate(360deg);
      -o-transform: rotate(360deg);
      transform: rotate(360deg);
    }
  }

  @-o-keyframes spinner {
    0% {
      -webkit-transform: rotate(0deg);
      -moz-transform: rotate(0deg);
      -ms-transform: rotate(0deg);
      -o-transform: rotate(0deg);
      transform: rotate(0deg);
    }

    100% {
      -webkit-transform: rotate(360deg);
      -moz-transform: rotate(360deg);
      -ms-transform: rotate(360deg);
      -o-transform: rotate(360deg);
      transform: rotate(360deg);
    }
  }

  @keyframes spinner {
    0% {
      -webkit-transform: rotate(0deg);
      -moz-transform: rotate(0deg);
      -ms-transform: rotate(0deg);
      -o-transform: rotate(0deg);
      transform: rotate(0deg);
    }

    100% {
      -webkit-transform: rotate(360deg);
      -moz-transform: rotate(360deg);
      -ms-transform: rotate(360deg);
      -o-transform: rotate(360deg);
      transform: rotate(360deg);
    }
  }

  @media (max-width: 900px) {
    #test {
      margin-left: 600px;
    }
  }
</style>

<div class="clsLoader">
  <div class="loading">Loading&#8230;</div>
  <div id="processedCounts" style="display: '';"><label></label><span></span></div>
</div>
<form id="frmDownloadFile" target="_blank" action="" method="POST" style="display: none;"></form>

<div class="page-header navbar navbar-fixed-top" style="justify-content:stretch">
  <div class="page-logo" style="float: left;margin-left:0">
    <a href="/">
      <img src="/assets/admin/layout/img/logo.png" alt="logo" class="logo-default" />
    </a>

    <!--Sidebar class= menu-toggler sidebar-toggler hide //////////////-->
    <div class="">
      <!-- DOC: Remove the above "hide" to enable the sidebar toggler button on header -->
    </div>
  </div>
  <!-- BEGIN HEADER INNER -->
  {{-- <div class="page-header-inner">
    <!-- BEGIN LOGO -->
    <div class="page-logo">
      <a href="/">
        <img src="/assets/admin/layout/img/logo.png" alt="logo" class="logo-default" />
      </a>

      <!--Sidebar class= menu-toggler sidebar-toggler hide //////////////-->
      <div class="">
        <!-- DOC: Remove the above "hide" to enable the sidebar toggler button on header -->
      </div>
    </div>
    <!-- END LOGO -->
    <!-- BEGIN RESPONSIVE MENU TOGGLER -->
    <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse"
      data-target=".navbar-collapse">
    </a>
    <!-- END RESPONSIVE MENU TOGGLER -->
    <!-- BEGIN TOP NAVIGATION MENU -->
    <div class="top-menu">
      <ul class="nav navbar-nav pull-right">
        <!-- BEGIN USER LOGIN DROPDOWN -->
        <li class="dropdown dropdown-user">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
            <span class="username">
              Welcome {{ Auth::user()->first_name }} </span>
  <i class="fa fa-angle-down"></i>
  </a>
  <ul class="dropdown-menu">
    <!--
                        <li>
                            <a href="extra_profile.html">
                                <i class="icon-user"></i> My Profile </a>
                        </li>
                        !-->
    <li>
      <a href="/logout">
        <i class="icon-key"></i> Log Out </a>
    </li>
  </ul>
  </li>
  <!-- END USER LOGIN DROPDOWN -->
  </ul>
</div>
<!-- END TOP NAVIGATION MENU -->
</div> --}}
<div class="top-menu" id="test" style="float: right;margin-left: 1100px;">
  <ul class="nav navbar-nav pull-right">
    <!-- BEGIN USER LOGIN DROPDOWN -->
    <li class="dropdown dropdown-user">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
        <span class="username">
          Welcome {{ Auth::user()->first_name }} </span>
        <i class="fa fa-angle-down"></i>
      </a>
      <ul class="dropdown-menu">
        <!--
                      <li>
                          <a href="extra_profile.html">
                              <i class="icon-user"></i> My Profile </a>
                      </li>
                      !-->
        <li>
          <a href="/logout">
            <i class="icon-key"></i> Log Out </a>
        </li>
      </ul>
    </li>
    <!-- END USER LOGIN DROPDOWN -->
  </ul>
</div>
<!-- END HEADER INNER -->
</div>