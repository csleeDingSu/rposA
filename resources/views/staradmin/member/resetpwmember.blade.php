<div class="col-12 grid-margin">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title"> $list->id </h4>
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
							<label for="password" class="col-sm-3 col-form-label">@lang('dingsu.password')</label>
                          
							 
                          <div class="col-sm-9">
                            <input id="password" name="password" class="form-control" type="text">
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label for="c_password" class="col-sm-3 col-form-label">@lang('dingsu.confirm_password')</label>
                          <div class="col-sm-9">
                            <input id="c_password" name="c_password" class="form-control" type="text">
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