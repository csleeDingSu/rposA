<div class="row">

	

		<div class="col-lg-12 grid-margin stretch-card">
			<div class="card">
				<div class="card-body">
					<form class="" name="searchform" id="searchform" action="" method="get" autocomplete="on">
					<h4 class="card-title">Search</h4>
					<div class="form-group row">
						<div class="col">
							<label>@lang('dingsu.product') @lang('dingsu.name')</label>
							<div id="the-basics">
								<input type="text" class="form-control typeahead tt-input" name="s_product_name" id="s_product_name" placeholder="@lang('dingsu.product')">
							</div>
						</div>

						<div class="col">
							<label>@lang('dingsu.phone')</label>
							<div id="bloodhound">
								<input type="text" class="form-control typeahead tt-input" name="s_phone" id="s_phone" placeholder="@lang('dingsu.phone')">
							</div>
						</div>
						
						<div class="col">
							<label>@lang('dingsu.code')</label>
							<div id="bloodhound">
								<input type="text" class="form-control typeahead tt-input" name="s_code" id="s_code" placeholder="@lang('dingsu.code')">
							</div>
						</div>
						
						<div class="col">
							<label>@lang('dingsu.wechat_name')</label>
							<div id="bloodhound">
								<input type="text" class="form-control typeahead tt-input" name="s_wechat_name" id="s_wechat_name" placeholder="@lang('dingsu.wechat_name')">
							</div>
						</div>

						<div class="col">
							<label>@lang('dingsu.wechat')</label>
							<div id="bloodhound">
								<input type="text" class="form-control typeahead tt-input" name="s_wechatname" id="s_wechatname" placeholder="@lang('dingsu.wechat')">
							</div>
						</div>
						<div class="col">
							<label>@lang('dingsu.status')</label>
							<div id="bloodhound">
								<select id="s_status" name="s_status" class="form-control">
									<option value="" selected>@lang('dingsu.default_select')</option>
									<option value="0">@lang('dingsu.active') / @lang('dingsu.unused')</option>
									<option value="1">@lang('dingsu.redeemed')</option>
									<option value="2">@lang('dingsu.confirmed')</option>
									<option value="3">@lang('dingsu.rejected')</option>
									<option value="4">@lang('dingsu.pending') @lang('dingsu.confirmation')</option>
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


