<div class="row">	

		<div class="col-lg-12 grid-margin stretch-card">
			<div class="card">
				<div class="card-body">
					<form class="" name="searchform" id="searchform" action="" method="get" autocomplete="on">
					<h4 class="card-title">@lang('dingsu.search')</h4>
					<div class="form-group row">
						
						<div class="col">
							<label>@lang('dingsu.wechat_name')</label>
							<div id="the-basics">
								<input type="text" class="form-control typeahead tt-input" name="s_wechat_name" id="s_wechat_name" placeholder="@lang('dingsu.wechat_name')">
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
									@foreach($type_list as $type)
										<option value="{{ $type->type }}">@lang('dingsu.'.$type->name) </option>
									@endforeach									
								</select>
							</div>
						</div>						
						
						<div class="col">
							<label>@lang('dingsu.sort_by')</label>
							<div id="bloodhound">
								<select id="order_by" name="order_by" class="form-control">
									<option value="DESC" selected>@lang('dingsu.descending') @lang('dingsu.order')</option>
									<option value="ASC">@lang('dingsu.ascending') @lang('dingsu.order')</option>									
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


