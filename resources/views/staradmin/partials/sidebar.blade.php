<nav class="sidebar sidebar-offcanvas" id="sidebar">
	<ul class="nav">
		
		<li class="nav-item">
			<a class="nav-link" href="/admin/dashboard">
              <i class="menu-icon  icon-home  text-primary"></i>
              <span class="menu-title"> @lang('dingsu.dashboard')</span>
            </a>		
		</li>
				
		<li class="nav-item">
			<a class="nav-link" data-toggle="collapse" href="#uigame" aria-expanded="false" aria-controls="uigame">
              <i class="menu-icon icon-game-controller  text-info"></i>
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
              <i class="menu-icon icon-people  text-warning"></i>
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
					
					<li class="nav-item">
						<a class="nav-link" href="/member/pending-verification">@lang('dingsu.pending_wechat_verification')</a>
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
			<a class="nav-link" data-toggle="collapse" href="#voucher" aria-expanded="false" aria-controls="voucher">
              <i class="menu-icon icon-tag text-primary"></i>
              <span class="menu-title">@lang('dingsu.voucher')</span>
              <i class="menu-arrow"></i>
            </a>
		
			<div class="collapse" id="voucher">
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
			<a class="nav-link" data-toggle="collapse" href="#redeem" aria-expanded="false" aria-controls="redeem">
              <i class="menu-icon icon-present text-success"></i>
              <span class="menu-title">@lang('dingsu.redeem')</span>
              <i class="menu-arrow"></i>
            </a>
		
			<div class="collapse" id="redeem">
				<ul class="nav flex-column sub-menu">
					<li class="nav-item">
						<a class="nav-link" href="/product/list"> @lang('dingsu.product') @lang('dingsu.list') </a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="/product/softpins"> @lang('dingsu.softpins') </a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="/product/pending-redeem">@lang('dingsu.pending') @lang('dingsu.redeem')  </a>
					</li>
				</ul>
			</div>
		</li>
		
		
		<li class="nav-item">
			<a class="nav-link" href="/admin/settings">
              <i class="menu-icon icon-settings text-danger"></i>
              <span class="menu-title"> @lang('dingsu.settings')</span>
            </a>
		
		</li>		
	</ul>
</nav>