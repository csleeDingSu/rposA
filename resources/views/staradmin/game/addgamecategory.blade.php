<div class="col-12 grid-margin">
	<div class="card">
		<div class="card-body">
			<h4 class="card-title">@lang('dingsu.add_game')</h4>
			<form class="form-sample" action="/game/category/add" method="post" autocomplete="on">

				{{ csrf_field() }}
				
				
				 @foreach ($errors->all() as $error)
				<div class="alert alert-danger" role="alert">@lang($error)</div>
				@endforeach @if(session()->has('message'))
				<div class="alert alert-success" role="alert">
					{{ session()->get('message') }}
				</div>
				@endif


					<div class="row">
						<div class="col-md-6">
						  <div class="form-group row"> 
							  <label for="name" class="col-sm-3 col-form-label">@lang('dingsu.name')</label>
							<div class="col-sm-9">
							  <input id="name" name="name" class="form-control" type="text" autofocus value="{{ old('name') }}">
							</div>
						  </div>
						</div>
						<div class="col-md-6">
						  <div class="form-group row">
							<label for="block_time" class="col-sm-3 col-form-label">@lang('dingsu.block') @lang('dingsu.time')</label>
							<div class="col-sm-9">
							  <input id="block_time" name="block_time" class="form-control" type="text" value="{{ old('block_time') }}">
							</div>
						  </div>
						</div>
					  </div>
						
						
						<div class="row"> 
						  <div class="col-md-6">
						  <div class="form-group row">
						  <label for="game_type" class="col-sm-3 col-form-label">@lang('dingsu.game_type')</label>
              <div class="col-sm-9">
									<input id="game_type" name="game_type" class="form-control" type="text" value="{{ old('game_type') }}">
							</div>
						  </div>
						</div>
						<div class="col-md-6">
						  <div class="form-group row">
							<label for="env_file_name" class="col-sm-3 col-form-label">@lang('dingsu.env_file_name')</label>
							<div class="col-sm-9">
							  <input id="env_file_name" name="env_file_name" class="form-control" type="text" value="{{ old('env_file_name') }}"  maxlength="5">
							</div>
						  </div>
						</div>
					  </div>
						
						
						<div class="row"> 
						<div class="col-md-6">
						  <div class="form-group row">
						  <label for="game_time" class="col-sm-3 col-form-label">@lang('dingsu.game_time')</label>
                <div class="col-sm-9">
									<input id="game_time" name="game_time" class="form-control" type="text" value="{{ old('game_time') }}"  maxlength="5">
							</div>
						  </div>
						</div>
						<div class="col-md-6">
						  <div class="form-group row">
						  <label for="game_lock_time" class="col-sm-3 col-form-label">@lang('dingsu.game_lock_time')</label>
                  <div class="col-sm-9">
									<input id="game_lock_time" name="game_lock_time" class="form-control" type="text" value="{{ old('game_lock_time') }}"  maxlength="5">
							</div>
						  </div>
						</div>
						</div>

				<div class="row"> 
						<div class="col-md-6">
						  <div class="form-group row">
						  <label for="user_lock_time" class="col-sm-3 col-form-label">@lang('dingsu.user_lock_time')</label>
              	<div class="col-sm-9">
								<input id="user_lock_time" name="user_lock_time" class="form-control" type="text" value="{{ old('user_lock_time') }}"  maxlength="5">
							</div>
						  </div>
						</div>
              <div class="col-md-6">
						  <div class="form-group row">
						  <label for="is_support_tournament" class="col-sm-3 col-form-label">@lang('dingsu.is_support_tournament')</label>
                          <div class="col-sm-9">
								<select id="is_support_tournament" name="is_support_tournament" class="form-control">
								<option value="1" >@lang('dingsu.yes')</option>
								<option value="0" >@lang('dingsu.no')</option>
								</select>
							</div>
						  </div>
						</div>
						</div>

						<div class="row"> 
						<div class="col-md-6">
						  <div class="form-group row">
						  <label for="is_support_multiplayer" class="col-sm-3 col-form-label">@lang('dingsu.is_support_multiplayer')</label>
                          <div class="col-sm-9">
								<select id="is_support_multiplayer" name="is_support_multiplayer" class="form-control">
								<option value="1" >@lang('dingsu.yes')</option>
								<option value="0" >@lang('dingsu.no')</option>
								</select>
							</div>
						  </div>
						</div>
					  <div class="col-md-6">
						  <div class="form-group row">
						  <label for="is_track_user" class="col-sm-3 col-form-label">@lang('dingsu.is_track_user')</label>
                          <div class="col-sm-9">
								<select id="is_track_user" name="is_track_user" class="form-control">
								<option value="1" >@lang('dingsu.yes')</option>
								<option value="0" >@lang('dingsu.no')</option>
								</select>
							</div>
						  </div>
						</div>
						</div>

						<div class="row"> 
						<div class="col-md-6">
						  <div class="form-group row">
						  <label for="save_game_session" class="col-sm-3 col-form-label">@lang('dingsu.save_game_session')</label>
                          <div class="col-sm-9">
								<select id="save_game_session" name="save_game_session" class="form-control">
								<option value="1" >@lang('dingsu.yes')</option>
								<option value="0" >@lang('dingsu.no')</option>
								</select>
							</div>
						  </div>
						</div>
					  
					  <div class="col-md-6">
						  <div class="form-group row">
						  <label for="is_session_end_on_update" class="col-sm-3 col-form-label">@lang('dingsu.is_session_end_on_update')</label>
                          <div class="col-sm-9">
								<select id="is_session_end_on_update" name="is_session_end_on_update" class="form-control">
								<option value="1" >@lang('dingsu.yes')</option>
								<option value="0" >@lang('dingsu.no')</option>
								</select>
							</div>
						  </div>
						</div>
						</div>

					<div class="row"> 
						<div class="col-md-6">
						  <div class="form-group row">
						  <label for="is_override_core_setting" class="col-sm-3 col-form-label">@lang('dingsu.is_override_core_setting')</label>
                          <div class="col-sm-9">
								<select id="is_override_core_setting" name="is_override_core_setting" class="form-control">
								<option value="1" >@lang('dingsu.yes')</option>
								<option value="0" >@lang('dingsu.no')</option>
								</select>
							</div>
						  </div>
						</div>
						<div class="col-md-6">
						  <div class="form-group row">
						  <label for="is_support_custom_setting" class="col-sm-3 col-form-label">@lang('dingsu.is_support_custom_setting')</label>
                          <div class="col-sm-9">
								<select id="is_support_custom_setting" name="is_support_custom_setting" class="form-control">
								<option value="1" >@lang('dingsu.yes')</option>
								<option value="0" >@lang('dingsu.no')</option>
								</select>
							</div>
						  </div>
						</div>
					  </div>
				
				
				<div class="row"> 
						<div class="col-md-6">
						  <div class="form-group row">
						  <label for="win_ratio" class="col-sm-3 col-form-label">@lang('dingsu.win_ratio')</label>
                          <div class="col-sm-9">
								<input id="win_ratio" name="win_ratio" class="form-control" type="text" value="{{ old('win_ratio') }}" maxlength="5">
							  
							</div>
						  </div>
						</div>
						
					  </div>

            

				<button type="submit" class="btn btn-success mr-2">@lang('dingsu.submit')</button>
				<a href="/game/category" type="submit" class="btn btn-light mr-2">@lang('dingsu.back')</a>


			</form>
		</div>
	</div>
</div>