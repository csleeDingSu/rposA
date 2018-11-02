<div class="col-12 grid-margin">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">@lang('dingsu.edit_user')</h4>
                  <form class="form-sample" action="" method="post" autocomplete="off">
					  
					  {{ csrf_field() }}
					  
					  
					  @foreach ($errors->all() as $error)
						<div class="alert alert-danger" role="alert">@lang($error)</div>
					  @endforeach
					  
					  
					  @if(session()->has('message'))
						<div class="alert alert-success" role="alert">
							{{ session()->get('message') }}
						</div>
					@endif
					  
			
                   
                    
					  
					  
					  <div class="row">
						
                      <div class="col-md-6">
                        <div class="form-group row"> 
							<label for="firstname" class="col-sm-3 col-form-label">@lang('dingsu.firstname')</label>
                          
							 
                          <div class="col-sm-9">
                            <input id="firstname" name="firstname" class="form-control" type="text" autofocus value="{{ old('firstname', $user->name) }}">
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label for="username" class="col-sm-3 col-form-label">@lang('dingsu.username')</label>
                          <div class="col-sm-9">
                            <input disabled id="" name="" class="form-control" type="text"  value="{{$user->username}}">
                          </div>
                        </div>
                      </div>
                    </div>
					  
					  <div class="row"> 
						
                      
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label for="email" class="col-sm-3 col-form-label">@lang('dingsu.email')</label>
                          <div class="col-sm-9">
                            <input id="email" name="email" class="form-control" type="text" required value="{{ old('email', $user->email) }}">
                          </div>
                        </div>
                      </div>
						  
						  <div class="col-md-6">
                        <div class="form-group row">
                          <label for="user_status" class="col-sm-3 col-form-label">@lang('dingsu.status')</label>
                          <div class="col-sm-9">
                            <select id="user_status" name="status" class="form-control">
                              <option {{old('status',$user->user_status)=="1"? 'selected':''}}  value="1" >@lang('dingsu.active')</option>
                              <option {{old('status',$user->user_status)=="2"? 'selected':''}} value="2">@lang('dingsu.inactive')</option>
								<option {{old('status',$user->user_status)=="3"? 'selected':''}} value="3">@lang('dingsu.suspended')</option>
                            </select>
							  
							  
							 
                          </div>
                        </div>
                      </div>
                    </div>
					  
					  
					
					
					  
                    <button type="submit" class="btn btn-success mr-2">@lang('dingsu.submit')</button>
					  <a href="" type="submit" class="btn btn-light mr-2">@lang('dingsu.reset')</a>
                    <div class="row">
                      
                      
                   
					  
					  
                    
                  </form>
                </div>
              </div>
            </div>