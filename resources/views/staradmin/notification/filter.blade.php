<div class="row text-capitalize">

	<div class="col-lg-12 grid-margin stretch-card">
		<div class="card">
			<div class="card-body">
				<form class="" name="searchform" id="searchform" action="" method="get" autocomplete="on">
					<h4 class="card-title">@lang('dingsu.search')</h4>
					<div class="form-group row">

						<div class="col">
							<label for="s_member">@lang('dingsu.member')</label>
							<div id="the-basics">
								<input type="text" class="form-control typeahead tt-input" name="s_member" id="s_member" placeholder="@lang('dingsu.member')">
							</div>
						</div>

						<div class="col">
							<label for="s_status">@lang('dingsu.status')</label>
							<div id="bloodhound">
								<select id="s_status" name="s_status" class="form-control">
									<option value="" selected>@lang('dingsu.default_select')</option>
									<option value="0" >@lang('dingsu.unread')</option>
									<option value="1" >@lang('dingsu.read')</option>
									
								</select>
							</div>
						</div>
						<div class="col">
							<label>@lang('dingsu.action')</label>
							<div id="bloodhound">
								<button type="button" id="search" class="btn btn-icons btn-rounded btn-outline-info btn-inverse-info search"> <i class="  icon-magnifier  "></i> </button>
								<button type="button" id="reset_search" class="btn btn-icons btn-rounded btn-outline-info btn-inverse-danger "> <i class=" icon-refresh "></i> </button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>