<div class="col-12 grid-margin">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">@lang('dingsu.category_setting')</h4>
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
					  
					  
					  

          <form class="form-sample" action="" method="post" autocomplete="on">
					  
					  <div class="row"> 
                <div class="col-md-6">
                  <div class="form-group row">
                    <label for="category" class="col-sm-3 col-form-label">@lang('dingsu.category')</label>
                      <div class="col-sm-9">
                        <input id="category" name="category" class="form-control" type="text"  value="{{$category->display_name}}">
                      </div>
                  </div>
                </div>
                <div>
                    <button type="submit" class="btn btn-success">@lang('dingsu.submit')</button>
                </div>
              </div>
          </form>

					  
                    <h5 class="my-4">@lang('dingsu.sub_category')</h5>
                    <div class="row">
                        <div id="subcate_table" class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>@lang('dingsu.number')</th>
                                        <th>@lang('dingsu.sub_category')</th>
                                    </tr>
                                    <button type="button" class="btn btn-inverse-info" data-toggle="modal" data-target="#add_subcate">@lang('dingsu.add')</button>
                                </thead>
                                <tbody>
                                    @foreach($sub_category as $key=>$sub)
                                    <tr id="tr_{{ $key+1 }}">
                                        <td width ="10" >{{ $key+1 }}</td>
                                        <td width ="10" >{{ $sub->display_name }}</td>
                                        <td>
                                          <a onClick="return deletesubcategory({{$sub->id}})"  href="javascript:void(0)" class="btn btn-icons btn-rounded btn-outline-danger btn-inverse-danger"><i class=" icon-trash  "></i></a>
                                        </td>
                                    </tr>
                                    
                                    @endforeach
                                </tbody>
                            </table>
                                             <a href="/voucher/setting" type="" class="btn btn-light mr-2">@lang('dingsu.back')</a>

                        </div>
                    
                  </form>
                </div>
              </div>
            </div>


<!-- modal start -->
<form class="form-sample" name="insert_form" id="insert_form" action="" method="post" autocomplete="on" >
<div class="modal fade" id="add_subcate" 
     tabindex="-1" role="dialog" 
     aria-labelledby="favoritesModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
      <h4 class="modal-title" id="subcate_ModalLabel">{{$category->display_name}}</h4>
        <h4 class="modal-title" id="subcate_ModalLabel">-@lang('dingsu.add')@lang('dingsu.sub_cate')</h4>
            <button type="button" class="close" 
            data-dismiss="modal" 
            aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
        <div class="row">
            <div class="col-md-9">
                <div class="form-group row">
                <label for="sub_cate" class="col-sm-3 col-form-label">@lang('dingsu.sub_cate')</label>
                <div class="col-sm-9">

                    <input id="display_name" name="display_name" class="form-control" type="text" value=""  maxlength="5">	
                    <input type="hidden" name="parent_id" id="parent_id" value="{{$category->id}}">
                </div>
                </div>
            </div>
        </div>
      </div>
      <div class="modal-footer">
					<button type="button" class="btn btn-success" onclick="return Update_subcate();return false;">@lang('dingsu.submit')</button>
					<button type="button" class="btn btn-dark" data-dismiss="modal">@lang('dingsu.cancel')</button>
				</div>
    </div>
  </div>
</div>
</form>





 <script>
function Update_subcate()
{
  var datav =  $("#insert_form").serializeArray();
	swal( {
		title: '@lang("dingsu.edit_confirmation")',
		text: '@lang("dingsu.edit_conf_text")',
		icon: "warning",
		closeModal: false,
		buttons: [
			'@lang("dingsu.cancel")',
			'@lang("dingsu.update")'
		],

		allowOutsideClick: false,
		closeOnEsc: false,
		allowEnterKey: false

	} ).then(
		function ( preConfirm ) {
			if ( preConfirm ) {
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
					url: "{{route('voucher.add_subcate')}}",
					type: 'post',
					dataType: "json",
					data: {
						_method: 'post',
						_token: "{{ csrf_token() }}",
						_data:datav,
						// _id:id,
					},
					success: function ( result ) {
						if ( result.success != true ) {
							swal( '@lang("dingsu.error")', '@lang("dingsu.try_again")', "error" );
						} else {
							swal( "Done!", '@lang("dingsu.voucher_update_success_message")', "success" );
              $('#add_subcate').modal('hide');
              $('#insert_form')[0].reset();

						}
					},
					error: function ( xhr, ajaxOptions, thrownError ) {
						swal( '@lang("dingsu.publish_error")', '@lang("dingsu.try_again")', "error" );
					}
				} );
			}
		} );
}

function deletesubcategory(id){


swal( {
	title: '@lang("dingsu.delete_confirmation")',
	text: '@lang("dingsu.delete_conf_text")',
	icon: "warning",
	closeModal: false,
	buttons: [
		'@lang("dingsu.cancel")',
		'@lang("dingsu.delete")'
	],

	allowOutsideClick: false,
	closeOnEsc: false,
	allowEnterKey: false

} ).then(
	function ( preConfirm ) {
		if ( preConfirm ) {
			swal( {
				title: '@lang("dingsu.please_wait")',
				text: '@lang("dingsu.deleting_data")..',
				allowOutsideClick: false,
				closeOnEsc: false,
				allowEnterKey: false,
				buttons: false,
				onOpen: () => {
					swal.showLoading()
				}
			} )
			$.ajax( {
				url: "/voucher/setting/category/delete_sub_category/" + id,
				type: 'delete',
				dataType: "html",
				data: {
					_method: 'delete',
					_token: "{{ csrf_token() }}",
				},
				success: function ( result ) {
					if ( result == false ) {
						swal( '@lang("dingsu.publish_error")', '@lang("dingsu.try_again")', "error" );
					} else {
						swal( "Done!", '@lang("dingsu.vouchers_deleted_success")', "success" );
						
						//$('#tr_'+id).hide(); 
						$('#divprolist_'+id ).remove();
						
						
						var $target = $( '.divprolist_' + id ).parents( 'li' );
						$target.hide( 'slow', function () {
							$target.remove();
						} );
						
						
					}
				},
				error: function ( xhr, ajaxOptions, thrownError ) {
					swal( '@lang("dingsu.publish_error")', '@lang("dingsu.try_again")', "error" );
				}
			} );
		}
	} );

}



 </script>