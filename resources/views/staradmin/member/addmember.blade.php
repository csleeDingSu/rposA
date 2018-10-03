<div class="col-12 grid-margin">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">@lang('dingsu.add_new_member')</h4>
                  <form class="form-sample" action="/member/add" method="post" autocomplete="on">
					  
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
                          <label for="account_type" class="col-sm-3 col-form-label">@lang('dingsu.account_type')</label>
                          <div class="col-sm-9">
                            <select id="account_type" name="account_type" class="form-control">
                              <option value="">@lang('Please select 1')</option>
                              <option value="1">@lang('dingsu.test_account')</option>
                              <option value="2">@lang('dingsu.member_account')</option>
                            </select>
                          </div>
                        </div>
						   </div>
               
               <div class="col-md-6">
						   <div class="form-group row">
                          <label for="admin_level" class="col-sm-3 col-form-label">@lang('dingsu.admin_level')</label>
                          <div class="col-sm-9">
                            <select id="admin_level" name="admin_level" class="form-control">
                              <option value="">@lang('Please select 1')</option>
                              <option value="1">@lang('dingsu.super_admin')</option>
                              <option value="2">@lang('dingsu.system_admin')</option>
                              <option value="3">@lang('dingsu.marketing_admin')</option>
                            </select>
                          </div>
                        </div>
                </div>
					  </div>
                   
                    
					  
					  
					  <div class="row">
						
                      <div class="col-md-6">
                        <div class="form-group row"> 
							<label for="firstname" class="col-sm-3 col-form-label">@lang('dingsu.firstname')</label>
                          
							 
                          <div class="col-sm-9">
                            <input id="firstname" name="firstname" class="form-control" type="text" autofocus value="{{ old('firstname')}}">
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label for="lastname" class="col-sm-3 col-form-label">@lang('dingsu.last_name')</label>
                          <div class="col-sm-9">
                            <input id="lastname" name="lastname" class="form-control" type="text" value="{{ old('lastname')}}">
                          </div>
                        </div>
                      </div>
                    </div>
					  
					  <div class="row"> 
						
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label for="username" class="col-sm-3 col-form-label">@lang('dingsu.username')</label>
                          <div class="col-sm-9">
                            <input id="username" name="username" class="form-control" type="text" required value="asfd">
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label for="email" class="col-sm-3 col-form-label">@lang('dingsu.email')</label>
                          <div class="col-sm-9">
                            <input id="email" name="email" class="form-control" type="text" required value="{{ old('email')}}">
                          </div>
                        </div>
                      </div>
                    </div>
					  
					  <div class="row">
						
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label for="password" class="col-sm-3 col-form-label">@lang('dingsu.password')</label>
                          <div class="col-sm-9">
                            <input id="password" name="password" class="form-control" type="password" autocomplete="off" required value="12345">
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label for="c_password" class="col-sm-3 col-form-label">@lang('dingsu.confirm_password')</label>
                          <div class="col-sm-9">
                            <input id="c_password" name="c_password" class="form-control" type="password" autocomplete="off" required value="asfd">
                          </div>
                        </div>
                      </div>
                    </div>
					  
					  <div class="row">
						
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label for="w_password" class="col-sm-3 col-form-label">@lang('dingsu.withdrawal_password')</label>
                          <div class="col-sm-9">
                            <input id="w_password" name="w_password" class="form-control" type="password" autocomplete="off" >
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label for="status" class="col-sm-3 col-form-label">@lang('dingsu.status')</label>
                          <div class="col-sm-9">
                            <select id="status" name="status" class="form-control">
                              <option value="0">@lang('dingsu.active')</option>
                              <option value="1">@lang('dingsu.inactive')</option>
								<option value="2">@lang('dingsu.suspended')</option>
                            </select>
                          </div>
                        </div>
                      </div>
                    </div>
					  
                    <button type="submit" class="btn btn-success mr-2">@lang('dingsu.submit')</button>
                    <a href="/member/list/" type="" class="btn btn-light mr-2">@lang('dingsu.back')</a>
                     
                      
					  
                    
                  </form>
              </div>
            </div>