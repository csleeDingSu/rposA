@foreach($result as $list)

	<div class="row">
		<div class="col-md-6">
			<div class="form-group row">
				<label for="receiver_name" class="col-sm-6 col-form-label">@lang('dingsu.receiver_name') <span class="text-danger">*</span></label>
				<div class="col-sm-6">
					<input type="text" class="form-control" name="receiver_name" id="receiver_name" required value="{{$list->receiver_name}}">					
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group row">
				<label for="contact_number" class="col-sm-6 col-form-label">@lang('dingsu.contact_number') <span class="text-danger">*</span></label>
				<div class="col-sm-6">
					<input type="text" class="form-control" name="contact_number" id="contact_number" value="{{$list->contact_number}}">
				</div>
			</div>
		</div>
	</div>
<div class="row">
		<div class="col-md-6">
			<div class="form-group row">
				<label for="alternative_contact_number" class="col-sm-6 col-form-label">@lang('dingsu.alternative') @lang('dingsu.contact_number') </label>
				<div class="col-sm-6">
					<input type="text" class="form-control" name="alternative_contact_number" id="alternative_contact_number" value="{{$list->alternative_contact_number}}"> 
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group row">
				<label for="address" class="col-sm-6 col-form-label">@lang('dingsu.address') <span class="text-danger">*</span></label>
				<div class="col-sm-6">
					<textarea name="address" id="address" class="form-control" >{{$list->address}}</textarea>
				</div>
			</div>
		</div>
	</div>
<div class="row">
		<div class="col-md-6">
			<div class="form-group row">
				<label for="city" class="col-sm-6 col-form-label">@lang('dingsu.city') <span class="text-danger">*</span></label>
				<div class="col-sm-6">
					<input type="text" class="form-control" name="city" id="city" value="{{$list->city}}">
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group row">
				<label for="zip" class="col-sm-6 col-form-label">@lang('dingsu.zip') <span class="text-danger">*</span></label>
				<div class="col-sm-6">
					<input type="text" class="form-control" name="zip" id="zip" value="{{$list->zip}}">
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<div class="form-group row">
				<label for="country" class="col-sm-6 col-form-label">@lang('dingsu.country') <span class="text-danger">*</span></label>
				<div class="col-sm-6">
					<input type="text" class="form-control" name="country" id="country" required value="{{$list->country}}">
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group row">
				<label for="notes" class="col-sm-6 col-form-label">@lang('dingsu.notes') </label>
				<div class="col-sm-6">
					<textarea name="notes" id="notes" class="form-control">{{$list->notes}}</textarea>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-6">
			<div class="form-group row">
				<label for="tracking_number" class="col-sm-6 col-form-label">@lang('dingsu.tracking_number') <span class="text-danger">*</span></label>
				<div class="col-sm-6">
					<input type="text" class="form-control" name="tracking_number" id="tracking_number" value="{{$list->tracking_number}}">
				</div>
				<error></error>
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group row">
				<label for="tracking_partner" class="col-sm-6 col-form-label">@lang('dingsu.tracking_partner') <span class="text-danger">*</span></label>
				<div class="col-sm-6">
					<input type="text" class="form-control" name="tracking_partner" id="tracking_partner" value="{{$list->tracking_partner}}">
				</div>
			</div>
		</div>
	</div>

@endforeach
<input type="hidden" name="rid" id="rid" value="{{$orderid}}">