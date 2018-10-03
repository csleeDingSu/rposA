<div class="col-12 grid-margin">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">@lang('dingsu.edit_member')</h4>
                  <form class="form-sample" action="" method="post" autocomplete="on">
					   
					 
					  
					  
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
                              <option {{  $member->account_type == '1' ? 'selected' : '' }} value="1">@lang('dingsu.test_account')</option>
                              <option {{  $member->account_type == '2' ? 'selected' : '' }} value="2">@lang('dingsu.member_account')</option>
                            </select>
                          </div>
                        </div>
						   </div>


               <div class="col-md-6">
						   <div class="form-group row">
                          <label for="admin_level" class="col-sm-3 col-form-label">@lang('dingsu.admin_level')</label>
                          <div class="col-sm-9">
                            <select id="admin_level" name="admin_level" class="form-control">
                              <option value="">@lang('Please select 1 1')</option>
                              <option {{  $member->admin_level == '1' ? 'selected' : '' }} value="1">@lang('dingsu.super_admin')</option>
                              <option {{  $member->admin_level == '2' ? 'selected' : '' }} value="2">@lang('dingsu.system_admin')</option>
                              <option {{  $member->admin_level == '3' ? 'selected' : '' }} value="3">@lang('dingsu.marketing_admin')</option>
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
                            <input id="firstname" name="firstname" class="form-control" type="text" autofocus value="{{ $member->firstname}}">
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label for="lastname" class="col-sm-3 col-form-label">@lang('dingsu.last_name')</label>
                          <div class="col-sm-9">
                            <input id="lastname" name="lastname" class="form-control" type="text" value="{{ $member->lastname}}">
                          </div>
                        </div>
                      </div>
                    </div>
					  
					  <div class="row"> 
						
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label for="username" class="col-sm-3 col-form-label">@lang('dingsu.username')</label>
                          <div class="col-sm-9">
                            <input disabled id="" name="" class="form-control" type="text"  value="{{$member->username}}">
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label for="email" class="col-sm-3 col-form-label">@lang('dingsu.email')</label>
                          <div class="col-sm-9">
                            <input id="email" name="email" class="form-control" type="text" required value="{{ $member->email}}">
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
                              <option {{old('status',$member->member_status)=="0"? 'selected':''}}  value="0" >@lang('dingsu.active')</option>
                              <option {{old('status',$member->member_status)=="1"? 'selected':''}} value="1">@lang('dingsu.inactive')</option>
								              <option {{old('status',$member->member_status)=="2"? 'selected':''}} value="2">@lang('dingsu.suspended')</option>
                            </select>
							  
							  
							 
                          </div>
                        </div>
                      </div>
                    </div>
					  
                    <button type="submit" class="btn btn-success mr-2">@lang('dingsu.submit')</button>
                    <a href="/member/list/" type="" class="btn btn-light mr-2">@lang('dingsu.back')</a>
                    <div class="row">
                      
                      
                   
					  
					  
                    
                  </form>
                </div>
              </div>
            </div>