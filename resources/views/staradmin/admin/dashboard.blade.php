
<div class="page-header">
	@lang('dingsu.updated_at') : <div class="updated">{{$result->updated_at}}</div>&nbsp;&nbsp;&nbsp;&nbsp;		
	@lang('dingsu.next_update') : <div class="nextupdate">{{$result->next_update}}</div>
	
 </div>

<h3>@lang('dingsu.pending_items')</h3>
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
									<h3 class="mb-0 font-weight-medium">
										<a href="/member/list?wechat=12" class="text-decoration pending_wechat">{{$result->pending_wechat}}</a>
										</h3>
								
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="card-col col-xl-2 col-lg-2 col-md-2 col-6">
					<div class="card-body">
						<div class="d-flex align-items-center justify-content-center flex-column flex-sm-row">
							<div class="wrapper text-center text-sm-left">
								<p class="card-text mb-0">@lang('dingsu.redeem')</p>
								<div class="fluid-container">
									<h3 class="mb-0 font-weight-medium">
										
										<a href="/product/pending-redeem" class="pending_redeem_verification">
										{{$result->pending_redeem_verification}}</a></h3>
								
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="card-col col-xl-2 col-lg-2 col-md-2 col-6">
					<div class="card-body">
						<div class="d-flex align-items-center justify-content-center flex-column flex-sm-row">
							<div class="wrapper text-center text-sm-left">
								<p class="card-text mb-0">@lang('dingsu.basic') @lang('dingsu.package')</p>
								<div class="fluid-container">
									<h3 class="mb-0 font-weight-medium">
										<a href="/basicpackage/redeem-list" class="pending_basic_package_verification">
										
											{{$result->pending_basic_package_verification}} </a></h3>

								
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="card-col col-xl-2 col-lg-2 col-md-2 col-6">
					<div class="card-body">
						<div class="d-flex align-items-center justify-content-center flex-column flex-sm-row">
							<div class="wrapper text-center text-sm-left">
								<p class="card-text mb-0">@lang('dingsu.buy') @lang('dingsu.product')</p>
								<div class="fluid-container">
									<h3 class="mb-0 font-weight-medium">
										<a href="/buyproduct/redeem-list" class="pending_buy_product">
										
											{{$result->pending_buy_product}} </a></h3>

								
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
									<h3 class="mb-0 font-weight-medium">
										
										<a href="/voucher/unreleased" class="unreleased_voucher_count">
										{{$result->unreleased_voucher_count}}</a></h3>
								
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<h3>@lang('dingsu.current_items')</h3>
<div class="row">
	<div class="col-lg-6 grid-margin stretch-card">
                <div class="card">
                  <div class="p-4 border-bottom bg-light">
                    <h4 class="card-title mb-0">@lang('dingsu.monthly_new_registration')</h4>
                  </div>
                  <div class="card-body"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                    <div class="d-flex justify-content-between align-items-center pb-4">
                      
                      <div id="stacked-bar-traffic-legend"><div class="chartjs-legend"><ul><li><span style="background-color:#5D62B4"></span>@lang('dingsu.members')</li><li><span style="background-color:#54C3BE"></span>@lang('dingsu.members')</li></ul></div></div>
                    </div>
                   
                    <canvas id="registerstackedbarChart" style="height: 279px; display: block; width: 559px;" width="559" height="279" class="chartjs-render-monitor"></canvas>
                  </div>
                </div>
              </div>
	
	<div class="col-md-3 grid-margin stretch-card">
		<div class="card">
			<div class="card-body">
				<h2 class="card-title text-primary ">@lang('dingsu.current_items')</h2>
				<div class="wrapper d-flex justify-content-between">
					<div class="side-left">
						<p class="card-text mb-0">@lang('dingsu.today_game_player')</p>
					</div>
					<div class="side-right">
						<small class="display-4 mb-4 font-weight-light basicbettingcount">0</small>
					</div>
				</div>

				<div class="wrapper d-flex justify-content-between">
					<div class="side-left">
						<p class="card-text mb-0">@lang('dingsu.today_vip_game_player')</p>
					</div>
					<div class="side-right">
						<small class="display-4 mb-4 font-weight-light vipbettingcount">0 </small>
					</div>
				</div>

			</div>
		</div>

	</div>


	<div class="col-md-3 grid-margin stretch-card">
		<div class="card">
			<div class="card-body">
				<h2 class="card-title text-primary ">@lang('dingsu.today') @lang('dingsu.users')</h2>
				<div class="wrapper d-flex justify-content-between">
					<div class="side-left">
						<p class="card-text mb-0">@lang('dingsu.today_user_registration')</p>
					</div>
					<div class="side-right">
						<small class="display-4 mb-4 font-weight-light today_user_registration">{{$result->today_user_registration}}</small>
					</div>
				</div>

				<div class="wrapper d-flex justify-content-between">
					<div class="side-left">
						<p class="card-text mb-0">@lang('dingsu.today_game_player')</p>
					</div>
					<div class="side-right">
						<small class="display-4 mb-4 font-weight-light today_game_player">{{$result->today_game_player}}</small>
					</div>
				</div>

				<div class="wrapper d-flex justify-content-between">
					<div class="side-left">
						<p class="card-text mb-0">@lang('dingsu.today_vip_game_player')</p>
					</div>
					<div class="side-right">
						<small class="display-4 mb-4 font-weight-light today_vip_game_player">{{$result->today_vip_game_player}} </small>
					</div>
				</div>

			</div>
			<div class="card-body">
				<h2 class="card-title text-primary ">@lang('dingsu.today') @lang('dingsu.redeemtion')</h2>
				<div class="wrapper d-flex justify-content-between">
					<div class="side-left">
						<p class="card-text mb-0">@lang('dingsu.today_product_redeem')</p>
					</div>
					<div class="side-right">
						<small class="display-4 mb-4 font-weight-light today_product_redeem">{{$result->today_product_redeem}} </small>
					</div>
				</div>

				<div class="wrapper d-flex justify-content-between">
					<div class="side-left">
						<p class="card-text mb-0">@lang('dingsu.today_vippackage_redeem')</p>
					</div>
					<div class="side-right">
						<small class="display-4 mb-4 font-weight-light today_package_redeem">{{$result->today_package_redeem}}</small>
					</div>
				</div>
				
				<div class="wrapper d-flex justify-content-between">
					<div class="side-left">
						<p class="card-text mb-0">@lang('dingsu.today_basicpackage_redeem')</p>
					</div>
					<div class="side-right">
						<small class="display-4 mb-4 font-weight-light today_package_redeem">{{$result->today_basic_redeem}}</small>
					</div>
				</div>

			</div>
		</div>

	</div>
	
	<!--
	<div data-disabled="true" class="col-md-4 grid-margin stretch-card gameinfo">
		<div class="card">



			<div class="card-body">
				<h2 class="card-title text-primary ">@lang('dingsu.game') @lang('dingsu.info')</h2>
				<div class="wrapper d-flex justify-content-between">
					<div class="side-left">
						<p class="card-text mb-0">@lang('dingsu.draw_id')</p>
					</div>
					<div class="side-right">
						<small class="display-4 mb-4 font-weight-light c_draw_id">&nbsp; </small>
					</div>
				</div>

				<div class="wrapper d-flex justify-content-between">
					<div class="side-left">
						<p class="card-text mb-0">@lang('dingsu.result')</p>
					</div>
					<div class="side-right">
						<small class="display-4 mb-4 font-weight-light c_game_result">&nbsp;</small>
					</div>
				</div>

				<div class="wrapper d-flex justify-content-between">
					<div class="side-left">
						<p class="card-text mb-0">@lang('dingsu.total_win')</p>
					</div>
					<div class="side-right">
						<small class="display-4 mb-4 font-weight-light c_win">&nbsp; </small>
					</div>
				</div>

				<div class="wrapper d-flex justify-content-between">
					<div class="side-left">
						<p class="card-text mb-0">@lang('dingsu.total_lose')</p>
					</div>
					<div class="side-right">
						<small class="display-4 mb-4 font-weight-light c_lose">&nbsp; </small>
					</div>
				</div>

				<div class="wrapper d-flex justify-content-between">
					<div class="side-left">
						<p class="card-text mb-0">@lang('dingsu.played_user')</p>
					</div>
					<div class="side-right">
						<small class="display-4 mb-4 font-weight-light c_played_users">&nbsp; </small>
					</div>
				</div>






				<div class="d-flex align-items-center justify-content-between text-muted border-top py-3 mt-3">
					<p class="mb-0"></p>
					<div class="wrapper d-flex align-items-center">&nbsp;
						<i class=" icon-refresh hideajaxgame" onClick="return updategame('1');"> </i>
					</div>
				</div>



			</div>
		</div>

	</div>
-->


</div>






<h3>@lang('dingsu.today_items')</h3>
<div class="row">
	<div class="col-md-4 grid-margin stretch-card">
		<div class="card">
			<div class="card-body">
				<div class="wrapper d-flex justify-content-between">
					<div class="side-left">
						<p class="card-text mb-0">@lang('dingsu.total_of_users')</p>
					</div>
					<div class="side-right">
						<small class="display-4 mb-4 font-weight-light total_active_user">{{$result->total_active_user}}</small>
					</div>
				</div>

				<div class="wrapper d-flex justify-content-between">
					<div class="side-left">
						<p class="card-text mb-0">@lang('dingsu.total_inactive_users')</p>
					</div>
					<div class="side-right">
						<small class="display-4 mb-4 font-weight-light total_inactive_user">{{$result->total_inactive_user}}</small>
					</div>
				</div>



			</div>
		</div>

	</div>


	<div class="col-md-4 grid-margin stretch-card">
		<div class="card">

			<div class="card-body">
				<h2 class="card-title text-primary ">@lang('dingsu.total_wabao_coin')</h2>
				<div class="wrapper d-flex justify-content-between">
					<div class="side-left">
						<p class="card-text mb-0">@lang('dingsu.win_from_basic')</p>
					</div>
					<div class="side-right">
						<small class="display-4 mb-4 font-weight-light win_from_basic">{{$result->total_game_bet - $result->total_game_lose }} </small>
					</div>
				</div>

				<div class="wrapper d-flex justify-content-between">
					<div class="side-left">
						<p class="card-text mb-0">@lang('dingsu.win_from_vip')</p>
					</div>
					<div class="side-right">
						<small class="display-4 mb-4 font-weight-light win_from_vip">{{$result->total_vip_game_bet - $result->total_vip_game_lose }}</small>
					</div>
				</div>



			</div>
		</div>

	</div>
	<div class="col-md-4 grid-margin stretch-card">
		<div class="card">
			<div class="card-body">
				<h2 class="card-title text-primary ">@lang('dingsu.total_wabao_bet')</h2>
				<div class="wrapper d-flex justify-content-between">
					<div class="side-left">
						<p class="card-text mb-0">@lang('dingsu.total_game_bet')</p>
					</div>
					<div class="side-right">
						<small class="display-4 mb-4 font-weight-light total_game_bet">{{$result->total_game_bet}} </small>
					</div>
				</div>

				<div class="wrapper d-flex justify-content-between">
					<div class="side-left">
						<p class="card-text mb-0">@lang('dingsu.total_game_lose')</p>
					</div>
					<div class="side-right">
						<small class="display-4 mb-4 font-weight-light total_game_lose">{{$result->total_game_lose}}</small>
					</div>
				</div>

			</div>
		</div>

	</div>



</div>




	<style>
	.loader {
	  
    opacity: 0.5;
    height: 100%;
}
	</style>
	
<script src="{{ asset('staradmin/js/chart.min.js') }}"></script>
<script src="{{ asset('staradmin/js/chart.js') }}"></script>

<script language="javascript">
	
	var reguser = new Array();
	var labels  = new Array();
		
	var member_label  = '@lang("dingsu.member")';
	
	var register_date = '@lang("dingsu.register_date")';
	var obj =<?php echo json_encode($chart_user_reg );?>;
	
	var chart_vert_count = "{{$chart_vert_count}}";
	
	if (chart_vert_count<=1)
	{
		chart_vert_count = 10;
	}
	
	
	obj.forEach(function(data){
		//console.log(data);		
		reguser.push(data.total_reg);
		labels.push(data.created_at);
		
	});
	
	
	@section('socket')
    @parent
	
	/*
     socket.on("dashboard-gameinfo" + ":App\\Events\\EventDynamicChannel", function(result) {
				var record = result.data;
				console.log('gameinfo:'+record.draw_id);
				if (record != null)
					{
						$('.c_win').html(record.win);
						$('.c_lose').html(record.lose);								
						$('.c_game_result').html(record.game_result);
						$('.c_draw_id').html(record.draw_id);
						$('.c_played_users').html(record.played_users);
					}
			 });
		*/	
	socket.on("dashboard-basicplayer" + ":App\\Events\\EventDashboardChannel", function(result) {
		var r = result.data;
		if (r.type == 'reset')
		{
			$('.basicbettingcount').html("0");
		}
		else if (r.type == 'remove')
		{
			$('.basicbettingcount').html(function(i, val) { return +val-1 });
		}
		else
		{
			$('.basicbettingcount').html(r.count);
		}
	 });
	
	socket.on("master-reset" + ":App\\Events\\EventDashboardChannel", function(result) {
		var r = result.data;
		if (r.type == 'reset')
		{
			$('.basicbettingcount').html("0");
			$('.vipbettingcount').html("0");
		}
	});
		
	
	socket.on("dashboard-vipplayer" + ":App\\Events\\EventDashboardChannel", function(result) {
		var r = result.data;
		if (r.type == 'reset')
		{
			$('.vipbettingcount').html("0");
		}
		else if (r.type == 'remove')
		{
			$('.vipbettingcount').html(function(i, val) { return +val-1 });
		}
		else
		{
			$('.vipbettingcount').html(r.count);
		}
	 });
	
	var countdown;
	
	socket.on("dashboard-info" + ":App\\Events\\EventDashboardChannel", function(result) {
		var data = result.data;
		console.log(data);
		$('.pending_wechat').html(data.pending_wechat);
		$('.pending_redeem_verification').html(data.pending_redeem_verification);
		$('.pending_basic_package_verification').html(data.pending_basic_package_verification);
		$('.pending_buy_product').html(data.pending_buy_product);
		$('.unreleased_voucher_count').html(data.unreleased_voucher_count);
		$('.today_user_registration').html(data.today_user_registration);
		$('.today_product_redeem').html(data.today_product_redeem);
		$('.today_package_redeem').html(data.today_package_redeem);
		$('.total_active_user').html(data.total_active_user);
		$('.total_inactive_user').html(data.total_inactive_user);	
		$('.total_game_bet').html(data.total_game_bet);
		$('.total_game_lose').html(data.total_game_lose);
		
		var win_from_basic = data.total_game_bet - data.total_game_lose;
		var win_from_vip   = data.total_vip_game_bet - data.total_vip_game_lose;
		$('.win_from_basic').html(win_from_basic);
		$('.win_from_vip').html(win_from_vip);
		
		$('.nextupdate').removeClass('text-info').addClass('font-weight-bold');
		$('.updated').addClass('text-success font-weight-bold'); 
				
		if (countdown)
			{
				clearInterval(countdown);
				
			}
		
			countdown = setInterval(function() {
				$('.updated').html(moment(data.updated_at).fromNow());
				$('.nextupdate').html(moment(data.next_update).fromNow());
				
				tim = moment(data.next_update).fromNow();
				
				if (tim == 'in a minute')
				{
					$('.nextupdate').addClass('text-info');
				}
				
				if (moment(data.updated_at).fromNow() != 'a few seconds ago')
				{
					$('.updated').removeClass('text-success');
				}

			}, 1000);
			
		
		
		
		
	 });

	
	
	$('.updated').html(moment("{{$result->updated_at}}").fromNow());
	$('.nextupdate').html(moment("{{$result->next_update}}").fromNow());
	
	
	@endsection
	
	function ajax_call() {
		
		$( ".gameinfo" ).addClass( "loader" );
		
		$(".hideajaxgame").hide();
		$.ajax( {
				url: "{{route('get.gameinfo')}}",
				type: 'get',
				dataType: "json",
				data: {
					_method: 'get',
					_token: "{{ csrf_token() }}",
				},
				success: function ( result ) {
					$( ".gameinfo" ).removeClass( "loader" );
					$(".hideajaxgame").show();
					if ( result.success == true ) {
						var data = result.record;						
						if (data != null)
							{
								console.log(data);
								$('.c_win').html(data.win);
								$('.c_lose').html(data.lose);								
								$('.c_game_result').html(data.game_result);
								$('.c_draw_id').html(data.draw_id);
								$('.c_played_users').html(data.played_users);
							}						
					} else {						
						//alert('Error');
					}
				},
				error: function ( xhr, ajaxOptions, thrownError ) {
					//alert('Error');
				}
			} );
};

 


	
	function updategame(mcall)
	{
		if (mcall)
		{
		//	ajax_call();
		}
		/*else{
			ajax_call();
			var interval = 60 * 1000  ;
			var myTimer = setInterval(ajax_call, interval);
			clearInterval(myTimer);
			myTimer = setInterval(ajax_call, interval);
		}
		*/
		
	}
	
	updategame(1);
	
	</script>	