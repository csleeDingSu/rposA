
@if($result)

<input id="id" name="id" class=" form-control" type="hidden" value="{{$result->id}}">
<!--
					<div class="row">
						<div class="col-md-6">
							<div class="form-group row">
								<label for="name" class="col-sm-3 col-form-label">@lang('dingsu.name') <span class="text-danger">*</span></label>
								<div class="col-sm-9">
									<input id="name" name="name" class="form-control" type="text" value="{{$result->name }}" maxlength="150">
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group row">
								<label for="bank_detail" class="col-sm-3 col-form-label">@lang('dingsu.bank_detail') <span class="text-danger">*</span></label>
								<div class="col-sm-9">
									<input id="bank_detail" name="bank_detail" class="form-control" type="text" value="{{$result->bank_detail }}" maxlength="150">
								</div>
							</div>
						</div>
					</div> -->
					<div class="row">
						<div class="col-md-6">
							<div class="form-group row">
								<label for="account_name" class="col-sm-3 col-form-label">@lang('dingsu.account_name') <span class="text-danger">*</span></label>
								<div class="col-sm-9">
									<input id="account_name" name="account_name" class="form-control" type="text" value="{{$result->account_name }}" maxlength="150">
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group row">
								<label for="account_number" class="col-sm-3 col-form-label">@lang('dingsu.account_number') <span class="text-danger">*</span></label>
								<div class="col-sm-9">
									<input id="account_number" name="account_number" class="form-control" type="text" value="{{$result->account_number }}" maxlength="150">
								</div>
							</div>
						</div>
					</div>
					<div class="row">
					<!--	<div class="col-md-6">
							<div class="form-group row">
								<label for="phone" class="col-sm-3 col-form-label">@lang('dingsu.phone') <span class="text-danger">*</span></label>
								<div class="col-sm-9">
									<input id="phone" name="phone" class="form-control" type="text" value="{{$result->phone }}" maxlength="150">
								</div>
							</div>
						</div> -->
						<div class="col-md-6">
							<div class="form-group row">
								<label for="bank_name" class="col-sm-3 col-form-label">@lang('dingsu.bank_name') <span class="text-danger">*</span></label>
								<div class="col-sm-9">
									<input id="bank_name" name="bank_name" class="form-control" type="text" value="{{$result->bank_name }}" maxlength="150">
								</div>
							</div>
						</div>
					</div>
					

					

					






					


					@endif