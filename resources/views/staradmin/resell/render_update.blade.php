

<input id="id" name="id" class=" form-control" type="hidden" value="{{$result->id}}">
<input id="module" name="module" class=" form-control" type="hidden" value="{{$module }}">
			<div class="row">
				<div class="col-md-6">
					<div class="form-group row">
						<label for="receipt" class="col-sm-3 col-form-label">@lang('dingsu.receipt') <span class="text-danger">*</span></label>
						<div class="col-sm-9">
							<input id="receipt" name="receipt" class=" form-control" type="text" value="{{$result->receipt}}" maxlength="150">
						</div>
					</div>
				</div>						
			</div>
