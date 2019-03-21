<div class="col-12 grid-margin">
	<div class="card">
		<div class="card-body">
			<h4 class="card-title">@lang('dingsu.setting')</h4>
			<hr>
			<form class="form-sample" action="" method="post" autocomplete="off">

				{{ csrf_field() }} @foreach ($errors->all() as $error)
				<div class="alert alert-danger" role="alert">@lang($error)</div>
				@endforeach @if(session()->has('message'))
				<div class="alert alert-success" role="alert">
					{{ session()->get('message') }}
				</div>
				@endif

				<!-- <div class="row">
					<div class="col-md-6">
						<div class="form-group row">
							<label for="allow_login" class="col-sm-3 col-form-label">@lang('dingsu.allow_login')</label>

							<div class="col-sm-9">
								<select id="allow_login" name="allow_login" class="form-control">
									<option {{old( 'allow_login',$record->allow_login)=="Y"? 'selected':''}} value="Y" >@lang('dingsu.yes')</option>
									<option {{old( 'allow_login',$record->allow_login)=="N"? 'selected':''}} value="N">@lang('dingsu.no')</option>
								</select>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group row">
							<label for="allow_registration" class="col-sm-3 col-form-label">@lang('dingsu.allow_registration')</label>
							<div class="col-sm-9">
								<select id="allow_registration" name="allow_registration" class="form-control">
									<option {{old( 'allow_registration',$record->allow_registration)=="Y"? 'selected':''}} value="Y" >@lang('dingsu.yes')</option>
									<option {{old( 'allow_registration',$record->allow_registration)=="N"? 'selected':''}} value="N">@lang('dingsu.no')</option>
								</select>
							</div>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-6">
						<div class="form-group row">
							<label for="site_maintenance" class="col-sm-3 col-form-label">@lang('dingsu.site_maintenance')</label>
							<div class="col-sm-9">
								<select id="site_maintenance" name="site_maintenance" class="form-control">
									<option {{old( 'site_maintenance',$record->site_maintenance)=="Y"? 'selected':''}} value="Y" >@lang('dingsu.yes')</option>
									<option {{old( 'site_maintenance',$record->site_maintenance)=="N"? 'selected':''}} value="N">@lang('dingsu.no')</option>
								</select>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group row">
							<label for="maintenance_message" class="col-sm-3 col-form-label">@lang('dingsu.maintenance_message')</label>
							<div class="col-sm-9">
								<textarea class="form-control" name="maintenance_message" id="maintenance_message" placeholder="@lang('dingsu.maintenance_message_placeholder')" rows="3">{{ $record->maintenance_message }}</textarea>
							</div>
						</div>
					</div>
				</div> -->

				<div class="row">
					<div class="col-md-6">
						<div class="form-group row">
							<label for="introduce_life" class="col-sm-3 col-form-label">@lang('dingsu.introduce_life')</label>
							<div class="col-sm-9">
								<input id="introduce_life" name="introduce_life" class="form-control" type="text" value="{{$record->introduce_life}}" maxlength="2">
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group row">
							<label for="game_default_life" class="col-sm-3 col-form-label">@lang('dingsu.game_default_life')</label>
							<div class="col-sm-9">
								<input id="game_default_life" name="game_default_life" class="form-control" type="text" value="{{ old('game_default_life', $record->game_default_life) }}" maxlength="2">
							</div>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-6">
						<div class="form-group row">
							<label for="auto_product_redeem" class="col-sm-3 col-form-label">@lang('dingsu.auto_product_redeem')</label>
							<div class="col-sm-9">
								<select id="auto_product_redeem" name="auto_product_redeem" class="form-control">
									<option {{old( 'auto_product_redeem',$record->auto_product_redeem)=="Y"? 'selected':''}} value="Y" >@lang('dingsu.yes')</option>
									<option {{old( 'auto_product_redeem',$record->auto_product_redeem)=="N"? 'selected':''}} value="N">@lang('dingsu.no')</option>
								</select>
							</div>
						</div>
					</div>
				</div>


				<!-- <div class="row">
					<div class="col-md-6">
						<div class="form-group row">
							<label for="auto_maintenance" class="col-sm-3 col-form-label">@lang('dingsu.auto_maintenance')</label>
							<div class="col-sm-9">
								<div class="form-check form-check-flat">
									<label class="form-check-label">
                                <input value="1" {{ (! empty(old('auto_maintenance')) ? 'checked' : '') }} name="auto_maintenance" id="auto_maintenance" class="form-check-input" type="checkbox"> &nbsp; <i class="input-helper"></i></label>								
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-6">
						<div class="form-group row">
							<label for="maintenance_start_time" class="col-sm-3 col-form-label">@lang('dingsu.maintenance_start_time')</label>
							<div class="col-sm-9">
								<input id="maintenance_start_time" name="maintenance_start_time" class="form-control" type="text" value="{{$record->maintenance_start_time}}">
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group row">
							<label for="maintenance_end_time" class="col-sm-3 col-form-label">@lang('dingsu.maintenance_end_time')</label>
							<div class="col-sm-9">
								<input id="maintenance_end_time" name="maintenance_end_time" class="form-control" type="text" value="{{ old('maintenance_end_time', $record->maintenance_end_time) }}">
							</div>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-6">
						<div class="form-group row">
							<label for="mobile_default_image_url" class="col-sm-3 col-form-label">@lang('dingsu.mobile_default_image_url')</label>
							<div class="col-sm-9">
								<select id="mobile_default_image_url" name="mobile_default_image_url" class="form-control">
									<option {{old( 'mobile_default_image_url',$record->mobile_default_image_url)=="_160x160.jpg"? 'selected':''}} value="_160x160.jpg" >@lang('dingsu.mobile')</option>
									<option {{old( 'mobile_default_image_url',$record->mobile_default_image_url)=="_460x460Q90.jpg"? 'selected':''}} value="_460x460Q90.jpg">@lang('dingsu.desktop')</option>
								</select>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group row">
							<label for="desktop_default_image_url" class="col-sm-3 col-form-label">@lang('dingsu.desktop_default_image_url')</label>
							<div class="col-sm-9">
								<select id="desktop_default_image_url" name="desktop_default_image_url" class="form-control">
									<option {{old( 'desktop_default_image_url',$record->desktop_default_image_url)=="_160x160.jpg"? 'selected':''}} value="_160x160.jpg" >@lang('dingsu.mobile')</option>
									<option {{old( 'desktop_default_image_url',$record->desktop_default_image_url)=="_460x460Q90.jpg"? ' selected':''}} value="_460x460Q90.jpg">@lang('dingsu.desktop')</option>
								</select>
							</div>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-6">
						<div class="form-group row">
							<label for="wabao_fee" class="col-sm-3 col-form-label">@lang('dingsu.wabao_fee')</label>
							<div class="col-sm-9">
								<input id="wabao_fee" name="wabao_fee" class="form-control" type="text" value="{{ old('wabao_fee', $record->wabao_fee) }}" maxlength="5">
							</div>
						</div>
					</div>
				</div> -->

				<button type="submit" class="btn btn-success mr-2">@lang('dingsu.submit')</button>
				<a href="/admin" type="submit" class="btn btn-light mr-2">@lang('dingsu.back')</a>
				<div class="row">
			</form>
			</div>
		</div>
	</div>
