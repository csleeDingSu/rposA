<div class="row">

	

		<div class="col-lg-12 grid-margin stretch-card">
			<div class="card">
				<div class="card-body">
					<form class="" name="searchform" id="searchform" action="" method="get" autocomplete="on">
					<h4 class="card-title">Search</h4>
					<div class="form-group row">
						
						<div class="col">
							<label>@lang('dingsu.username')</label>
							<div id="the-basics">
								<input type="text" class="form-control typeahead tt-input" name="s_username" id="s_username" placeholder="@lang('dingsu.username')">
							</div>
						</div>
						
						<div class="col">
							<label>@lang('dingsu.phone')</label>
							<div id="the-basics">
								<input type="text" class="form-control typeahead tt-input" name="s_phone" id="s_phone" placeholder="@lang('dingsu.phone')">
							</div>
						</div>

						<div class="col">
							<label>@lang('dingsu.credit_type')</label>
							<div id="bloodhound">
								<select id="s_type" name="s_type" class="form-control">
									<option value="" selected>@lang('dingsu.default_select')</option>
									<option value="CRPNT">@lang('dingsu.credit') @lang('dingsu.point')</option>
									<option value="RPNT">@lang('dingsu.redeem') @lang('dingsu.point')</option>
									<option value="RBAL">@lang('dingsu.redeem') @lang('dingsu.balance')</option>
									<option value="ABAL">@lang('dingsu.added') @lang('dingsu.balance')</option>
									<option value="APNT">@lang('dingsu.added') @lang('dingsu.point')</option>
									<option value="DBAL">@lang('dingsu.deducted') @lang('dingsu.balance')</option>
									<option value="DPNT">@lang('dingsu.deducted') @lang('dingsu.point')</option>
									<option value="APPNT">@lang('dingsu.acpoint') @lang('dingsu.redeemed')</option>
									<option value="ALFE">@lang('dingsu.added') @lang('dingsu.life')</option>
									<option value="APVIP">@lang('dingsu.added') @lang('dingsu.vip') @lang('dingsu.point')</option>
									<option value="DPVIP">@lang('dingsu.deducted') @lang('dingsu.vip') @lang('dingsu.point')</option>
									<option value="ALVIP">@lang('dingsu.added') @lang('dingsu.vip') @lang('dingsu.life')</option>
									<option value="DLVIP">@lang('dingsu.deducted') @lang('dingsu.vip') @lang('dingsu.life')</option>
									<option value="DLRVL">@lang('dingsu.reset') @lang('dingsu.vip') @lang('dingsu.life')</option>
									<option value="APMNT">@lang('dingsu.vip') @lang('dingsu.point') @lang('dingsu.merged')</option>
									<option value="APRFN">@lang('dingsu.vip') @lang('dingsu.refund')</option>
									<option value="ALPRV">@lang('dingsu.added_vip_life_by_redeemed') @lang('dingsu.package')</option>
									<option value="APLRV">@lang('dingsu.added_vip_point_by_redeemed')</option>
									
									<option value="WVRFE">@lang('dingsu.fee') </option>
									<option value="ALACL">@lang('dingsu.admin') @lang('dingsu.amended') @lang('dingsu.life')</option>
									<option value="ALILE">@lang('dingsu.introduction') @lang('dingsu.life')</option>
									<option value="APACP">@lang('dingsu.admin') @lang('dingsu.add') @lang('dingsu.point')</option>
									<option value="APAVP">@lang('dingsu.admin') @lang('dingsu.add') @lang('dingsu.vip') @lang('dingsu.point')</option>
									<option value="ALAVL">@lang('dingsu.admin') @lang('dingsu.add') @lang('dingsu.vip') @lang('dingsu.life')</option>
									<option value="DPRPO">@lang('dingsu.redeem_product_using_point')</option>
									<option value="DPBVP">@lang('dingsu.buy_vip_using_point')</option>
								</select>
							</div>
						</div>

						<div class="col">
							<label>@lang('dingsu.action')</label>
							<div id="bloodhound">
								<button onClick="Search();return false();" type="button" id="search" class="btn btn-icons btn-rounded btn-outline-info btn-inverse-info search"> <i class="  icon-magnifier  "></i> </button>
								<button type="button" id="reset_search" class="btn btn-icons btn-rounded btn-outline-info btn-inverse-danger "> <i class=" icon-refresh "></i> </button>
							</div>
						</div>
					</div>
					</form>
				</div>
			</div>
		</div>
	
</div>


