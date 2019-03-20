
<div class="row">

	<form class="form-sample" name="searchform" id="searchform" action="" method="get" autocomplete="on">

		<div class="col-md-12 grid-margin stretch-card">
			<div class="card">
				<div class="card-body">
					<h4 class="card-title">@lang('dingsu.search')</h4>
					<div class="form-group row">
						<div class="col">
							<label>@lang('dingsu.voucher')</label>
							<div id="the-basics">
								<input type="text" class="form-control typeahead tt-input" name="s_title" id="s_title" placeholder="@lang('dingsu.voucher')">
							</div>
						</div>
						<div class="col">
							<label>@lang('dingsu.category') </label>
							<div id="the-basics">

								<select class="form-control" name="s_cate" id="s_cate">
									<option value=" "></option>
								@foreach ($category as $cate) 
									<option value="{{$cate->display_name}}">{{$cate->display_name}}</option>
								@endforeach
								</select>


							</div>
						</div>
						<div class="col">
							<label>@lang('dingsu.sortby')</label>
							<div id="bloodhound">
							<select class="form-control" name="s_sort" id="s_sort">
								<option value="created_at">@lang('dingsu.upload_date')</option>
								<option value="month_sales">@lang('dingsu.month_sales')</option>
								<option value="product_price">@lang('dingsu.product_price')</option>
								<option value="voucher_price">@lang('dingsu.voucher_price')</option>
							</select>

							</div>
						</div>

						<div class="col">
							<label>@lang('dingsu.sortby')</label>
							<div id="bloodhound">
							<select class="form-control" name="s_order" id="s_order">
								<option value="DESC">@lang('dingsu.descending')</option>
								<option value="ASC">@lang('dingsu.ascending')</option>
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


