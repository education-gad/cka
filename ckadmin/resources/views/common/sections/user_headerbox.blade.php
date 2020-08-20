 <div class="header-section" id="user-headerbox">
    <div class="user-header-wrap">
        <div class="user-photo">
            {{--  <img alt="profile photo" src="{{ asset('storage/images/avatar/avatar_user.jpg') }}" />  --}}
            <img src="https://image.flaticon.com/icons/svg/783/783429.svg" alt="profile photo" >
        </div>
        <div class="user-info">
            <span class="user-name">{{ Auth::user()->name }} </span>
        </div>
{{--         <i class="fa fa-plus icon-open" aria-hidden="true"></i>
        <i class="fa fa-minus icon-close" aria-hidden="true"></i> --}}
    </div>
    <div class="user-options dropdown-box">
        <div class="drop-content basic">
  {{--           <ul>
                <li> <a href="{{ route('template',array('pages_user-profile')) }}"><i class="fa fa-user" aria-hidden="true"></i> Profile</a></li>
                <li> <a href="{{ route('template',array('pages_lock-screen')) }}"><i class="fa fa-lock" aria-hidden="true"></i> Lock Screen</a></li>
                <li><a href="#"><i class="fa fa-cog" aria-hidden="true"></i> Configurations</a></li>
            </ul> --}}
        </div>
    </div>
</div>