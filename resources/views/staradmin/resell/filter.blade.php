<div class="row">

		<div class="col-lg-12 grid-margin stretch-card">
			<div class="card">
				<div class="card-body">
					<form class="" name="searchform" id="searchform" action="" method="get" autocomplete="on">
					<h4 class="card-title">Search</h4>
					<div class="form-group row">
						
						
						<div class="col">
							<label for="s_member">@lang('dingsu.seller')</label>
							<div id="the-basics">
								<input type="text" class="form-control typeahead tt-input" name="s_member" id="s_member" placeholder="@lang('dingsu.seller')">
							</div>
						</div>

						<div class="col">
							<label for="s_buyer">@lang('dingsu.buyer')</label>
							<div id="the-basics">
								<input type="text" class="form-control typeahead tt-input" name="s_buyer" id="s_buyer" placeholder="@lang('dingsu.buyer')">
							</div>
						</div>
						
						<div class="col">
							<label for="s_status">@lang('dingsu.status')</label>
							<div id="bloodhound">
								<select id="s_status" name="s_status" class="form-control">
									<option value="" selected>@lang('dingsu.default_select')</option>
									@foreach($statuses ?? '' as $val)
									<option value="{{$val->id}}">{{trans('dingsu.' . $val->name )}}</option>
									@endforeach
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


