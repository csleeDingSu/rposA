
<section class="filter">
	@include('receipt.filter')
</section>

<section class="datalist">
	@include('receipt.ajaxlist')
</section>

<section class="models text-capitalize modellist">
	@include('receipt.model')
</section>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.26.11/sweetalert2.min.css"/>

@section('bottom_js')
@parent

<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.26.11/sweetalert2.all.min.js"></script>

<script language="javascript">

//edit 
	$('#formedit').on('submit', function(event){
		event.preventDefault();
		$('.inputTxtError').remove();
		show_wait('update');				
		var formData = new FormData();		
		$.ajax( {
				url: "{{route('receipt_update')}}",
				dataType: 'json',
				cache: false,
				contentType: false,
				processData: false,
				type: 'POST', 
				data:new FormData(this),
				cache : false, 
				processData: false,
				success: function ( result ) {
					console.log('imhere');
					if ( result.success == true ) {
						swal.close();
						$( '#openmodel' ).modal( 'hide' );			
						var data = result.record;
						swal({ icon: "success",  type: 'success',  title: '@lang("dingsu.done")!',text: '@lang("dingsu.update_success_msg")', confirmButtonText: '@lang("dingsu.okay")'});						
						$('#tr_' + result.id).replaceWith(data);
					} else {						
						swal( '@lang("dingsu.no_record_found")', '@lang("dingsu.try_again")', "error" );
					}
										
				},
				error: function ( xhr, ajaxOptions, thrownError ) {
					swal.close();			
					displayFieldErrors(xhr.responseJSON.errors,xhr.status);	
				}
			} );
		
	});
//get receipt details	
	$(".datalist").on("click",".editrow", function(){
			var id=$(this).data('id');
			$('.inputTxtError').remove();
			show_wait('fetch');
			
			$.ajax( {
				url: "{{route('receipt_get')}}",
				type: 'get',
				dataType: "json",
				data: {
					_method: 'get',
					_token: "{{ csrf_token() }}",
					id:  id,
				},
				success: function ( result ) {
					if ( result.success == true ) {
						swal.close();
						var data = result.record;						
						if (data != null)
							{
								$('.renderdata').html(data);
								$('#openmodel').modal('show');
							}
						else 
							{
								swal( '@lang("dingsu.no_record_found")', '@lang("dingsu.try_again")', "error" );
							}						
					} else {						
						swal( '@lang("dingsu.no_record_found")', '@lang("dingsu.try_again")', "error" );
					}
				},
				error: function ( xhr, ajaxOptions, thrownError ) {
					swal( '@lang("dingsu.error")', '@lang("dingsu.try_again")', "error" );
				}
			} );
		});	

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
		
		
			$(document).ready(function() {								
				var wes  = "{{ app('request')->input('wechat') }}";
				var west = wes.trim();
				if (west == 12)
				{
					$("#s_wechatstatus").val("1");
					getdatalist('');
				}							
			});

            function getdatalist(url) {				
				if (!url) {
					var url = "" ;	
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
					data: {_method: 'delete', _token :"{{ csrf_token() }}",_data:$("#searchform").serialize()},
                }).done(function (data) {
					$('.datalist').html(data);
					swal.close();
                }).fail(function () {
                    alert('datalist could not be loaded.');
					swal.close();
                });
            }
</script>





    @endsection 