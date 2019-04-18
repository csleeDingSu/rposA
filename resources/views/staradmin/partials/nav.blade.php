

<nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-top justify-content-center">
        <a class="navbar-brand brand-logo" href="#">
          <img src="{{ asset('staradmin/images/logogo.gif') }}" alt="logo" />
        </a>
        <a class="navbar-brand brand-logo-mini" href="#">
          <img src="{{ asset('staradmin/images/logo-mini.svg') }}" alt="logo" />
        </a>
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-center">
		  
		  <ul class="navbar-nav">
            <li class="nav-item font-weight-semibold d-none d-lg-block">
				@lang('dingsu.real_time_update') :
				<span id="socketconnection">@lang('dingsu.waiting') ..</span></li>
           
          </ul>
       <!-- <ul class="navbar-nav navbar-nav-left header-links d-none d-md-flex">
          <li class="nav-item">
            <a href="#" class="nav-link">Schedule
              <span class="badge badge-primary ml-1">New</span>
            </a>
          </li>
          <li class="nav-item active">
            <a href="#" class="nav-link">
              <i class="mdi mdi-elevation-rise"></i>Reports</a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="mdi mdi-bookmark-plus-outline"></i>Score</a>
          </li>
        </ul> -->
        <ul class="navbar-nav navbar-nav-right">
          
			
          <li class="nav-item dropdown">
			  <!--
            <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-toggle="dropdown">
              <i class="mdi mdi-bell"></i>
              <span class="count">4</span>
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
              <a class="dropdown-item">
                <p class="mb-0 font-weight-normal float-left">You have 4 new notifications
                </p>
                <span class="badge badge-pill badge-warning float-right">View all</span>
              </a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item preview-item">
                <div class="preview-thumbnail">
                  <div class="preview-icon bg-success">
                    <i class="mdi mdi-alert-circle-outline mx-0"></i>
                  </div>
                </div>
                <div class="preview-item-content">
                  <h6 class="preview-subject font-weight-medium text-dark">Application Error</h6>
                  <p class="font-weight-light small-text">
                    Just now
                  </p>
                </div>
              </a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item preview-item">
                <div class="preview-thumbnail">
                  <div class="preview-icon bg-warning">
                    <i class="mdi mdi-comment-text-outline mx-0"></i>
                  </div>
                </div>
                <div class="preview-item-content">
                  <h6 class="preview-subject font-weight-medium text-dark">Settings</h6>
                  <p class="font-weight-light small-text">
                    Private message
                  </p>
                </div>
              </a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item preview-item">
                <div class="preview-thumbnail">
                  <div class="preview-icon bg-info">
                    <i class="mdi mdi-email-outline mx-0"></i>
                  </div>
                </div>
                <div class="preview-item-content">
                  <h6 class="preview-subject font-weight-medium text-dark">New user registration</h6>
                  <p class="font-weight-light small-text">
                    2 days ago
                  </p>
                </div>
              </a>
            </div> -->

          </li>

          <li class="nav-item dropdown d-none d-xl-inline-block">
            <a class="nav-link dropdown-toggle" id="UserDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
              <span class="profile-text">{{{ isset(Auth::user()->username) ? Auth::user()->username : 'Guest'}}}</span>
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
              
              <a class="dropdown-item mt-2">
				  <a class="dropdown-item" href="/user/profile">@lang('dingsu.myprofile')</a>
              </a>
              
             
				<a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">@lang('dingsu.signout')</a>
				
				<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">{{ csrf_field() }}</form>
				
				
            </div>
          </li>

          <li class="nav-item">
            
              @if (Lang::locale() == 'ci')
                <a class="nav-link" href="/locale/en">English</a>
              @else
                <a class="nav-link" href="/locale/ci">中文</a>
              @endif
            
          </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
          <span class="icon-menu"></span>
        </button>
      </div>
    </nav>