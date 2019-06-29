@foreach($result as $list)

					<div class="row">
						<div class="col-md-12">
							<div class="form-group row">
								<label for="card_num" class="col-sm-6 col-form-label">@lang('dingsu.card') <span class="text-danger">*</span></label>
								<div class="col-sm-6">
									<input type="text" class="form-control" name="card_num[{{$list->id}}]
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group row">
								<label for="card_pass" class="col-sm-6 col-form-label">@lang('dingsu.pass')<span class="text-danger">*</span></label>
								<div class="col-sm-6">
									<input type="text" class="form-control" name="card_pass[{{$list->id}}]" id="card_pass" value="" maxlength="50">
								</div>
							</div>
						</div>
					</div>

					@endforeach

					<input type="hidden" name="rid" id="rid" value="{{$orderid}}">