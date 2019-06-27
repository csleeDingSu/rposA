
<section class="filter">
@include('buyproduct.pendinglist.filter')
</section>

<section class="datalist">
@include('buyproduct.pendinglist.ajaxlist')
</section>

<section class="model">
</section>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.26.11/sweetalert2.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.26.11/sweetalert2.all.min.js"></script>


<script language="javascript">
	
function confirm_redeem_with_input(id)	{
	
	
	Swal({
	  title: '@lang("dingsu.reject_confirmation")',
	  text: '@lang("dingsu.reject_redeem_conf_text")',
	  type: 'warning',
	  showCancelButton: true,
	  confirmButtonText: '@lang("dingsu.confirm")',
	  cancelButtonText: '@lang("dingsu.cancel")',
	  closeOnConfirm: false,
	  input: 'text',		
  	  animation: "slide-from-top",
      inputPlaceholder: '@lang("dingsu.reject_notes")',
		showLoaderOnConfirm: true,
		inputValidator: (value) => {
			if (!value) {
			  return '@lang("dingsu.error_empty_note")'
			}
		  },
		input: 'text',		
  	  animation: "slide-from-top",
      inputPlaceholder: '@lang("dingsu.card_pass")',
		showLoaderOnConfirm: true,
		inputValidator: (value) => {
			if (!value) {
			  return '@lang("dingsu.error_empty_note")'
			}
		  },
		html:
    '<input id="card_num" name="card_num" class="swal2-input" placeholder="">' +
    '<input id="card_pass" name="card_pass" class="swal2-input">',
	}
		
		
		
		).then((result) => {
	  if (result.value) {
		   

		  $.ajax({
				url: '{{route('buyproduct_redeem_reject')}}',
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				
				type: 'post', 
				data: JSON.stringify({ id: id, _token:"{{ csrf_token() }}" ,'reason':result.value}), 
				dataType: "json",
				contentType: 'application/json; charset=utf-8',
				success: function (response) {

			  		if ( response.success == false ) 
						{
							swal({  icon: 'error',  title: '@lang("dingsu.reject_error")',text: '@lang("dingsu.try_again")', button: '@lang("dingsu.okay")',});
						}
					else 
						{
							swal({  icon: 'success',  title: '@lang("dingsu.done")!',text: '@lang("dingsu.reject_admin_success")', button: '@lang("dingsu.okay")',});

							var df = '<label class="badge badge-danger">@lang("dingsu.rejected")</label>';

							$('#statustd_'+id).html(df);
							$('#actiontd_'+id).html('');
						}

				},
				error: function (xhr, ajaxOptions, thrownError) {
					swal({  icon: 'error',  title: '@lang("dingsu.reject_error")',text: '@lang("dingsu.try_again")', button: '@lang("dingsu.okay")',});
				}
			});
	  } 
      else{
			swal({
        title: "<i>Title</i>", 
        html: 'A custom message.</br> jkldfjkjdklfjlk',

    });  
	  }
	})
}
	


	function bk_confirm_redeem(id)	{
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
			url: '{{route('buyproduct_redeem_confirm')}}',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			contentType: 'application/json; charset=utf-8',
			type: 'post',            
			data: JSON.stringify({ id: id, _token:"{{ csrf_token() }}" }), 
			dataType: "json",
			success: function (response) {

			if ( response.success == false ) 
			{
				swal({  icon: 'error',  title: '@lang("dingsu.redeem_error")',text: '@lang("dingsu.try_again")', button: '@lang("dingsu.okay")',});
			}
			else 
			{
				swal({  icon: 'success',  title: '@lang("dingsu.done")',text: '@lang("dingsu.redeem_admin_success")', button: '@lang("dingsu.okay")',});
				var df = '<label class="badge badge-success">@lang("dingsu.confirmed")</label>';
						
				$('#statustd_'+id).html(df);
				$('#actiontd_'+id).html('');
			}

		},
		error: function (xhr, ajaxOptions, thrownError) {
			swal({  icon: 'error',  title: '@lang("dingsu.redeem_error")',text: '@lang("dingsu.try_again")', button: '@lang("dingsu.okay")',});
		}
	});
	} 
	})
}
	
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
			url: '{{route('buyproduct_redeem_confirm')}}',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			contentType: 'application/json; charset=utf-8',
			type: 'post',            
			data: JSON.stringify({ id: id, _token:"{{ csrf_token() }}" }), 
			dataType: "json",
			success: function (response) {

			if ( response.success == false ) 
			{
				swal({  icon: 'error',  title: '@lang("dingsu.redeem_error")',text: '@lang("dingsu.try_again")', button: '@lang("dingsu.okay")',});
			}
			else 
			{
				swal({  icon: 'success',  title: '@lang("dingsu.done")',text: '@lang("dingsu.redeem_admin_success")', button: '@lang("dingsu.okay")',});
				var df = '<label class="badge badge-success">@lang("dingsu.confirmed")</label>';
						
				$('#statustd_'+id).html(df);
				$('#actiontd_'+id).html('');
			}

		},
		error: function (xhr, ajaxOptions, thrownError) {
			swal({  icon: 'error',  title: '@lang("dingsu.redeem_error")',text: '@lang("dingsu.try_again")', button: '@lang("dingsu.okay")',});
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
	  closeOnConfirm: false,
	  input: 'textarea',		
  	  animation: "slide-from-top",
      inputPlaceholder: '@lang("dingsu.reject_notes")',
		showLoaderOnConfirm: true,
		inputValidator: (value) => {
			if (!value) {
			  return '@lang("dingsu.error_empty_note")'
			}
		  }
	}
		
		
		
		).then((result) => {
	  if (result.value) {
		   

		  $.ajax({
				url: '{{route('buyproduct_redeem_reject')}}',
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				
				type: 'post', 
				data: JSON.stringify({ id: id, _token:"{{ csrf_token() }}" ,'reason':result.value}), 
				dataType: "json",
				contentType: 'application/json; charset=utf-8',
				success: function (response) {

			  		if ( response.success == false ) 
						{
							swal({  icon: 'error',  title: '@lang("dingsu.reject_error")',text: '@lang("dingsu.try_again")', button: '@lang("dingsu.okay")',});
						}
					else 
						{
							swal({  icon: 'success',  title: '@lang("dingsu.done")!',text: '@lang("dingsu.reject_admin_success")', button: '@lang("dingsu.okay")',});

							var df = '<label class="badge badge-danger">@lang("dingsu.rejected")</label>';

							$('#statustd_'+id).html(df);
							$('#actiontd_'+id).html('');
						}

				},
				error: function (xhr, ajaxOptions, thrownError) {
					swal({  icon: 'error',  title: '@lang("dingsu.reject_error")',text: '@lang("dingsu.try_again")', button: '@lang("dingsu.okay")',});
				}
			});
	  } 
      else{
			swal({
        title: "<i>Title</i>", 
        html: 'A custom message.</br> jkldfjkjdklfjlk',

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
					var url = "{{url()->current()}}";
					
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