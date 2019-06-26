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
								<input type="text" class="form-control typeahead tt-input" name="s_product" id="s_product" placeholder="@lang('dingsu.package')">
							</div>
						</div>
						<div class="col">
							<label>@lang('dingsu.phone')</label>
							<div id="bloodhound">
								<input type="text" class="form-control typeahead tt-input" name="s_phone" id="s_phone" placeholder="@lang('dingsu.phone')">
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


