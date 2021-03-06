
@if($result)

<input id="id" name="id" class=" form-control" type="hidden" value="{{$result->id}}">

					<div class="row">
						<div class="col-md-6">
							<div class="form-group row">
								<label for="amount" class="col-sm-3 col-form-label">@lang('dingsu.seller') <span class="text-danger">*</span></label>
								<div class="col-sm-9">
									{{$result->member->phone}}
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group row">
								<label for="point" class="col-sm-3 col-form-label">@lang('dingsu.point') <span class="text-danger">*</span></label>
								<div class="col-sm-9">
									{{$result->point}}
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group row">
								<label for="amount" class="col-sm-3 col-form-label">@lang('dingsu.amount') <span class="text-danger">*</span></label>
								<div class="col-sm-9">
									{{$result->amount}}
								</div>
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group row">
								<label for="buyer_id" class="col-sm-3 col-form-label">@lang('dingsu.buyer') @lang('dingsu.phone') </label>
								<div class="col-sm-9">
									<input id="buyer_id" name="buyer_id" class="form-control" type="text" value="{{$result->buyer->phone ?? ''}}" maxlength="50">
								</div>
							</div>
						</div>
						
					</div>

					<div class="row">
						<div class="col-md-6">
							<div class="form-group row">
								<label for="amount" class="col-sm-3 col-form-label">@lang('dingsu.is_paying') <span class="text-danger">*</span></label>
								<div class="col-sm-9">
									@if ($result->is_locked)
										<label class="text-capitalize badge badge-warning">
										{{trans('dingsu.yes' )}}
									</label>
									@else
										{{trans('dingsu.no' )}}
									@endif	
								</div>
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group row">
								<label for="buyer_id" class="col-sm-3 col-form-label">@lang('dingsu.payment_expired') </label>
								<div class="col-sm-9">
									
										{{$result->locked_time}}
									
								</div>
							</div>
						</div>						
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group row">
								<label for="amount" class="col-sm-3 col-form-label">@lang('dingsu.type') <span class="text-danger">*</span></label>
								<div class="col-sm-9">
									@if ($result->type)
										<label class="text-capitalize badge badge-success">
										{{trans('dingsu.company_account' )}}
									</label>
									@else
										{{trans('dingsu.zhifubao' )}}
									@endif	
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group row">
								<label for="amount" class="col-sm-3 col-form-label">@lang('dingsu.passcode') <span class="text-danger">*</span></label>
								<div class="col-sm-9">
									{{$result->passcode}}	
								</div>
							</div>
						</div>

												
					</div>
					<div class="row">
						
						<div class="col-md-6">
							<div class="form-group row">
								<label for="status" class="col-sm-3 col-form-label">@lang('dingsu.status') </label>
								<div class="col-sm-9">
									<select id="status_id" name="status_id" class="form-control">									 	
										@php ($iStatus = count($statuses))
										@foreach($statuses as $val)
										<option 
												 @if ($val->id == $result->status_id)
													selected="selected"
												 @endif											
												
												value="{{$val->id}}">
												@if (($val->id == 7) && ($iStatus > 3))
													{{trans('dingsu.resell_reset_' . $val->name )}}
												@else
													{{trans('dingsu.resell_' . $val->name )}}
												@endif
										</option>
										@endforeach
									</select>	
									
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group row">
								<label for="reason" class="col-sm-3 col-form-label">@lang('dingsu.reason') </label>
								<div class="col-sm-9">
									<textarea class="form-control" name="reason" id="reason" placeholder="{{trans('dingsu.enter_reason')}}">{{$result->reason}}</textarea>
										
									
								</div>
							</div>
						</div>

						
					</div>

					<div class="row">
						<div class="col-md-6">
							<div class="form-group row">
								<label for="buyer_id" class="col-sm-3 col-form-label">@lang('dingsu.barcode')</label>
								<div class="col-sm-9">
									<img src="{{$result->barcode ?? ''}}" width="80%" height="300px">
								</div>
							</div>
						</div>					
						
					</div>




					


					@endif