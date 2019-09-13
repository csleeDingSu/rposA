
@if($result)

<input id="id" name="id" class=" form-control" type="hidden" value="{{$result->id}}">

					<div class="row">
						<div class="col-md-6">
							<div class="form-group row">
								<label for="receipt" class="col-sm-3 col-form-label">@lang('dingsu.receipt') <span class="text-danger">*</span></label>
								<div class="col-sm-9">
									<input id="receipt" receipt="receipt" class=" form-control" type="text" value="{{$result->receipt}}" maxlength="150">
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group row">
								<label for="amount" class="col-sm-3 col-form-label">@lang('dingsu.amount') <span class="text-danger">*</span></label>
								<div class="col-sm-9">
									<input id="amount" name="amount" class="form-control" type="text"  value="{{$result->amount}}" maxlength="50">
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group row">
								<label for="status" class="col-sm-3 col-form-label">@lang('dingsu.status') </label>
								<div class="col-sm-9">
									<select id="status" name="status" class="form-control">
										<option @if (1 == $result->status)) selected="selected" @endif  value="1">@lang('dingsu.inprogress')</option>
										<option @if (2 == $result->status)) selected="selected" @endif value="2">@lang('dingsu.successful')</option>
										<option @if (3 == $result->status)) selected="selected" @endif value="3">@lang('dingsu.unsuccessful')</option>										
									</select>
									
								</div>
							</div>
						</div>
						
						<div class="col-md-6">
							<div class="form-group row">
								<label for="status" class="col-sm-3 col-form-label">@lang('dingsu.reason') </label>
								<div class="col-sm-9">
									
									<select id="reason_id" name="reason_id" class="form-control">									 	
										<option value="" selected>@lang('dingsu.default_select')</option>
										@foreach($reason as $val)
										<option @if ($val->id == $result->reason_id)) selected="selected" @endif value="{{$val->id}}">{{ $val->name }}</option>
										@endforeach
									</select>	
									
									
								</div>
							</div>
						</div>
					</div>


					<div class="row">
						
						<div class="col-md-6">
							<div class="form-group row">
								<label for="remark" class="col-sm-3 col-form-label">@lang('dingsu.remark') </label>
								<div class="col-sm-9">
									<textarea name="remark" class="form-control"> {{$result->remark}} </textarea>
								</div>
							</div>
						</div>
						
					</div>


					@endif