<h3>Pending Items</h3>
<div class="row">
	<div class="col-12 grid-margin">
		<div class="card card-statistics">
			<div class="row">
				<div class="card-col col-xl-3 col-lg-3 col-md-3 col-6">
					<div class="card-body">
						<div class="d-flex align-items-center justify-content-center flex-column flex-sm-row">
							<div class="wrapper text-center text-sm-left">
								<p class="card-text mb-0">@lang('dingsu.pending_wechat_verification')</p>
								<div class="fluid-container">
									<h3 class="mb-0 font-weight-medium">{{$result->pending_wechat}}</h3>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="card-col col-xl-3 col-lg-3 col-md-3 col-6">
					<div class="card-body">
						<div class="d-flex align-items-center justify-content-center flex-column flex-sm-row">
							<div class="wrapper text-center text-sm-left">
								<p class="card-text mb-0">@lang('dingsu.pending') @lang('dingsu.redeem')</p>
								<div class="fluid-container">
									<h3 class="mb-0 font-weight-medium">{{$result->pending_redeem_verification}}</h3>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="card-col col-xl-3 col-lg-3 col-md-3 col-6">
					<div class="card-body">
						<div class="d-flex align-items-center justify-content-center flex-column flex-sm-row">
							<div class="wrapper text-center text-sm-left">
								<p class="card-text mb-0">@lang('dingsu.vip') @lang('dingsu.pending') @lang('dingsu.redeem')</p>
								<div class="fluid-container">
									<h3 class="mb-0 font-weight-medium">{{$result->pending_vip_verification}}</h3>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="card-col col-xl-3 col-lg-3 col-md-3 col-6">
					<div class="card-body">
						<div class="d-flex align-items-center justify-content-center flex-column flex-sm-row">
							<div class="wrapper text-center text-sm-left">
								<p class="card-text mb-0">@lang('dingsu.unreleased') @lang('dingsu.voucher')</p>
								<div class="fluid-container">
									<h3 class="mb-0 font-weight-medium">{{$result->unreleased_voucher_count}}</h3>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>



<h3>Current Items</h3>
<div class="row">
	<div class="col-md-4 grid-margin stretch-card">
		<div class="card">
			<div class="card-body">
				<h2 class="card-title text-primary ">@lang('dingsu.today') @lang('dingsu.users')</h2>
				<div class="wrapper d-flex justify-content-between">
					<div class="side-left">
						<p class="display-5 mb-2">@lang('dingsu.today_user_registration')</p>
					</div>
					<div class="side-right">
						<small class="display-4 mb-4 font-weight-light">{{$result->today_user_registration}}</small>
					</div>
				</div>

				<div class="wrapper d-flex justify-content-between">
					<div class="side-left">
						<p class="display-5 mb-2">@lang('dingsu.today_game_player')</p>
					</div>
					<div class="side-right">
						<small class="display-4 mb-4 font-weight-light">{{$result->today_game_player}}</small>
					</div>
				</div>

				<div class="wrapper d-flex justify-content-between">
					<div class="side-left">
						<p class="display-5 mb-2">@lang('dingsu.today_vip_game_player')</p>
					</div>
					<div class="side-right">
						<small class="display-4 mb-4 font-weight-light">{{$result->today_vip_game_player}} </small>
					</div>
				</div>

			</div>
		</div>

	</div>


	<div class="col-md-4 grid-margin stretch-card">
		<div class="card">
			<div class="card-body">
				<h2 class="card-title text-primary ">@lang('dingsu.today') @lang('dingsu.redeemtion')</h2>
				<div class="wrapper d-flex justify-content-between">
					<div class="side-left">
						<p class="display-5 mb-2">@lang('dingsu.today_product_redeem')</p>
					</div>
					<div class="side-right">
						<small class="display-4 mb-4 font-weight-light">{{$result->today_product_redeem}} </small>
					</div>
				</div>

				<div class="wrapper d-flex justify-content-between">
					<div class="side-left">
						<p class="display-5 mb-2">@lang('dingsu.today_package_redeem')</p>
					</div>
					<div class="side-right">
						<small class="display-4 mb-4 font-weight-light">{{$result->today_package_redeem}}</small>
					</div>
				</div>

				<div class="wrapper d-flex justify-content-between">
					<div class="side-left">
						<p class="display-5 mb-2">@lang('dingsu.today_vip_game_player')</p>
					</div>
					<div class="side-right">
						<small class="display-4 mb-4 font-weight-light">{{$result->today_vip_game_player}} </small>
					</div>
				</div>

			</div>
		</div>

	</div>
	<div class="col-md-4 grid-margin stretch-card">
		<div class="card">
			<div class="card-body">
				<h2 class="card-title text-primary ">@lang('dingsu.game') @lang('dingsu.info')</h2>
				<div class="wrapper d-flex justify-content-between">
					<div class="side-left">
						<p class="display-5 mb-2">@lang('dingsu.draw_id')</p>
					</div>
					<div class="side-right">
						<small class="display-4 mb-4 font-weight-light">{{$game->draw_id}} </small>
					</div>
				</div>

				<div class="wrapper d-flex justify-content-between">
					<div class="side-left">
						<p class="display-5 mb-2">@lang('dingsu.result')</p>
					</div>
					<div class="side-right">
						<small class="display-4 mb-4 font-weight-light">{{$game->game_result}}</small>
					</div>
				</div>

				<div class="wrapper d-flex justify-content-between">
					<div class="side-left">
						<p class="display-5 mb-2">@lang('dingsu.total_win')</p>
					</div>
					<div class="side-right">
						<small class="display-4 mb-4 font-weight-light">{{$game->win}} </small>
					</div>
				</div>

				<div class="wrapper d-flex justify-content-between">
					<div class="side-left">
						<p class="display-5 mb-2">@lang('dingsu.total_lose')</p>
					</div>
					<div class="side-right">
						<small class="display-4 mb-4 font-weight-light">{{$game->lose}} </small>
					</div>
				</div>

			</div>
		</div>

	</div>



</div>







<h3>Today Items</h3>
<div class="row">
	<div class="col-md-4 grid-margin stretch-card">
		<div class="card">
			<div class="card-body">
				<div class="wrapper d-flex justify-content-between">
					<div class="side-left">
						<p class="display-5 mb-2">@lang('dingsu.total') @lang('dingsu.users')</p>
					</div>
					<div class="side-right">
						<small class="display-4 mb-4 font-weight-light">{{$result->total_active_user}}</small>
					</div>
				</div>

				<div class="wrapper d-flex justify-content-between">
					<div class="side-left">
						<p class="display-5 mb-2">@lang('dingsu.total') @lang('dingsu.inactive') @lang('dingsu.users')</p>
					</div>
					<div class="side-right">
						<small class="display-4 mb-4 font-weight-light">{{$result->total_inactive_user}}</small>
					</div>
				</div>



			</div>
		</div>

	</div>


	<div class="col-md-4 grid-margin stretch-card">
		<div class="card">
			<div class="card-body">
				<h2 class="card-title text-primary ">@lang('dingsu.total') @lang('dingsu.wabao') @lang('dingsu.coin')</h2>
				<div class="wrapper d-flex justify-content-between">
					<div class="side-left">
						<p class="display-5 mb-2">@lang('dingsu.win_from_basic')</p>
					</div>
					<div class="side-right">
						<small class="display-4 mb-4 font-weight-light">{{$result->total_game_bet - $result->total_game_lose }} </small>
					</div>
				</div>

				<div class="wrapper d-flex justify-content-between">
					<div class="side-left">
						<p class="display-5 mb-2">@lang('dingsu.win_from_vip')</p>
					</div>
					<div class="side-right">
						<small class="display-4 mb-4 font-weight-light">{{$result->total_vip_game_bet - $result->total_vip_game_lose }}</small>
					</div>
				</div>



			</div>
		</div>

	</div>
	<div class="col-md-4 grid-margin stretch-card">
		<div class="card">
			<div class="card-body">
				<h2 class="card-title text-primary ">@lang('dingsu.total') @lang('dingsu.wabao') @lang('dingsu.bet')</h2>
				<div class="wrapper d-flex justify-content-between">
					<div class="side-left">
						<p class="display-5 mb-2">@lang('dingsu.total_game_bet')</p>
					</div>
					<div class="side-right">
						<small class="display-4 mb-4 font-weight-light">{{$result->total_game_bet}} </small>
					</div>
				</div>

				<div class="wrapper d-flex justify-content-between">
					<div class="side-left">
						<p class="display-5 mb-2">@lang('dingsu.total_game_lose')</p>
					</div>
					<div class="side-right">
						<small class="display-4 mb-4 font-weight-light">{{$result->total_game_lose}}</small>
					</div>
				</div>

				<div class="wrapper d-flex justify-content-between">
					<div class="side-left">
						<p class="display-5 mb-2">@lang('dingsu.total_vip_game_bet')</p>
					</div>
					<div class="side-right">
						<small class="display-4 mb-4 font-weight-light">{{$result->total_vip_game_bet}} </small>
					</div>
				</div>

				<div class="wrapper d-flex justify-content-between">
					<div class="side-left">
						<p class="display-5 mb-2">@lang('dingsu.total_lose')</p>
					</div>
					<div class="side-right">
						<small class="display-4 mb-4 font-weight-light">{{$result->total_vip_game_lose}} </small>
					</div>
				</div>

			</div>
		</div>

	</div>



</div>





<div class="row">
             <div class="col-md-4 grid-margin stretch-card">
             <div class="card">
                <div class="card-body">
					<div class="wrapper d-flex justify-content-between">
                    <div class="side-left">
                      <p class="display-5 mb-2">@lang('dingsu.via') @lang('dingsu.wabao') @lang('dingsu.coin')</p>
                    </div>
                    <div class="side-right">
                      <small class="display-4 mb-4 font-weight-light">{{$result->total_active_user}}</small>
                    </div>
                  </div>
					
					<div class="wrapper d-flex justify-content-between">
                    <div class="side-left">
                      <p class="display-5 mb-2">@lang('dingsu.via') @lang('dingsu.prepaid') @lang('dingsu.card')</p>
                    </div>
                    <div class="side-right">
                      <small class="display-4 mb-4 font-weight-light">{{$result->total_inactive_user}}</small>
                    </div>
                  </div>
					
					
                  
                </div>
              </div>
				 
            </div>
	