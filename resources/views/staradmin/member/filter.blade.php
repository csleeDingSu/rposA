<div class="row">

	<div class="col-12 d-flex  text-right"><a href="/member/add" class="btn btn-success mr-2">@lang('dingsu.add_new_member')</a>
	</div>
</div>
<div class="row">

	<div class="col-12 d-flex  text-right"><a href="/alipay/list" class="btn btn-success mr-2">@lang('dingsu.alipay_transaction_log')</a>
	</div>
</div>
<div class="clearfix">&nbsp;</div>


<div class="row">

	<form class="form-sample" name="searchform" id="searchform" action="" method="get" autocomplete="on">

		<div class="col-md-12 grid-margin stretch-card">
			<div class="card">
				<div class="card-body">
					<h4 class="card-title">@lang('dingsu.search')</h4>
					<div class="form-group row">
						<div class="col">
							<label>@lang('dingsu.alipay_account')</label>
							<div id="the-basics">
								<input type="text" class="form-control typeahead tt-input" name="s_alipay" id="s_alipay" placeholder="@lang('dingsu.alipay_account')">
							</div>
						</div>

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
							<label>@lang('dingsu.referred_by')</label>
							<div id="the-basics">
								<input type="text" class="form-control typeahead tt-input" name="s_referred_by" id="s_referred_by" placeholder="@lang('dingsu.referred_by')">
							</div>
						</div>

						<div class="col">
							<label>@lang('dingsu.wechat') @lang('dingsu.name')</label>
							<div id="the-basics">
								<input type="text" class="form-control typeahead tt-input" name="s_wechat_name" id="s_wechat_name" placeholder="@lang('dingsu.wechat') @lang('dingsu.name')"> </div>
						</div>
						<div class="col">
							<label>@lang('dingsu.wechat') @lang('dingsu.status')</label>
							<div id="the-basics">

								<select id="s_wechatstatus" name="s_wechatstatus" class="form-control">
									<option value="" selected>@lang('dingsu.default_select')</option>
									<option value="0">@lang('dingsu.verified')</option>
									<option value="1">@lang('dingsu.unverified')</option>
									<option value="2">@lang('dingsu.rejected') / @lang('dingsu.account_closed')</option>
									<option value="3">@lang('dingsu.suspended')</option>
								</select>


							</div>
						</div>
						<div class="col">
							<label>@lang('dingsu.status')</label>
							<div id="bloodhound">
								<select id="s_status" name="s_status" class="form-control">
									<option value="" selected>@lang('dingsu.default_select')</option>
									<option value="0">@lang('dingsu.active')</option>
									<option value="1">@lang('dingsu.inactive')</option>
									<option value="2">@lang('dingsu.suspended')</option>
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
				</div>
			</div>
		</div>
	</form>
</div>


