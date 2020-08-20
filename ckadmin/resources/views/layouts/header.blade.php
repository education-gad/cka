<!-- LEFTSIDE header -->
<div class="leftside-header">
    <div class="text-center">
        <a style="color: #fff;padding-left: 30px; font-weight: bold;font-size: 22px;" href="{{ route('dashboard') }}">
            <img src="img/Quizards-RGB.png" alt="" width="100" height="50">
        </a>
    </div>
    <div id="menu-toggle" class="visible-xs toggle-left-sidebar" data-toggle-class="left-sidebar-open" data-target="html">
        <i class="fa fa-bars" aria-label="Toggle sidebar"></i>
    </div>
</div>
<!-- RIGHTSIDE header -->
<div class="rightside-header">
    <div class="header-middle"></div>
    <!--SEARCH HEADERBOX-->
    @include('common.sections.search_headerbox')
    <!--NOCITE HEADERBOX-->
    @include('common.sections.notice_headerbox')
    <!--USER HEADERBOX -->
    @include('common.sections.user_headerbox')

    <div class="header-separator"></div>
    <!--Log out -->
    <div class="header-section">
        <a href="{{ route('logout') }}"
            data-toggle="tooltip" data-placement="left" title="Logout"
            onclick="event.preventDefault();
                     document.getElementById('logout-form').submit();">
            <i class="fa fa-sign-out log-out" aria-hidden="true"></i>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            {{ csrf_field() }}
        </form>
       {{--  <a href="{{ url('login') }}" data-toggle="tooltip" data-placement="left" title="Logout"><i class="fa fa-sign-out log-out" aria-hidden="true"></i></a> --}}
    </div>
</div>