<nav class="sidebar sidebar-offcanvas" id="sidebar">
	<ul class="nav">
		
		<li class="nav-item">
			<a class="nav-link" href="/admin/dashboard">
              <i class="menu-icon  icon-home"></i>
              <span class="menu-title"> @lang('dingsu.dashboard')</span>
            </a>
		
		</li>
		
		
		
		<li class="nav-item">
			<a class="nav-link" data-toggle="collapse" href="#uigame" aria-expanded="false" aria-controls="uigame">
              <i class="menu-icon icon-game-controller"></i>
              <span class="menu-title"> @lang('dingsu.game')  @lang('dingsu.list')</span>
              <i class="menu-arrow"></i>
            </a>
		
			<div class="collapse" id="uigame">
				<ul class="nav flex-column sub-menu">
					<li class="nav-item">
						<a class="nav-link" href="/game/list">@lang('dingsu.game')  @lang('dingsu.list')</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="/game/setting">@lang('dingsu.game')  @lang('dingsu.settings')</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="/game/category">@lang('dingsu.game')  @lang('dingsu.category')</a>
					</li>
				</ul>
			</div>
		</li>
		
		<li class="nav-item">
			<a class="nav-link" data-toggle="collapse" href="#uimember" aria-expanded="false" aria-controls="uimember">
              <i class="menu-icon icon-people"></i>
              <span class="menu-title">@lang('dingsu.member')  @lang('dingsu.list')</span>
              <i class="menu-arrow"></i>
            </a>
		
			<div class="collapse" id="uimember">
				<ul class="nav flex-column sub-menu">
					<li class="nav-item">
						<a class="nav-link" href="/member/list">@lang('dingsu.member')  @lang('dingsu.list')</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="/member/topup"> @lang('dingsu.topup') @lang('dingsu.member')</a>
					</li>
				</ul>
			</div>
		</li>
		
		<li class="nav-item">
			<a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
              <i class="menu-icon icon-user"></i>
              <span class="menu-title">@lang('dingsu.users')  @lang('dingsu.list')</span>
              <i class="menu-arrow"></i>
            </a>
		
			<div class="collapse" id="ui-basic">
				<ul class="nav flex-column sub-menu">
					<li class="nav-item">
						<a class="nav-link" href="/admin/users">@lang('dingsu.users')  @lang('dingsu.list')</a>
					</li>
					
				</ul>
			</div>
		</li>
		
		
		<li class="nav-item">
			<a class="nav-link" data-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">
              <i class="menu-icon icon-tag text-success"></i>
              <span class="menu-title">@lang('dingsu.voucher')</span>
              <i class="menu-arrow"></i>
            </a>
		
			<div class="collapse" id="auth">
				<ul class="nav flex-column sub-menu">
					<li class="nav-item">
						<a class="nav-link" href="/voucher/list"> @lang('dingsu.voucher') @lang('dingsu.list') </a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="/voucher/unreleased"> @lang('dingsu.unreleased') @lang('dingsu.voucher')  </a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="/voucher/import"> @lang('dingsu.import_voucher')  </a>
					</li>
				</ul>
			</div>
		</li>
		
		<li class="nav-item">
			<a class="nav-link" href="/settings">
              <i class="menu-icon icon-settings text-danger"></i>
              <span class="menu-title"> @lang('dingsu.settings')</span>
            </a>
		
		</li>
		
	</ul>
</nav>