<div class="col-12 grid-margin">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">@lang('dingsu.add_new_product')</h4>
                  <form class="form-sample" action="" method="post" autocomplete="on" enctype="multipart/form-data">
					  
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
							<label for="product_name" class="col-sm-3 col-form-label">@lang('dingsu.product') @lang('dingsu.name')</label>
                          
							 
                          <div class="col-sm-9">
                            <input id="product_name" name="product_name" class="form-control" type="text" autofocus value="{{ old('product_name')}}">
                          </div>
                        </div>
                      </div>
                      <!-- <div class="col-md-6">
                        <div class="form-group row">
                          <label for="quantity" class="col-sm-3 col-form-label">@lang('dingsu.product_display_id')</label>
                          <div class="col-sm-9">
                            <input id="product_display_id" name="product_display_id" class="form-control" type="text" value="{{ old('product_display_id')}}" maxlength="5">
                          </div>
                        </div>
                      </div> -->
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label for="quantity" class="col-sm-3 col-form-label">@lang('dingsu.product_description')</label>
                          <div class="col-sm-9">
                            <textarea rows="2", cols="45" id="product_description" name="product_description" class="form-control" value="{{ old('product_description')}}"></textarea>

                          </div>
                        </div>
                      </div>
                    </div>
					  
					  
					  <div class="row"> 
						<div class="col-md-6">
                        <div class="form-group row">
                          <label for="product_price" class="col-sm-3 col-form-label">@lang('dingsu.product_price')</label>
                          <div class="col-sm-9">
                            <input id="product_price" name="product_price" class="form-control" type="text" required value="{{ old('product_price')}}"  maxlength="10">
                          </div>
                        </div>
                      </div>
						  <div class="col-md-6">
                        <div class="form-group row">
                          <label for="discount_price" class="col-sm-3 col-form-label">@lang('dingsu.discount_price')</label>
                          <div class="col-sm-9">
                            <input id="discount_price" name="discount_price" class="form-control" type="text" required value="{{ old('discount_price') }}"  maxlength="10">
                          </div>
                        </div>
                      </div>
						  
                     
                    
                    </div>
					  
					  
					  
					  <div class="row"> 
						
                     <div class="col-md-6">
                        <div class="form-group row">
                          <label for="required_point" class="col-sm-3 col-form-label">@lang('dingsu.min_point')</label>
                          <div class="col-sm-9">
                            <input id="required_point" name="required_point" class="form-control" type="text" required value="{{ old('required_point')}}"  maxlength="5">
                          </div>
                        </div>
                      </div>
                     <div class="col-md-6">
                        <div class="form-group row">
                          <label for="product_quantity" class="col-sm-3 col-form-label">@lang('dingsu.available_quantity')</label>
                          <div class="col-sm-9">
                            <input id="product_quantity" name="product_quantity" class="form-control" type="text" required value="{{ old('product_quantity')}}"  maxlength="5">
                          </div>
                        </div>
                      </div>
                    </div>
					 
					  <div class="row">
						 
						 <div class="col-md-6">
                        <div class="form-group row">
                          <label for="product_picurl" class="col-sm-3 col-form-label">@lang('dingsu.url') @lang('dingsu.image')</label>
                          <div class="col-sm-9">
                            <input id="product_picurl" name="product_picurl" class="form-control" type="text" value="{{ old('product_picurl')}}" >
                          </div>
                        </div>
                      </div>
						 
						
                     <div class="col-md-6">
                        <div class="form-group row">
                          <label for="product_image" class="col-sm-3 col-form-label">@lang('dingsu.image')</label>
                          <div class="col-sm-9">
                             {{ Form::file('product_image', array('class' => 'image')) }}
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
                              <option value="1">@lang('dingsu.inactive')</option>
								<option value="2">@lang('dingsu.reserved')</option>
                            </select>
                          </div>
                        </div>
                      </div>
                    </div> 
					  
					
					  
                    <button type="submit" class="btn btn-success mr-2">@lang('dingsu.submit')</button>
					  <a href="" type="submit" class="btn btn-light mr-2">@lang('dingsu.reset')</a>
                     
                      
					  
                    
                  </form>
              </div>
            </div>