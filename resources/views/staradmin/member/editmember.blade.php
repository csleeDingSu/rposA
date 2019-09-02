<div class="col-12 grid-margin">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">@lang('dingsu.edit_member')</h4>
                  <form class="form-sample" action="" method="post" autocomplete="off">
					   
					 <!--
					  <input type="hidden" name="prc[]" id="p" value="{{ \Request::segment(3) }}">
					  -->
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
                  <label for="membership" class="col-sm-3 col-form-label">@lang('dingsu.membership')</label>
                  <div class="col-sm-9">
                    <select id="membership" name="membership" class="form-control">
                      <option {{ old('membership', $member->membership)=="0"? 'selected':'' }} value="0">@lang('dingsu.standard')</option>
                      <option {{ old('membership', $member->membership)=="1"? 'selected':'' }} value="1">@lang('dingsu.vip')</option>
                    </select>
                  </div>
                </div>
              </div>
						   
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
                   
                    
					  
					  
					  <!-- <div class="row">
						
                      <div class="col-md-6">
                        <div class="form-group row"> 
							<label for="firstname" class="col-sm-3 col-form-label">@lang('dingsu.firstname')</label>
                          
							 
                          <div class="col-sm-9">
                            <input id="firstname" name="firstname" class="form-control" type="text" autofocus value="{{ old('firstname', $member->firstname) }}">
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label for="lastname" class="col-sm-3 col-form-label">@lang('dingsu.last_name')</label>
                          <div class="col-sm-9">
                            <input id="lastname" name="lastname" class="form-control" type="text" value="{{ old('lastname', $member->lastname) }}">
                          </div>
                        </div>
                      </div>
                    </div> -->
					  
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
                            <input id="email" name="email" class="form-control" type="text" required value="{{ old('email', $member->email) }}">
                          </div>
                        </div>
                      </div>
                    </div>
					  
					  
					  
					  <div class="row">
						
                      
						  
						  <div class="col-md-6">
                        <div class="form-group row">
                          <label for="wechat_id" class="col-sm-3 col-form-label">@lang('dingsu.wechat_id')</label>
                          <div class="col-sm-9">
                            <input id="wechat_id" name="wechat_id" class="form-control" type="text"  value="{{ old('wechat_id', $member->wechat_id) }}">
                          </div>
                        </div>
                      </div>
						  
						  <div class="col-md-6">
                        <div class="form-group row">
                          <label for="email" class="col-sm-3 col-form-label">@lang('dingsu.wechat_name')</label>
                          <div class="col-sm-9">
                            <input id="wechat_name" name="wechat_name" class="form-control" type="text"  value="{{ old('wechat_name', $member->wechat_name) }}">
                          </div>
                        </div>
                      </div>
						  
                    </div>
					  
					   <div class="row">
						
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label for="status" class="col-sm-3 col-form-label">@lang('dingsu.wechat_verification_status')</label>
                          <div class="col-sm-9">
                            <select id="wechat_verification_status" name="wechat_verification_status" class="form-control" disabled>
                              <option {{old('wechat_verification_status',$member->wechat_verification_status)=="0"? 'selected':''}}  value="0" >@lang('dingsu.verified')</option>
                              <option {{old('wechat_verification_status',$member->wechat_verification_status)=="1"? 'selected':''}} value="1">@lang('dingsu.unverified')</option>    
							  <option {{old('wechat_verification_status',$member->wechat_verification_status)=="2"? 'selected':''}} value="2">@lang('dingsu.rejected') / @lang('dingsu.account_closed')</option>    
							  <option {{old('wechat_verification_status',$member->wechat_verification_status)=="3"? 'selected':''}} value="3">@lang('dingsu.suspended')</option>    	
							  </select>	
							 
                          </div>
                        </div>
                      </div>
						  
						  
						  <div class="col-md-6">
                        <div class="form-group row">
                          <label for="email" class="col-sm-3 col-form-label">@lang('dingsu.phone')</label>
                          <div class="col-sm-9">
                            <input id="phone" name="phone" class="form-control" type="text"  value="{{ old('phone', $member->phone) }}">
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