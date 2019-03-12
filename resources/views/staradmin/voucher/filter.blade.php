<div class="row">

	

		<div class="col-lg-12 grid-margin stretch-card">
			<div class="card">
				<div class="card-body">
					<form class="" name="searchform" id="searchform" action="" method="get" autocomplete="on">
					<h3 class="card-title">@lang('dingsu.search')</h3>
					<div class="form-group row">
						<div class="col">
							<label>@lang('dingsu.category')</label>
							<div id="the-basics">
								<select class="form-control" name="s_title" id="s_title">
									<option value=" "></option>
								@foreach ($category as $cate) 
									<option value="{{$cate->display_name}}">{{$cate->display_name}}</option>
								@endforeach
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


