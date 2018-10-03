<div class="col-12 grid-margin">
	<div class="card">
		<div class="card-body">
			<h4 class="card-title">@lang('dingsu.add_game')</h4>
			<form class="form-sample" action="/game/new" method="post" autocomplete="on">

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
							<label for="game_name" class="col-sm-3 col-form-label">@lang('dingsu.game_name') <span class="text-danger">*</span></label>
							<div class="col-sm-9">
								<input id="game_name" name="game_name" class="form-control" type="text" required autofocus value="{{ old('game_name')}}">
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group row">
							<label for="game_id" class="col-sm-3 col-form-label">@lang('dingsu.game_id')<span class="text-danger">*</span></label></label>
							<div class="col-sm-9">
								<input id="game_id" name="game_id" class="form-control" type="text" value="{{ old('game_id')}}">
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group row">
							<label for="status" class="col-sm-3 col-form-label">@lang('dingsu.status')</label>
							<div class="col-sm-9">
								<select id="status" name="status" class="form-control">
									<option value="0">@lang('dingsu.active')</option>
									<option  value="1">@lang('dingsu.inactive')</option>
									<option  value="2">@lang('dingsu.suspended')</option>
								</select>
							</div>
						</div>
					</div>
					<div class="col-md-6">

						<div class="form-group row">
							<label for="category" class="col-sm-3 col-form-label">@lang('dingsu.category')</label>
							<div class="col-sm-9">
								<select id="category" name="category" class="form-control">
									<option  value="1">@lang('dingsu.category') 1</option>
									<option  value="2">@lang('dingsu.category') 2</option>
									<option  value="3">@lang('dingsu.category') 3</option>
									<option  value="4">@lang('dingsu.category') 4</option>
								</select>
							</div>
						</div>

					</div>
				</div>
				<div class="row">

					<div class="col-md-6">
						<div class="form-group row">
							<label class="col-sm-3 col-form-label">@lang('dingsu.membership') </label>
							<div class="col-sm-4">
								<div class="form-radio">
									<label for="membershipRadios1" class="form-check-label">
                                <input id="" name="" class="form-check-input" name="membershipRadios" id="membershipRadios1" value="" checked="" type="radio"> @lang('dingsu.free') 
                              <i class="input-helper"></i></label>
								
								</div>
							</div>
							<div class="col-sm-5">
								<div class="form-radio">
									<label for="membershipRadios2" class="form-check-label">
                                <input class="form-check-input" name="membershipRadios" id="membershipRadios2" value="option2" type="radio">  @lang('dingsu.paid')
                              <i class="input-helper"></i></label>
								
								</div>
							</div>
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group row">
							<label for="notes" class="col-sm-3 col-form-label"> @lang('dingsu.notes')</label>
							<div class="col-sm-9">
								<textarea id="notes" name="notes" placeholder="" class="form-control">{{ old('notes')}}</textarea>
							</div>
						</div>
					</div>

				</div>

				<button type="submit" class="btn btn-success mr-2">@lang('dingsu.submit')</button>
				<a href="" type="submit" class="btn btn-light mr-2">@lang('dingsu.reset')</a>


			</form>
		</div>
	</div>
</div>