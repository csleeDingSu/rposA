<nav class="sidebar sidebar-offcanvas" id="sidebar">
	<ul class="nav">
		<li class="nav-item">
			<a class="nav-link" href="/admin/dashboard">
              <i class="menu-icon  icon-home  text-primary "></i>
              <span class="menu-title text-capitalize"> @lang('dingsu.dashboard')</span>
            </a>		
		</li>


		<li class="nav-item">
			<a class="nav-link" href="/game/category">
			<i class="menu-icon icon-game-controller  text-info"></i>
              <span class="menu-title text-capitalize"> @lang('dingsu.game_setting')</span>
            </a>
		</li>



		<!-- <li class="nav-item">
			<a class="nav-link" data-toggle="collapse" href="#uigame" aria-expanded="false" aria-controls="uigame">
              <i class="menu-icon icon-game-controller  text-info"></i>
              <span class="menu-title text-capitalize"> @lang('dingsu.game_setting')</span>
              <i class="menu-arrow"></i>
            </a>		

			<div class="collapse" id="uigame">
				<ul class="nav flex-column sub-menu">
					<li class="nav-item">
						<a class="nav-link" href="/game/category">@lang('dingsu.category')</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="/game/list">@lang('dingsu.games')</a>
					</li>
					
				</ul>
			</div>
		</li> -->

		<!-- <li class="nav-item">
			<a class="nav-link" data-toggle="collapse" href="#uimember" aria-expanded="false" aria-controls="uimember">
              <i class="menu-icon icon-people  text-warning"></i>
              <span class="menu-title text-capitalize">@lang('dingsu.member')  @lang('dingsu.list')</span>
              <i class="menu-arrow"></i>
            </a>		

			<div class="collapse" id="uimember">
				<ul class="nav flex-column sub-menu">
					<li class="nav-item">
						<a class="nav-link" href="/member/list">@lang('dingsu.member')  @lang('dingsu.list')</a>
					</li>
					
					<li class="nav-item">
						<a class="nav-link" href="/member/pending-verification">@lang('dingsu.pending_wechat_verification')</a>
					</li>
					
				</ul>
			</div>
		</li> -->

		<li class="nav-item">
			<a class="nav-link" href="/member/list">
			<i class="menu-icon icon-game-controller  text-info"></i>
              <span class="menu-title text-capitalize"> @lang('dingsu.member') @lang('dingsu.list')</span>
            </a>
		</li>

		<!-- <li class="nav-item">
			<a class="nav-link" data-toggle="collapse" href="#uiuser" aria-expanded="false" aria-controls="uiuser">
              <i class="menu-icon icon-user"></i>
              <span class="menu-title text-capitalize">@lang('dingsu.users')  @lang('dingsu.list')</span>
              <i class="menu-arrow"></i>
            </a>
		
			<div class="collapse" id="uiuser">
				<ul class="nav flex-column sub-menu">
					<li class="nav-item">
						<a class="nav-link" href="/user/list">@lang('dingsu.users')  @lang('dingsu.list')</a>
					</li>
				</ul>
			</div>
		</li> -->

		<li class="nav-item">
			<a class="nav-link" href="/user/list">
			<i class="menu-icon icon-game-controller  text-info"></i>
              <span class="menu-title text-capitalize"> @lang('dingsu.admin') @lang('dingsu.users')  @lang('dingsu.list')</span>
            </a>
		</li>


		<li class="nav-item">
			<a class="nav-link" data-toggle="collapse" href="#voucher" aria-expanded="false" aria-controls="voucher">
              <i class="menu-icon icon-tag text-primary"></i>
              <span class="menu-title text-capitalize">@lang('dingsu.voucher')</span>
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
					<li class="nav-item">
						<a class="nav-link" href="/voucher/setting"> @lang('dingsu.voucher')@lang('dingsu.setting')  </a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="/share-product"> @lang('dingsu.share_product') </a>
					</li>
				</ul>
			</div>
		</li>
		
		<li class="nav-item">
			<a class="nav-link" data-toggle="collapse" href="#uibuyproduct" aria-expanded="false" aria-controls="uibuyproduct">
              <i class="menu-icon  icon-layers   text-info"></i>
              <span class="menu-title"> @lang('dingsu.buyproduct')</span>
              <i class="menu-arrow"></i>
            </a>
		
			<div class="collapse" id="uibuyproduct">
				<ul class="nav flex-column sub-menu">
					<li class="nav-item">
						<a class="nav-link" href="/buyproduct/list">@lang('dingsu.buyproduct')  @lang('dingsu.list')</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="/buyproduct/redeem-list">@lang('dingsu.pending')  @lang('dingsu.list')</a>
					</li>
					
					<li class="nav-item">
						<a class="nav-link" href="/buyproduct/redeem-history">@lang('dingsu.history')</a>
					</li>
					
				</ul>
			</div>
		</li>

		<li class="nav-item">
			<a class="nav-link" data-toggle="collapse" href="#redeem" aria-expanded="false" aria-controls="redeem">
              <i class="menu-icon icon-present text-success"></i>
              <span class="menu-title text-capitalize">@lang('dingsu.softpins') @lang('dingsu.product')</span>
              <i class="menu-arrow"></i>
            </a>		

			<div class="collapse" id="redeem">
				<ul class="nav flex-column sub-menu">
					<li class="nav-item">
						<a class="nav-link" href="/product/list">@lang('dingsu.softpins') @lang('dingsu.product') @lang('dingsu.list') </a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="/product/softpins"> @lang('dingsu.softpins') </a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="/product/pending-redeem">@lang('dingsu.pending') @lang('dingsu.redeem')  </a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="/product/redeem-history">@lang('dingsu.redeem') @lang('dingsu.history')  </a>
					</li>
					<!--
					<li class="nav-item">
						<a class="nav-link" href="/product/redeem-history">@lang('dingsu.redeem') @lang('dingsu.log')  </a>
					</li>-->
				</ul>
			</div>
		</li>
		
		<li class="nav-item">
			<a class="nav-link" data-toggle="collapse" href="#uipackage" aria-expanded="false" aria-controls="uipackage">
              <i class="menu-icon  icon-layers   text-info"></i>
              <span class="menu-title"> VIP @lang('dingsu.package')</span>
              <i class="menu-arrow"></i>
            </a>
		
			<div class="collapse" id="uipackage">
				<ul class="nav flex-column sub-menu">
					<li class="nav-item">
						<a class="nav-link" href="/package/list">@lang('dingsu.package')  @lang('dingsu.list')</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="/package/redeem-list">@lang('dingsu.vip')  @lang('dingsu.list')</a>
					</li>
					
					<li class="nav-item">
						<a class="nav-link" href="/package/redeem-history">@lang('dingsu.vip')  @lang('dingsu.history')</a>
					</li>
					
				</ul>
			</div>
		</li>
		
		<li class="nav-item">
			<a class="nav-link" data-toggle="collapse" href="#uibasicpackage" aria-expanded="false" aria-controls="uibasicpackage">
              <i class="menu-icon  icon-layers   text-info"></i>
              <span class="menu-title"> @lang('dingsu.basicpackage')</span>
              <i class="menu-arrow"></i>
            </a>
		
			<div class="collapse" id="uibasicpackage">
				<ul class="nav flex-column sub-menu">
					<li class="nav-item">
						<a class="nav-link" href="/basicpackage/list">@lang('dingsu.package')  @lang('dingsu.list')</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="/basicpackage/redeem-list">@lang('dingsu.pending')  @lang('dingsu.list')</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="/basicpackage/backorder">@lang('dingsu.backorder')</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="/basicpackage/redeem-history">@lang('dingsu.history')</a>
					</li>
					
				</ul>
			</div>
		</li>

		<!-- <li class="nav-item">
			<a class="nav-link" href="/product/product-new">
              <i class="menu-icon  icon-list text-danger"></i>
              <span class="menu-title text-capitalize"> @lang('dingsu.redeem') 2 </span>
            </a>
		</li> -->
		
		<li class="nav-item">
			<a class="nav-link" href="/receipt/list">
              <i class="menu-icon  icon-note text-primary"></i>
              <span class="menu-title text-capitalize"> @lang('dingsu.receipt')</span>
            </a>
		</li>
		
		<li class="nav-item">
			<a class="nav-link" href="/admin/faq">
              <i class="menu-icon  icon-note text-primary"></i>
              <span class="menu-title text-capitalize"> @lang('dingsu.faq')</span>
            </a>
		</li>
		
		<!-- <li class="nav-item">
			<a class="nav-link" href="/admin/tips">
              <i class="menu-icon icon-speech  text-info"></i>
              <span class="menu-title text-capitalize"> @lang('dingsu.tips')</span>
            </a>	
		</li> -->
		
		<li class="nav-item">
			<a class="nav-link" data-toggle="collapse" href="#uisetting" aria-expanded="false" aria-controls="uisetting">
              <i class="menu-icon icon-settings  text-danger"></i>
              <span class="menu-title text-capitalize"> @lang('dingsu.settings')</span>
              <i class="menu-arrow"></i>
            </a>
		
			<div class="collapse" id="uisetting">
				<ul class="nav flex-column sub-menu">
					<li class="nav-item">
						<a class="nav-link" href="/admin/settings">@lang('dingsu.settings')</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="/admin/get-env-file">@lang('dingsu.env') @lang('dingsu.editor')</a>
					</li>					
					<li class="nav-item">
						<a class="nav-link" href="/admin/banner">@lang('dingsu.banner')</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="/admin/redeem-condition">@lang('dingsu.redeem') @lang('dingsu.condition')</a>
					</li>
					
					<li class="nav-item">
						<a class="nav-link" href="/admin/cron-list">@lang('dingsu.cron') @lang('dingsu.list')</a>
					</li>

					<li class="nav-item">
						<a class="nav-link" href="/setting/tabao">@lang('dingsu.tabao_cron')</a>
					</li>
				</ul>
			</div>
		</li>
		
		<li class="nav-item">
			<a class="nav-link" data-toggle="collapse" href="#uireport" aria-expanded="false" aria-controls="uireport">
              <i class="menu-icon icon-pie-chart text-warning"></i>
              <span class="menu-title text-capitalize"> @lang('dingsu.report')</span>
              <i class="menu-arrow"></i>
            </a>
		
			<div class="collapse" id="uireport">
				<ul class="nav flex-column sub-menu">
					<li class="nav-item">
						<a class="nav-link" href="/notification/list">@lang('dingsu.notification') @lang('dingsu.list')</a>
					</li>
					<!-- <li class="nav-item">
						<a class="nav-link" href="/report/redeem_life">@lang('dingsu.redeem_life')</a>
					</li> 
					<li class="nav-item">
						<a class="nav-link" href="/report/redeem_product">@lang('dingsu.redeem_product')</a>
					</li>
					-->
					<li class="nav-item">
						<a class="nav-link" href="/report/point_report">@lang('dingsu.point_report')</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="/report/played-count">@lang('dingsu.played_count')</a>
					</li>
					<!--
					<li class="nav-item">
						<a class="nav-link" href="/report/draw-details">@lang('dingsu.draw_details')</a>
					</li> -->
					<li class="nav-item">
						<a class="nav-link" href="/report/redeem-count">@lang('dingsu.redeem_product')</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="/report/played-member">@lang('dingsu.played_member')</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="/report/ledger">@lang('dingsu.buy_product')</a>
					</li>
					
					
				</ul>
			</div>
		</li>
	</ul>
</nav>