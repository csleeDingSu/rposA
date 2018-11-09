<div class="col-12 grid-margin">
	<div class="card">
		<div class="card-body">
			<h4 class="card-title">@lang('dingsu.add_game')</h4>
			<form class="form-sample" action="/game/add" method="post" autocomplete="on">

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
							  <label for="game_id" class="col-sm-3 col-form-label">@lang('dingsu.game') @lang('dingsu.id')</label>
							
							   
							<div class="col-sm-9">
							  <input id="game_id" name="game_id" class="form-control" type="text" autofocus value="{{ old('game_id') }}">
							</div>
						  </div>
						</div>
						<div class="col-md-6">
						  <div class="form-group row">
							<label for="game_name" class="col-sm-3 col-form-label">@lang('dingsu.game') @lang('dingsu.name')</label>
							<div class="col-sm-9">
							  <input id="game_name" name="game_name" class="form-control" type="text" value="{{ old('game_name') }}">
							</div>
						  </div>
						</div>
					  </div>
						
						
						<div class="row"> 
						  <div class="col-md-6">
						  <div class="form-group row">
						  <label for="is_active" class="col-sm-3 col-form-label">@lang('dingsu.is_active')</label>
                          <div class="col-sm-9">
								<select id="is_active" name="is_active" class="form-control">
								<option value="1" >@lang('dingsu.yes')</option>
								<option value="0" >@lang('dingsu.no')</option>
								</select>
							</div>
						  </div>
						</div>
								
					  <div class="col-md-6">
						  <div class="form-group row">
							<label for="membership" class="col-sm-3 col-form-label">@lang('dingsu.membership')</label>
							<div class="col-sm-9">
							  <input id="membership" name="membership" class="form-control" type="text" required value="{{ old('membership') }}" readonly  maxlength="5">
							</div>
						  </div>
						</div>
					  </div>
						
						
						
						<div class="row"> 
					  <div class="col-md-6">
						  <div class="form-group row">
						  <label for="category" class="col-sm-3 col-form-label">@lang('dingsu.category')</label>
							<div class="col-sm-9">
								<select id="category" name="category" class="form-control">
								<option value="0" >@lang('dingsu.category') 1</option>
								<option value="1" >@lang('dingsu.category') 2</option>
								<option value="2" >@lang('dingsu.category') 3</option>
								<option value="3" >@lang('dingsu.category') 4</option>
								</select>
							</div>
						  </div>
						</div>
					   <div class="col-md-6">
						  <div class="form-group row">
							<label for="game_status" class="col-sm-3 col-form-label">@lang('dingsu.game_status')</label>
							<div class="col-sm-9">
							  <select id="game_status" name="game_status" class="form-control">
								
							   <option  value="0" >@lang('dingsu.active')</option>
							   <option  value="1" >@lang('dingsu.inactive')</option>
							   <option  value="2" >@lang('dingsu.reserved')</option>
								  
							  </select>
							</div>
						  </div>
						</div>
					  </div>
  
  
  
						<div class="row"> 
					  <div class="col-md-6">
						  <div class="form-group row">
						  <label for="is_support_game_resume" class="col-sm-3 col-form-label">@lang('dingsu.is_support_game_resume')</label>
                          <div class="col-sm-9">
								<select id="is_support_game_resume" name="is_support_game_resume" class="form-control">
								<option value="1" >@lang('dingsu.yes')</option>
								<option value="0" >@lang('dingsu.no')</option>
								</select>
							</div>
						  </div>
						</div>
						<div class="col-md-6">
						  <div class="form-group row">
							<label for="notes" class="col-sm-3 col-form-label">@lang('dingsu.notes')</label>
							<div class="col-sm-9">
							  <input id="notes" name="notes" class="form-control" type="text" value="{{ old('notes') }}"  maxlength="5">
							</div>
						  </div>
						</div>
					  </div>

				<button type="submit" class="btn btn-success mr-2">@lang('dingsu.submit')</button>
				<a href="" type="submit" class="btn btn-light mr-2">@lang('dingsu.reset')</a>
				<a href="/game/list" type="submit" class="btn btn-light mr-2">@lang('dingsu.back')</a>


			</form>
		</div>
	</div>
</div>