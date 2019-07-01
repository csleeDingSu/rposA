<div class="col-12 grid-margin">
	<div class="card">
		<div class="card-body">
			<h4 class="card-title">@lang('dingsu.update') @lang('dingsu.order')</h4>
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
								<input id="product_name" name="product_name" class="form-control" type="text" autofocus value="{{ old('product_name', $record->product_name) }}">
							</div>
						</div>
					</div>
					
				</div>


				<div class="row">
					<div class="col-md-6">
						<div class="form-group row">
							<label for="courier_name" class="col-sm-3 col-form-label">@lang('dingsu.courier_name')</label>
							<div class="col-sm-9">
								<input id="product_price" name="courier_name" class="form-control" type="text" required value="{{ old('courier_name', $record->courier_name) }}" maxlength="10">
							</div>
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group row">
							<label for="tracking_number" class="col-sm-3 col-form-label">@lang('dingsu.tracking_number')</label>
							<div class="col-sm-9">
								<input id="tracking_number" name="tracking_number" class="form-control" type="text" required value="{{ $record->tracking_number }}" readonly maxlength="5">
							</div>
						</div>
					</div>
				</div>


				<div class="row">
					<div class="col-md-6">
						<div class="form-group row">
							<label for="notes" class="col-sm-3 col-form-label">@lang('dingsu.notes')</label>
							<div class="col-sm-9">
								<input id="notes" name="notes" class="form-control" type="text" required value="{{ old('notes', $record->notes) }}">
							</div>
						</div>
					</div>
					

				</div>
				
				


				<button type="submit" class="btn btn-success mr-2">@lang('dingsu.submit')</button>
				<a href="" type="submit" class="btn btn-light mr-2">@lang('dingsu.reset')</a>


			</form>
		</div>
	</div>