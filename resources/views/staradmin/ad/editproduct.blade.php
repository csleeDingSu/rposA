<div class="col-12 grid-margin">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">@lang('dingsu.edit_product')</h4>
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
                            <input id="product_name" name="product_name" class="form-control" type="text" autofocus value="{{ old('product_name', $record->product_name) }}">
                          </div>
                        </div>
                      </div>
                      <!-- <div class="col-md-6">
                        <div class="form-group row">
                          <label for="quantity" class="col-sm-3 col-form-label">@lang('dingsu.product_display_id')</label>
                          <div class="col-sm-9">
                            <input id="product_display_id" readonly name="product_display_id" class="form-control" type="text" value="{{ $record->product_display_id }}" maxlength="5">
                          </div>
                        </div>
                      </div> -->
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label for="quantity" class="col-sm-3 col-form-label">@lang('dingsu.product_description')</label>
                          <div class="col-sm-9">
                            <input id="product_description" name="product_description" class="form-control" type="text" value="{{ $record->product_description }}">

                          </div>
                        </div>
                      </div>
                    </div>
					  
					  
					  <div class="row"> 
						<div class="col-md-6">
                        <div class="form-group row">
                          <label for="product_price" class="col-sm-3 col-form-label">@lang('dingsu.product_price')</label>
                          <div class="col-sm-9">
                            <input id="product_price" name="product_price" class="form-control" type="text" required value="{{ old('product_price', $record->product_price) }}"  maxlength="10">
                          </div>
                        </div>
                      </div>
						  	
                    <div class="col-md-6">
                        <div class="form-group row">
                          <label for="discount_price" class="col-sm-3 col-form-label">@lang('dingsu.discount_price')</label>
                          <div class="col-sm-9">
                            <input id="discount_price" name="discount_price" class="form-control" type="text" required value="{{ old('discount_price', $record->discount_price) }}"  maxlength="10">
                          </div>
                        </div>
                      </div>
						  
                      
                    
                    </div>
					  
					  
					  
					  <div class="row"> 
					<div class="col-md-6">
                        <div class="form-group row">
                          <label for="required_point" class="col-sm-3 col-form-label">@lang('dingsu.min_point')</label>
                          <div class="col-sm-9">
                            <input id="required_point" name="required_point" class="form-control" type="text" required value="{{ old('required_point', $record->required_point) }}"  maxlength="5">
                          </div>
                        </div>
                      </div>
						  
					 <div class="col-md-6">
                        <div class="form-group row">
                          <label for="product_quantity" class="col-sm-3 col-form-label">@lang('dingsu.available_quantity')</label>
                          <div class="col-sm-9">
                            <input id="product_quantity" name="product_quantity" class="form-control" type="text" required value="{{ old('product_quantity', $record->product_quantity) }}"  maxlength="5">
                          </div>
                        </div>
                      </div>
						  
                     
                    </div>
					  
					 <div class="row"> 
					
						   <div class="col-md-6">
                        <div class="form-group row">
                          <label for="product_picurl" class="col-sm-3 col-form-label">@lang('dingsu.image')</label>
                          <div class="col-sm-9">
                            <input id="product_picurl" name="product_picurl" class="form-control" type="text" value="{{ old('product_picurl', $record->product_picurl) }}" >
							  
							  <img src="{{ $record->product_picurl }}" width="300px">
							  
                          </div>
                        </div>
                      </div>
						   
						 <div class="col-md-6">
                        <div class="form-group row">
                          <label for="product_image" class="col-sm-3 col-form-label">@lang('dingsu.image')</label>
                          <div class="col-sm-9">
                            {!! Form::file('product_image', array('class' => 'image')) !!}
							  
							  @if($record->product_image)
							  <a href="javascript:void(0)" onClick="confirm_Delete({{ $record->id }})" class="imga btn btn-icons btn-rounded btn-outline-danger btn-inverse-danger"><i class=" icon-close  "></i></a>
							  
							  <div class="imgdiv" style="width: 200px; height: 180px">
							 
							  <img src="{{ Config::get('app.ads_product_image_url') . $record->product_image }}" width="300px" height="350px"></img>
							  
							  </div>
							 @endif 
							  
							  
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
                              
							 <option {{old('status',$record->product_status)=="0"? 'selected':''}}  value="0" >@lang('dingsu.active')</option>
							 <option {{old('status',$record->product_status)=="1"? 'selected':''}}  value="1" >@lang('dingsu.inactive')</option>
							 <option {{old('status',$record->product_status)=="2"? 'selected':''}}  value="2" >@lang('dingsu.reserved')</option>
								
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


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.26.11/sweetalert2.min.css"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.26.11/sweetalert2.all.min.js"></script>

<script language="javascript">
	

	function confirm_Delete( id ) {
		Swal( {
			title: '@lang("dingsu.delete_confirmation")',
			text: '@lang("dingsu.delete_conf_text")',
			type: 'warning',
			showCancelButton: true,
			confirmButtonText: '@lang("dingsu.delete")',
			cancelButtonText: '@lang("dingsu.cancel")',
			confirmButtonColor: "#DD6B55",
			closeOnConfirm: false
		} ).then( ( result ) => {
			if ( result.value ) {

				$.ajax( {
					url: '{{route('ad.remove.image')}}',
					headers: {
						'X-CSRF-TOKEN': $( 'meta[name="csrf-token"]' ).attr( 'content' )
					},
					type: 'delete',
					data: {
						id: id,
						_token: "{{ csrf_token() }}",
					},
					dataType: "html",
					success: function ( response ) {

						var response = jQuery.parseJSON( response );
						if ( response.success == false ) {
							swal( '@lang("dingsu.delete_error")', '@lang("dingsu.try_again")', "error" );
						} else {
							
							swal({  icon: 'success',  title: '@lang("dingsu.done")!',text: '@lang("dingsu.delete_success")', button: '@lang("dingsu.okay")',});
						
							$( '.imgdiv' ).remove();
							$( '.imga' ).remove();
						}

					},
					error: function ( xhr, ajaxOptions, thrownError ) {
						swal( '@lang("dingsu.delete_error")', '@lang("dingsu.try_again")', "error" );
					}
				} );

			}
		} )
	}

</script>