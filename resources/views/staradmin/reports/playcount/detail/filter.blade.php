<div class="row">

	

		<div class="col-lg-12 grid-margin stretch-card">
			<div class="card">
				<div class="card-body">
					<form class="" name="searchform" id="searchform" action="" method="get" autocomplete="on">
					<h4 class="card-title">@lang('dingsu.play') @lang('dingsu.detail')</h4>
					<div class="form-group row">
																		
						<div class="col">
							<label>@lang('dingsu.gameid')</label>
							<div id="the-basics">
								<input type="text" class="form-control typeahead tt-input" name="s_gameid" id="s_gameid" placeholder="@lang('dingsu.gameid')" value="{{ app('request')->input('gameid') }}">
							</div>
						</div>
						
						<div class="col">
							<label>@lang('dingsu.date')</label>
							<div id="the-basics">
								<input type="text" class="form-control typeahead tt-input" name="s_date" id="s_date" placeholder="@lang('dingsu.date')" value="{{ app('request')->input('date') }}">
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


