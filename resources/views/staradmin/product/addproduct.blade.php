<div class="col-12 grid-margin">
	<div class="card">
		<div class="card-body">
			<h4 class="card-title">@lang('dingsu.add_new_product')</h4>
			<form class="form-sample" action="" method="post" autocomplete="on">

				{{ csrf_field() }} @foreach ($errors->all() as $error)
				<div class="alert alert-danger" role="alert">@lang($error)</div>
				@endforeach @if(session()->has('message'))
				<div class="alert alert-success" role="alert">
					{{ session()->get('message') }}
				</div>
				@endif

				<div class="row">
					<div class="col-md-6">
						<div class="form-group row">
							<label for="product_name" class="col-sm-3 col-form-label">@lang('dingsu.product') @lang('dingsu.name')</label>
							<div class="col-sm-9">
								<input id="product_name" name="product_name" class="form-control" type="text" autofocus value="{{ old('product_name')}}">
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<!--<div class="form-group row">
							<label for="quantity" class="col-sm-3 col-form-label">@lang('dingsu.product_display_id')</label>
							<div class="col-sm-9">
								<input id="product_display_id" name="product_display_id" class="form-control" type="text" value="{{ old('product_display_id')}}" maxlength="5">
							</div>
						</div>-->
					</div>
				</div>

				<div class="row">
					<div class="col-md-6">
						<div class="form-group row">
							<label for="product_price" class="col-sm-3 col-form-label">@lang('dingsu.product_price')</label>
							<div class="col-sm-9">
								<input id="product_price" name="product_price" class="form-control" type="text" required value="{{ old('product_price')}}" maxlength="10">
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group row">
							<label for="min_point" class="col-sm-3 col-form-label">@lang('dingsu.min_point')</label>
							<div class="col-sm-9">
								<input id="min_point" name="min_point" class="form-control" type="text" required value="{{ old('min_point')}}" maxlength="5">
							</div>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-6">
						<div class="form-group row">
							<label for="product_pic_url" class="col-sm-3 col-form-label">@lang('dingsu.product_picurl')</label>
							<div class="col-sm-9">
								<input id="product_pic_url" name="product_pic_url" class="form-control" type="text" value="{{ old('product_pic_url')}}">
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group row">
							<label for="description" class="col-sm-3 col-form-label">@lang('dingsu.description')</label>
							<div class="col-sm-9">
								<input id="description" name="description" class="form-control" type="text" required value="{{ old('description')}}">
							</div>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-6">
						<div class="form-group row">
							<label for="status" class="col-sm-3 col-form-label">@lang('dingsu.status')</label>
							<div class="col-sm-9">
								<select id="status" name="status" class="form-control">
									<option value="0">@lang('dingsu.active')</option>
									<option value="1">@lang('dingsu.inactive')</option>
									<option value="2">@lang('dingsu.reserved')</option>
								</select>
							</div>
						</div>
					</div>
					
					<div class="col-md-6">
						<div class="form-group row">
							<label for="seq" class="col-sm-3 col-form-label">@lang('dingsu.seq')</label>
							<div class="col-sm-9">
								<input id="seq" name="seq" class="form-control" type="text"  value="{{ old('seq')}}">
							</div>
						</div>
					</div>
				</div>
				
				


				<button type="submit" class="btn btn-success mr-2">@lang('dingsu.submit')</button>
				<a href="" type="submit" class="btn btn-light mr-2">@lang('dingsu.reset')</a>

			</form>
		</div>
	</div>