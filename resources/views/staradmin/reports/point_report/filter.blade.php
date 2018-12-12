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
							<label>@lang('dingsu.credit_type')</label>
							<div id="bloodhound">
								<select id="s_type" name="s_type" class="form-control">
									<option value="" selected>@lang('dingsu.default_select')</option>
									<option value="BAL">@lang('dingsu.credit_type_BAL')</option>
									<option value="BAL_REDEEM">@lang('dingsu.credit_type_BAL_REDEEM')</option>
									<option value="CRD_REDEEM">@lang('dingsu.credit_type_CRD_REDEEM')</option>
									<option value="LFE">@lang('dingsu.credit_type_LFE')</option>
									<option value="PNT">@lang('dingsu.credit_type_PNT')</option>									
									<option value="PNT_REDEEM">@lang('dingsu.credit_type_PNT_REDEEM')</option>
									<option value="UNK">@lang('dingsu.credit_type_UNK')</option>
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


