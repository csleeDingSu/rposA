<div class="row">

	<div class="col-12 d-flex  text-right"><a href="/user/add" class="btn btn-success mr-2">@lang('dingsu.add')</a>
	</div>
</div>
<div class="clearfix">&nbsp;</div>


<div class="row">

	

		<div class="col-md-12 grid-margin stretch-card">
			<div class="card">
				<form class="form-sample" name="searchform" id="searchform" action="" method="get" autocomplete="on">
				<div class="card-body">
					<h4 class="card-title">Search</h4>
					<div class="form-group row">
										

						<div class="col">
							<label>@lang('dingsu.username')</label>
							<div id="the-basics">
								<input type="text" class="form-control typeahead tt-input" name="s_username" id="s_username" placeholder="@lang('dingsu.username') "> </div>
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
					</form>
			</div>
		</div>
	
</div>


