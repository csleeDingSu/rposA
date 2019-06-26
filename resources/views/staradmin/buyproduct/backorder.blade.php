<div class="col-12 grid-margin">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">@lang('dingsu.add') @lang('dingsu.basic') @lang('dingsu.package') @lang('dingsu.back')@lang('dingsu.order')</h4>
                  <form class="form-sample" action="" method="post" autocomplete="off" name="backorder" id="backorder">
					  
					  {{ csrf_field() }}
					  
					  <div class="" id="validation-errors"></div>					  
					  
					  <div class="row">
						
                      <div class="col-md-6">
                        <div class="form-group row"> 
						  <label for="phone" class="col-sm-3 col-form-label">@lang('dingsu.phone')</label>
                          <div class="col-sm-9">
                            <input id="phone" name="phone" class="form-control" type="text" autofocus required value="{{ old('phone')}}">
                          </div>
                        </div>
                      </div>
					  <div class="col-md-6">
                        <div class="form-group row"> 
							
							<div class="input-group ">
								<label for="package" class="col-sm-3 col-form-label">@lang('dingsu.package')</label>
                            <div class="input-group-prepend bg-info">
                              <span class="input-group-text bg-transparent" id="viewproduct">
                                <i class="fa fa-eye text-white"></i>
                              </span>
                            </div>
                            <select id="package" name="package" class="form-control ">
								  <option value="" selected="selected">@lang('dingsu.default_option')</option>
								  @foreach($package as $basic)
									<option data-val="{{ $basic}}" value="{{ $basic->id }}">{{ $basic->package_name }}</option>
								  @endforeach
							   </select>
                          </div>
							
                        </div>
                      </div>	  
                     
                    </div>
					  
					  
					  <div class="row"> 						
						<div class="col-md-6">
                        <div class="form-group row">
                          <label for="bo_price" class="col-sm-3 col-form-label">@lang('dingsu.discount_price')</label>
                          <div class="col-sm-9">
                            <input id="bo_price" name="bo_price" class="form-control" type="text" value="{{ old('bo_price') }}"  maxlength="10">
                          </div>
                        </div>
                      </div>
                    
                    </div>
					  
                    <button type="submit" class="btn btn-success mr-2">@lang('dingsu.submit')</button>
					  <a href="" class="btn btn-light mr-2">@lang('dingsu.reset')</a>
                    
                  </form>
              </div>
            </div>
	
	
	
<!-- Modal starts -->
	<div class="modal fade" id="ViewProduct" tabindex="-1" role="dialog" aria-labelledby="ViewProductlabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="editmodelabel">@lang('dingsu.basic')@lang('dingsu.package') @lang('dingsu.detail')</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>				
				</div>
				<div class="modal-body">
					
					<div class="row">
						<div class="col-md-6">
							<div class="form-group row">
								<label for="package_name" class="col-sm-3 col-form-label">@lang('dingsu.name')</label>
								<div class="col-sm-9">
									<input id="package_name" name="package_name" class="form-control" type="text" disabled value="{{ old('package_name')}}" >
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group row">
								<label for="price" class="col-sm-3 col-form-label">@lang('dingsu.package') @lang('dingsu.vip_price')</label>
								<div class="col-sm-9">
									<input id="price" name="price" class="form-control" type="text" value="{{ old('price')}}" disabled maxlength="5"> 
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group row">
								<label for="min_point" class="col-sm-3 col-form-label">@lang('dingsu.vip_consumed_point') </label>
								<div class="col-sm-9">
									<input id="min_point" name="min_point" class="form-control" type="text" value="{{ old('min_point')}}" disabled maxlength="10">
								</div>
							</div>
						</div>
						
						<div class="col-md-6">
							<div class="form-group row">
								<label for="discount_price" class="col-sm-3 col-form-label">@lang('dingsu.discount_price')</label>
								<div class="col-sm-9">
									<input id="discount_price" name="discount_price" class="form-control" type="text" value="{{ old('discount_price')}}" disabled maxlength="5"> 
								</div>
							</div>
						</div>
						
						
						
					</div>
					
					<div class="row">
						<div class="col-md-6">
							<div class="form-group row">
								<label for="package_life" class="col-sm-3 col-form-label">@lang('dingsu.vip_convertible_life') </label>
								<div class="col-sm-9">
									<input id="package_life" name="," class="form-control" type="text" value="{{ old('package_life')}}" disabled maxlength="3">
								</div>
							</div>
						</div>
						
						<div class="col-md-6">
							<div class="form-group row">
								<label for="package_freepoint" class="col-sm-3 col-form-label">@lang('dingsu.vip_convertible_point')  </label>
								<div class="col-sm-9">
									<input id="package_freepoint" name="package_freepoint" class="form-control" type="text" value="{{ old('package_freepoint')}}"  maxlength="10" disabled>
								</div>
							</div>
						</div>
						
					</div>
					
					<div class="row">
						
						<div class="col-md-6">
							<div class="form-group row">
								<label for="package_description" class="col-sm-3 col-form-label">@lang('dingsu.description')  </label>
								<div class="col-sm-9">
									<textarea class="form-control" id="package_description" name="package_description" disabled>{{ old('package_description')}}</textarea>
									
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group row">
								<label for="status" class="col-sm-3 col-form-label">@lang('dingsu.status')  </label>
								<div class="col-sm-9">
									 <select id="status" name="status" class="form-control"  disabled>
									  <option value="1">@lang('dingsu.active')</option>
									  <option value="2">@lang('dingsu.inactive')</option>
									</select>									
								</div>
							</div>
						</div>
						
					</div>
					
					
					
				</div>
				
			</div>
		</div>
	</div>
<!-- Modal Ends -->
<script language="javascript">
	
	$("#backorder").submit(function(event){
		event.preventDefault(); 
				
		$( '#validation-errors' ).html( '' );
		swal( {
			title: '@lang("dingsu.please_wait")',
			text: '@lang("dingsu.updating_data")..',
			allowOutsideClick: false,
			closeOnEsc: false,
			allowEnterKey: false,
			buttons: false,
			onOpen: () => {
				swal.showLoading()
			}
		} )
		$.ajax( {
			url: "{{route('store_basicpackage_backorder')}}",
			type: 'post',
			dataType: "json",
			data: {
				_token: "{{ csrf_token() }}",
				phone: $( "#phone" ).val(),
				package: $( "#package" ).val(),
				discount_price: $( "#bo_price" ).val(),
				
			},
			success: function ( result ) {
				if ( result.success != true ) {
					$.each( result.message, function ( key, value ) {
						$( '#validation-errors' ).append( '<div class="alert alert-danger">' + value + '</div' );
					} );
					swal.close()
				} else {
					swal({  icon: 'success',  title: '@lang("dingsu.done")!',text: '@lang("dingsu.update_success_msg")', button: '@lang("dingsu.okay")',});
					$( "input[type=text], textarea" ).val( "" );
					$('#package').val('')
					
				}
			},
			error: function ( xhr, ajaxOptions, thrownError ) {
				swal.close();
				$.each( xhr.responseJSON.errors, function ( key, value ) {
						$( '#validation-errors' ).append( '<div class="alert alert-danger">' + value + '</div' );
					} );
					swal.close();
			}
		} );
	} );
	
	
	
	$( "#viewproduct" ).click(function() {
	//$(".datalist").on("click",".ViewProduct", function() {
		//$('#ViewProduct').modal('show');
		var selected   = $("#package").find(':selected').attr('data-val')
		
		if (selected)
			{
				//alert('se');
				console.log(selected);
				var obj = jQuery.parseJSON( selected );
				//alert(obj.id);
				$("#package_name").val(obj.package_name);
				$("#price").val(obj.package_price);
				$("#min_point").val(obj.min_point);
				$("#package_description").val(obj.package_description);
				$("#package_life").val(obj.package_life);
				$("#package_freepoint").val(obj.package_freepoint);
				$("#status").val(obj.status);
				$("#discount_price").val(obj.package_discount_price);
				
				//,,,,,,
				
				//alert(obj.discount_price);
			}
		
			
		//$('.playedmemberlist').html(data);
		$('#ViewProduct').modal('show');
		
				
	});
		
		
		
	</script>