<div class="col-12 grid-margin">
	<div class="card">
		<div class="card-body">
			<h4 class="card-title">@lang('dingsu.import_voucher')</h4>
			 <form class="form-horizontal" method="POST" action="{{ route('importparse') }}" enctype="multipart/form-data">
                           
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
							<label for="game_name" class="col-sm-3 col-form-label">@lang('dingsu.file') <span class="text-danger">*</span></label>
							<div class="col-sm-9">
								<input id="file" type="file" class="form-control" name="file" required>
							</div>
						</div>
					</div>					
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group row">
							<label for="publish" class="col-sm-3 col-form-label">@lang('dingsu.publish')</label>
							<div class="col-sm-9">
								<div class="form-check">
                            <label class="form-check-label">
                              <input class="form-check-input" id="publish" name="publish" checked="" type="checkbox">
                              @lang('dingsu.auto_publish')
                            <i class="input-helper"></i></label>
                          </div>
							</div>
							
							
							 
							
							
						</div>
					</div>
					
				</div>
				

				<button type="submit" class="btn btn-success mr-2">@lang('dingsu.upload')</button>
				<a href="" type="submit" class="btn btn-light mr-2">@lang('dingsu.reset')</a>


			</form>
		</div>
	</div>
</div>