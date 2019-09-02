<!-- Modal starts -->
<form class="form-sample" name="formadd" id="formadd" action="" method="post" autocomplete="on" enctype="multipart/form-data">
	<div class="modal fade" id="openaddmodel" tabindex="-1" role="dialog" aria-labelledby="openaddmodellabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="editmodelabel">@lang('dingsu.add') @lang('dingsu.product')</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>				
				</div>
				<div class="modal-body">
					<div class="" id="validation-errors"></div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group row">
								<label for="name" class="col-sm-3 col-form-label">@lang('dingsu.name') <span class="text-danger">*</span></label>
								<div class="col-sm-9">
									<input id="name" name="name" class="form-control" type="text" autofocus value="{{ old('name')}}" >
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group row">
								<label for="available_quantity" class="col-sm-3 col-form-label">@lang('dingsu.available_quantity') <span class="text-danger">*</span></label>
								<div class="col-sm-9">
									<input id="available_quantity" name="available_quantity" class="form-control" type="text" autofocus value="{{ old('available_quantity')}}" >
								</div>
							</div>
						</div>
						
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group row">
								<label for="price" class="col-sm-3 col-form-label">@lang('dingsu.price') <span class="text-danger">*</span></label>
								<div class="col-sm-9">
									<input id="price" name="price" class="form-control" type="text" value="{{ old('price')}}"  maxlength="5"> 
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group row">
								<label for="point_to_redeem" class="col-sm-3 col-form-label">@lang('dingsu.buy_price')  <span class="text-danger">*</span></label>
								<div class="col-sm-9">
									<input id="point_to_redeem" name="point_to_redeem" class="form-control" type="text" value="{{ old('point_to_redeem')}}"  maxlength="10">
								</div>
							</div>
						</div>
						
						
						
					</div>
					
					
					<div class="row">
						<div class="col-md-6">
							<div class="form-group row">
								<label for="discount_price" class="col-sm-3 col-form-label">@lang('dingsu.discount_price') <span class="text-danger">*</span></label>
								<div class="col-sm-9">
									<input id="discount_price" name="discount_price" class="form-control" type="text" value="{{ old('discount_price')}}"  maxlength="5"> 
								</div>
							</div>
						</div>
						
						
						<div class="col-md-6">
							<div class="form-group row">
								<label for="status" class="col-sm-3 col-form-label">@lang('dingsu.status')  </label>
								<div class="col-sm-9">
									 <select id="status" name="status" class="form-control">
									  <option value="1">@lang('dingsu.active')</option>
									  <option value="2">@lang('dingsu.inactive')</option>
									</select>									
								</div>
							</div>
						</div>
						
					</div>
					
					<div class="row">
						
						
						<div class="col-md-6">
							<div class="form-group row">
								<label for="type" class="col-sm-3 col-form-label">@lang('dingsu.type')  </label>
								<div class="col-sm-9">
									 <select id="type" name="type" class="form-control">
									  <option value="1">@lang('dingsu.virtual_card')</option>
									  <option value="2">@lang('dingsu.product')</option>
									</select>									
								</div>
							</div>
						</div>
						
					</div>
					
					
					<div class="row">
						
						<div class="col-md-6">
							<div class="form-group row">
								<label for="picture_url" class="col-sm-3 col-form-label">@lang('dingsu.vip_package_image_url')  <span class="text-danger">*</span></label>
								<div class="col-sm-9">
									<input id="picture_url" name="picture_url" class="form-control" type="text"  value="{{ old('picture_url')}}" >
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group row">
								<label for="description" class="col-sm-3 col-form-label">@lang('dingsu.description')  </label>
								<div class="col-sm-9">
									<textarea class="form-control" id="description" name="description" >{{ old('description')}}</textarea>
									
								</div>
							</div>
						</div>
						
					</div>
					
					
					<div class="row">
						<div class="col-md-6">
							<div class="form-group row">
								<label for="product_image" class="col-sm-3 col-form-label">@lang('dingsu.image') <span class="text-danger">*</span></label>
								<div class="col-sm-9">
									<input id="product_image" name="product_image" class="form-control" type="file" >
									
									<a href="javascript:void(0)" data-id = "" class="imga btn btn-icons btn-rounded btn-outline-danger btn-inverse-danger"><i class=" icon-close  "></i></a>
							  
									  <div class="imgdiv" style="width: 200px; height: 180px">
									  <img src="" width="300px" height="280px"></img>

									  </div>
								
								
								</div>
							</div>
							
						</div>
					
					<div class="col-md-6">
							<div class="form-group row">
								<label for="seq" class="col-sm-3 col-form-label">@lang('dingsu.seq')  </label>
								<div class="col-sm-9">
									<input id="seq" name="seq" class="form-control" type="text" value=""  maxlength="5"> 
									
								</div>
							</div>
						</div>
						
					</div>
					
					
					
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-success" id="savebtn" >@lang('dingsu.add')</button>
					<button type="button" class="btn btn-dark" data-dismiss="modal">@lang('dingsu.cancel')</button>
				</div>
				<input type="hidden" name="hidden_void" id="hidden_void" value="">
				<input type="hidden" name="mode" id="mode" value="create">
			</div>
		</div>
	</div>
</form>
<!-- Modal Ends -->

<!--Quantity Modal starts -->
<form class="form-sample" name="formtopup" id="formtopup" action="" method="post" autocomplete="on">
	<div class="modal fade" id="topupmode" tabindex="-1" role="dialog" aria-labelledby="topupmode" aria-hidden="true">
		<div class="modal-dialog modal-md" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">@lang('dingsu.add') @lang('dingsu.quantity') </h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>				
				</div>
				<div class="modal-body">
					<div class="" id="rvalidation-errors"></div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group row">
								<label for="cquantity" class="col-sm-6 col-form-label">@lang('dingsu.current') @lang('dingsu.quantity') <span class="text-danger">*</span></label>
								<div class="col-sm-6">
									<input type="text" readonly class="form-control" name="cquantity" id="cquantity" value="" maxlength="50">
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group row">
								<label for="add_quantity" class="col-sm-6 col-form-label">@lang('dingsu.add') @lang('dingsu.quantity')<span class="text-danger">*</span></label>
								<div class="col-sm-6">
									<input type="text" class="form-control" name="add_quantity" id="add_quantity" value="" maxlength="50">
								</div>
							</div>
						</div>
					</div>
					
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-success" onclick="return updatequantity();return false;">@lang('dingsu.submit')</button>
					<button type="button" class="btn btn-dark" data-dismiss="modal">@lang('dingsu.cancel')</button>
				</div>
				<input type="hidden" name="tid" id="tid" value="">
			</div>
		</div>
	</div>
</form>
<!-- Modal Ends -->






