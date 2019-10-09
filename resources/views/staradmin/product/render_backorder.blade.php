<div class="" id="validation-errors"></div>



<input id="id" name="id" class=" form-control" type="hidden" value="{{$result->id}}">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group row">
								<label  class="col-sm-3 col-form-label">@lang('dingsu.softpin') <span class="text-danger">*</span></label>
								<div class="col-sm-9">
									<input  readonly class=" form-control" type="text" value="{{$result->pin_name}}" maxlength="150">
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group row">
								<label  class="col-sm-3 col-form-label">@lang('dingsu.product') @lang('dingsu.name') <span class="text-danger">*</span></label>
								<div class="col-sm-9">
									<input class="form-control" type="text"  readonly value="{{$result->product_name}}" maxlength="50">
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group row">
								<label for="phone" class="col-sm-3 col-form-label">@lang('dingsu.phone')  </label>
								<div class="col-sm-9">
									<input id="phone" name="phone" class="form-control" type="text" value="" maxlength="50">
								</div>
							</div>
						</div>
												
					</div>



									