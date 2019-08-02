<div class="row">

	

		<div class="col-lg-12 grid-margin stretch-card">
			<div class="card">
				<div class="card-body">
					<form class="" name="searchform" id="searchform" action="" method="get" autocomplete="on">
					<h4 class="card-title">Search</h4>
					<div class="form-group row">
						
						<div class="col">
							<label>@lang('dingsu.drawid')</label>
							<div id="the-basics">
								<input type="text" class="form-control typeahead tt-input" name="s_drawid" id="s_drawid" placeholder="@lang('dingsu.drawid')">
								
							</div>
						</div>
						
						<div class="col">
							<label>@lang('dingsu.gameid')</label>
							<div id="the-basics">
								<select id="s_gameid" name="s_gameid" class="form-control">
									<option value="all">@lang('dingsu.show_all')</option>
									<option value="103" selected>103</option>
									<option value="102">102</option>
									<option value="101">101</option>
								</select>
							</div>
						</div>
						
						<div class="col">
							<label>@lang('dingsu.phone')</label>
							<div id="the-basics">
								<input type="text" class="form-control typeahead tt-input" name="s_phone" id="s_phone" placeholder="@lang('dingsu.phone')">
							</div>
						</div>
						
						<div class="col">
							<label>@lang('dingsu.wechat_name')</label>
							<div id="the-basics">
								<input type="text" class="form-control typeahead tt-input" name="s_wechat_name" id="s_wechat_name" placeholder="@lang('dingsu.wechat_name')">
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


