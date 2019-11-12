@foreach($result as $key=>$list)

<span>Game id : {{$list->game_id}}</span>
	<div class="row">
		<div class="col-md-6">
			<div class="form-group row">
				<label class="col-sm-6 col-form-label">@lang('dingsu.current_point') </label>
				<div class="col-sm-6">
					<input type="text" class="form-control" readonly value="{{$list->point}}">
				</div>
			</div>
		</div>
		<div class="col-md-2">
			<div class="form-group row">				
				<div class="col-sm-12">
					<select  class="form-control" name="typepoint[{{$list->id}}]" id="typepoint[{{$list->id}}]">
						<option value="1">@lang('dingsu.add')</option>
						<option value="2">@lang('dingsu.subtract')</option>
					</select>
										
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group row">				
				<div class="col-sm-12">
					<input type="text" class="form-control" placeholder="@lang('dingsu.nothing_to_change')" name="point[{{$list->id}}]" id="point[{{$list->id}}]" value="">
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<div class="form-group row">
				<label class="col-sm-6 col-form-label">@lang('dingsu.current_life') </label>
				<div class="col-sm-6">
					<input type="text" class="form-control" readonly value="{{$list->life}}">
				</div>
			</div>
		</div>
		<div class="col-md-2">
			<div class="form-group row">				
				<div class="col-sm-12">
					<select  class="form-control" name="typelife[{{$list->id}}]" id="typelife[{{$list->id}}]">
						<option value="1">@lang('dingsu.add')</option>
						<option value="2">@lang('dingsu.subtract')</option>
					</select>
										
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group row">				
				<div class="col-sm-12">
					<select class="form-control" name="life[{{$list->id}}]" id="life[{{$list->id}}]">
						<option value="0">@lang('dingsu.nothing_to_change')</option>
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3">3</option>
						<option value="4">4</option>
						<option value="5">5</option>
					</select>					
				</div>
			</div>
		</div>
	</div>

@endforeach


<input type="hidden" name="id" value="{{$id}}">
	  