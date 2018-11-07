
<section class="filter">
@include('product.redeem_filter')
</section>

<section class="datalist">
@include('product.redeem_ajaxlist')
</section>


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.26.11/sweetalert2.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.26.11/sweetalert2.all.min.js"></script>


<script language="javascript">
	
function confirm_redeem(id)	{
	Swal({
	title: '@lang("dingsu.redeem_confirmation")',
	text: '@lang("dingsu.redeem_conf_text")',
	type: 'warning',
	showCancelButton: true,
	confirmButtonText: '@lang("dingsu.confirm")',
	cancelButtonText: '@lang("dingsu.cancel")',
	closeOnConfirm: false
	}).then((result) => {
		if (result.value) 
		 {
			$.ajax({
			url: '{{route('pin.redeem.confirm')}}',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			//contentType: 'application/json; charset=utf-8',
			type: 'delete',            
			data: {
			id: id,
			_token: "{{ csrf_token() }}",
			},
			dataType: "html",
			success: function (response) {

			var response = jQuery.parseJSON( response );
			if ( response.success == false ) 
			{
				swal('@lang("dingsu.redeem_error")', '@lang("dingsu.try_again")', "error");
			}
			else 
			{
				swal("Done!", '@lang("dingsu.redeem_admin_success")', "success");

				var df = '<label class="badge badge-success">@lang("dingsu.confirmed")</label>';
						
				$('#statustd_'+id).html(df);
				$('#actiontd_'+id).html('');
			}

		},
		error: function (xhr, ajaxOptions, thrownError) {
		swal('@lang("dingsu.redeem_error")', '@lang("dingsu.try_again")', "error");
		}
	});
	} 
	})
}
	
function confirm_Delete(id)	{
	Swal({
	  title: '@lang("dingsu.reject_confirmation")',
	  text: '@lang("dingsu.reject_redeem_conf_text")',
	  type: 'warning',
	  showCancelButton: true,
	  confirmButtonText: '@lang("dingsu.reject")',
	  cancelButtonText: '@lang("dingsu.cancel")',
	  closeOnConfirm: false
	}).then((result) => {
	  if (result.value) {

		  $.ajax({
				url: '{{route('pin.redeem.reject')}}',
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				 //contentType: 'application/json; charset=utf-8',
				type: 'delete',            
				data: {
					id: id,
					_token: "{{ csrf_token() }}",
				},
				dataType: "html",
				success: function (response) {

					var response = jQuery.parseJSON( response );
					if ( response.success == false ) 
						{
							swal('@lang("dingsu.reject_error")', '@lang("dingsu.try_again")', "error");
						}
					else 
						{
							swal("Done!", '@lang("dingsu.reject_admin_success")', "success");

							var df = '<label class="badge badge-danger">@lang("dingsu.rejected")</label>';

							$('#statustd_'+id).html(df);
							$('#actiontd_'+id).html('');
						}

				},
				error: function (xhr, ajaxOptions, thrownError) {
					swal('@lang("dingsu.reject_error")', '@lang("dingsu.try_again")', "error");
				}
			});
	  } 
	})
}
	
	
$(function() {
		
		
			$(".filter").on("click",".search", function(e) {
				e.preventDefault();				
				 getdatalist('');			
				
			});
		
			$(".filter").on("click","#reset_search", function(e) {
				e.preventDefault();				
				$('#searchform')[0].reset();
				getdatalist('');	
			});
		
		
            $('body').on('click', '.pagination a', function(e) {
                e.preventDefault();               
                var url = $(this).attr('href');				
                getdatalist(url);
                
            });

            function getdatalist(url) {				
				if (!url) {
					//var url = "{{route('memberlist')}}" ;
					//var url = "{{url()->current()}}";
					var url = "{{route('redeem.pending.list')}}" ;
					
				}
				window.history.pushState("", "", url);
				
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
				
                $.ajax({
                    url : url,
					data: {_method: 'get', _token :"{{ csrf_token() }}",_data:$("#searchform").serialize()},
                }).done(function (data) {
					$('.datalist').html(data);
					swal.close();
                }).fail(function () {
                    alert('datalist could not be loaded.');
					swal.close();
                });
            }
        });	
</script>
