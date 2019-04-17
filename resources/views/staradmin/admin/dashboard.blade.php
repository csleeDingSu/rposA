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
										<a href="/member/list?wechat=12" class="text-decoration">{{$result->pending_wechat}}</a>
										</h3>
								
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="card-col col-xl-3 col-lg-3 col-md-3 col-6">
					<div class="card-body">
						<div class="d-flex align-items-center justify-content-center flex-column flex-sm-row">
							<div class="wrapper text-center text-sm-left">
								<p class="card-text mb-0">@lang('dingsu.redeem')</p>
								<div class="fluid-container">
									<h3 class="mb-0 font-weight-medium">
										
										<a href="/product/pending-redeem" class="">
										{{$result->pending_redeem_verification}}</a></h3>
								
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="card-col col-xl-3 col-lg-3 col-md-3 col-6">
					<div class="card-body">
						<div class="d-flex align-items-center justify-content-center flex-column flex-sm-row">
							<div class="wrapper text-center text-sm-left">
								<p class="card-text mb-0">@lang('dingsu.vip') @lang('dingsu.redeem')</p>
								<div class="fluid-container">
									<h3 class="mb-0 font-weight-medium">
										<a href="/package/redeem-list" class="">
										
											{{$result->pending_vip_verification}} </a></h3>

								
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
										
										<a href="/voucher/unreleased" class="">
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
	<div class="col-md-4 grid-margin stretch-card">
		<div class="card">
			<div class="card-body">
				<h2 class="card-title text-primary ">@lang('dingsu.current_items')</h2>
				<div class="wrapper d-flex justify-content-between">
					<div class="side-left">
						<p class="card-text mb-0">@lang('dingsu.today_game_player')</p>
					</div>
					<div class="side-right">
						<small class="display-4 mb-4 font-weight-light">{{$result->current_game_player}}</small>
					</div>
				</div>

				<div class="wrapper d-flex justify-content-between">
					<div class="side-left">
						<p class="card-text mb-0">@lang('dingsu.today_vip_game_player')</p>
					</div>
					<div class="side-right">
						<small class="display-4 mb-4 font-weight-light">{{$result->current_vip_game_player}} </small>
					</div>
				</div>

			</div>
		</div>

	</div>


	<div class="col-md-4 grid-margin stretch-card">
		<div class="card">
			<div class="card-body">
				<h2 class="card-title text-primary ">@lang('dingsu.today') @lang('dingsu.users')</h2>
				<div class="wrapper d-flex justify-content-between">
					<div class="side-left">
						<p class="card-text mb-0">@lang('dingsu.today_user_registration')</p>
					</div>
					<div class="side-right">
						<small class="display-4 mb-4 font-weight-light">{{$result->today_user_registration}}</small>
					</div>
				</div>

				<div class="wrapper d-flex justify-content-between">
					<div class="side-left">
						<p class="card-text mb-0">@lang('dingsu.today_game_player')</p>
					</div>
					<div class="side-right">
						<small class="display-4 mb-4 font-weight-light">{{$result->today_game_player}}</small>
					</div>
				</div>

				<div class="wrapper d-flex justify-content-between">
					<div class="side-left">
						<p class="card-text mb-0">@lang('dingsu.today_vip_game_player')</p>
					</div>
					<div class="side-right">
						<small class="display-4 mb-4 font-weight-light">{{$result->today_vip_game_player}} </small>
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
						<small class="display-4 mb-4 font-weight-light">{{$result->today_product_redeem}} </small>
					</div>
				</div>

				<div class="wrapper d-flex justify-content-between">
					<div class="side-left">
						<p class="card-text mb-0">@lang('dingsu.today_package_redeem')</p>
					</div>
					<div class="side-right">
						<small class="display-4 mb-4 font-weight-light">{{$result->today_package_redeem}}</small>
					</div>
				</div>

			</div>
		</div>

	</div>
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
						<small class="display-4 mb-4 font-weight-light">{{$result->total_active_user}}</small>
					</div>
				</div>

				<div class="wrapper d-flex justify-content-between">
					<div class="side-left">
						<p class="card-text mb-0">@lang('dingsu.total_inactive_users')</p>
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
				<h2 class="card-title text-primary ">@lang('dingsu.total_wabao_coin')</h2>
				<div class="wrapper d-flex justify-content-between">
					<div class="side-left">
						<p class="card-text mb-0">@lang('dingsu.win_from_basic')</p>
					</div>
					<div class="side-right">
						<small class="display-4 mb-4 font-weight-light">{{$result->total_game_bet - $result->total_game_lose }} </small>
					</div>
				</div>

				<div class="wrapper d-flex justify-content-between">
					<div class="side-left">
						<p class="card-text mb-0">@lang('dingsu.win_from_vip')</p>
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
				<h2 class="card-title text-primary ">@lang('dingsu.total_wabao_bet')</h2>
				<div class="wrapper d-flex justify-content-between">
					<div class="side-left">
						<p class="card-text mb-0">@lang('dingsu.total_game_bet')</p>
					</div>
					<div class="side-right">
						<small class="display-4 mb-4 font-weight-light">{{$result->total_game_bet}} </small>
					</div>
				</div>

				<div class="wrapper d-flex justify-content-between">
					<div class="side-left">
						<p class="card-text mb-0">@lang('dingsu.total_game_lose')</p>
					</div>
					<div class="side-right">
						<small class="display-4 mb-4 font-weight-light">{{$result->total_game_lose}}</small>
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
	
	
<script language="javascript">
	@section('socket')
    @parent
	
	
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
						alert('Error');
					}
				},
				error: function ( xhr, ajaxOptions, thrownError ) {
					alert('Error');
				}
			} );
};

 


	
	function updategame(mcall)
	{
		if (mcall)
		{
			ajax_call();
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