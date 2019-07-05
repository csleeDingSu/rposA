
<section class="filter">
@include('buyproduct.history.filter')
</section>

<section class="datalist">
@include('buyproduct.history.ajaxlist')
</section>

<section class="model">
</section>
@section('bottom_js')
    @parent
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.26.11/sweetalert2.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.26.11/sweetalert2.all.min.js"></script>
<script src="{{ asset('staradmin/js/tooltips.js') }}"></script>
<script src="{{ asset('staradmin/js/popover.js') }}"></script>

<script language="javascript">
	
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
@endsection
