<section class="datalist">
	@include('voucher.ajaxvsettinglist')
</section>



<!-- modal start -->
<form class="form-sample" name="insert_form" id="insert_form" action="" method="post" autocomplete="on" >
<div class="modal fade" id="add_cate" 
     tabindex="-1" role="dialog" 
     aria-labelledby="favoritesModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="subcate_ModalLabel">@lang('dingsu.add')</h4>
            <button type="button" class="close" 
            data-dismiss="modal" 
            aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
        <div class="row">
            <div class="col-md-9">
                <div class="form-group row">
                <label for="category" class="col-sm-3 col-form-label">@lang('dingsu.category')</label>
                <div class="col-sm-9">

                    <input id="display_name" name="display_name" class="form-control" type="text" value=""  maxlength="5">	
					<input type="hidden" name="parent_id" id="parent_id" value="0">
                </div>
                </div>
            </div>
        </div>
      </div>
      <div class="modal-footer">
					<button type="button" class="btn btn-success" onclick="return Update_cate();return false;">@lang('dingsu.submit')</button>
					<button type="button" class="btn btn-dark" data-dismiss="modal">@lang('dingsu.cancel')</button>
				</div>
    </div>
  </div>
</div>
</form>







<script>
function Update_cate()
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
					url: "{{route('voucher.add_cate')}}",
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
              $('#add_cate').modal('hide');
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
function deletecategory(id){


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
				url: "/voucher/setting/category/delete/" + id,
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