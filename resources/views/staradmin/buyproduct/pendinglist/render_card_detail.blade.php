@foreach($result as $list)

<span>SubOrder id : {{$list->id}}</span>
	<div class="row">
		<div class="col-md-6">
			<div class="form-group row">
				<label for="card_num" class="col-sm-6 col-form-label">@lang('dingsu.card_num') <span class="text-danger">*</span></label>
				<div class="col-sm-6">
					<input type="text" class="form-control" name="card_num_{{$list->id}}" id="card_num_{{$list->id}}" required value="{{$list->card_num}}">
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group row">
				<label for="card_pass" class="col-sm-6 col-form-label">@lang('dingsu.card_pass') <span class="text-danger">*</span></label>
				<div class="col-sm-6">
					<input type="text" class="form-control" name="card_pass_{{$list->id}}" id="card_pass_{{$list->id}}" value="{{$list->card_pass}}">
				</div>
			</div>
		</div>
	</div>

@endforeach

<input type="hidden" name="rid" id="rid" value="{{$orderid}}">