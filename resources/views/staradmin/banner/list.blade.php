<div class="col-12 d-flex  text-right">
	<a onClick="return openmodel();return false;" href="javascript:void(0)" class="btn btn-success mr-2">@lang('dingsu.add')</a>
</div>

<div class="clearfix">&nbsp;</div>
<section class="filter">
	@include('banner.filter')
</section>

<section class="datalist">
	@include('banner.ajaxlist')
</section>

<!-- Modal starts -->
<form class="form-sample" name="formbanner" id="formbanner" action="" method="post" autocomplete="on" enctype="multipart/form-data">
	<div class="modal fade" id="openeditmodel" tabindex="-1" role="dialog" aria-labelledby="openeditmodellabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="editvouchermodelabel">@lang('dingsu.edit') @lang('dingsu.banner')</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>				
				</div>
				<div class="modal-body">
					<div class="" id="validation-errors"></div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group row">
								<label for="status" class="col-sm-3 col-form-label">@lang('dingsu.status') <span class="text-danger">*</span></label>
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
								<label for="banner_image" class="col-sm-3 col-form-label">@lang('dingsu.image') <span class="text-danger">*</span></label>
								<div class="col-sm-9">
									<input id="banner_image" name="banner_image" class="form-control" type="file" >
							 		
									
									<a href="javascript:void(0)" data-id = "" class="imga btn btn-icons btn-rounded btn-outline-danger btn-inverse-danger"><i class=" icon-close  "></i></a>
							  
									  <div class="imgdiv" style="width: 200px; height: 180px">
									  <img src="" width="300px" height="280px"></img>

									  </div>
								
								
								</div>
							</div>
							
						</div>
						
					</div>
					
					
				</div>
				<div class="modal-footer">
					<button type="submit" id="savebtn" class="btn btn-success savebtn">@lang('dingsu.add')</button>
					<button type="button" class="btn btn-dark" data-dismiss="modal">@lang('dingsu.cancel')</button>
				</div>
				<input type="hidden" name="hidden_void" id="hidden_void" value="">
				<input type="hidden" name="mode" id="mode" value="create">
			</div>
		</div>
	</div>
</form>
<!-- Modal Ends -->

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.26.11/sweetalert2.min.css"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.26.11/sweetalert2.all.min.js"></script>

<script language="javascript">
	function openmodel() {
		$("#savebtn").html('@lang("dingsu.add")');
		$('#formbanner')[0].reset();
		$('#mode').val('create');
		
		$('.imga, .imgdiv').hide();
		
		
		$( '#openeditmodel' ).modal( 'show' );
	}
	
	$("#formbanner").on("click",".imga", function() {
		var id=$(this).data('id');
		$.ajax( {
				url: "{{route('banner.remove.image')}}",
				type: 'delete',
				dataType: "json",
				data: {
					_method: 'delete',
					_token: "{{ csrf_token() }}",
					id:  id,
				},
				success: function ( result ) {
					if ( result.success == true ) {
						swal.close();
						
						if (result.success = true)
							{
								$('.imga, .imgdiv').hide();
								
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
	
	$(".listtable").on("click",".editbanner", function(){
			var id=$(this).data('id');
		$('#formbanner')[0].reset();
		$( '#validation-errors' ).html( '' );
			swal( {
				title: '@lang("dingsu.please_wait")',
				text: '@lang("dingsu.fetching_data")..',
				allowOutsideClick: false,
				closeOnEsc: false,
				allowEnterKey: false,
				buttons: false,
				onOpen: () => {
					swal.showLoading()
				}
			} )
			$.ajax( {
				url: "{{route('banner.get')}}",
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
								
								$('#mode').val('edit');
								$('#status').val(data.is_status);
								
								$('#hidden_void').val(id);
																
								var appUrl ="{{url('/')}}"+'/ad/banner/'+data.banner_image;
								
								$('.imga').data("id", id);
								$('.imgdiv img').attr('src', appUrl);
								$('.imga, .imgdiv').hide();				
								if (data.banner_image)	{ 
									$('.imga, .imgdiv').show();									
								}
								
								$("#savebtn").html('@lang("dingsu.update")');
								
								$('#openeditmodel').modal('show');
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

	
	
	$('#formbanner').on('submit', function(event){
  		event.preventDefault();
	
		
		var datav = $( "#formbanner" ).serializeArray();
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
		} );
		
		
		
		var id = $('#hidden_void').val();
		var image = $('#banner_image')[0].files[0];
		var formData = new FormData();
		
		formData.append('id', id);
		formData.append('status', $('#status').val());
		formData.append('image', image);
		formData.append('_token', "{{ csrf_token() }}");
		
		
		$.ajax( {
			 headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }, 
            url: "{{route('banner.create')}}",
			dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST', 
            data:new FormData(this),
            cache : false, 
            processData: false, 
			success: function ( result ) {
				console.log(result);console.log(result.success);
				if ( result.success != true ) {
						
					$.each( result.message, function ( key, value ) {
						$( '#validation-errors' ).append( '<div class="alert alert-danger">' + value + '</div' );
					} );
					swal.close()
				} else {
					if (result.mode == 'edit')
					{
						var data = result.dataval; 
						swal({  icon: 'success',  title: '@lang("dingsu.done")!',text: '@lang("dingsu.banner_update_success_msg")', button: '@lang("dingsu.okay")',});
						
						
						var id = $('#hidden_void').val();
						$('#st_'+id).html(data.title);
						$('#sc_'+id).html(data.content);
						$('#ss_'+id).html(data.seq);
						
						
						var appUrl ="{{url('/')}}"+'/ad/banner/'+data.banner_image;
								
						$('.bannerimg_'+id).attr('src', appUrl);
						
						
						
					}
					else
					{
						swal({  icon: 'success',  title: '@lang("dingsu.done")!',text: '@lang("dingsu.banner_added_success_msg")', button: '@lang("dingsu.okay")',});
						
						
						$( '#listtable tr:first' ).after( result.record );
						
					
						
					}
					
					$( "input[type=text], textarea" ).val( "" );
					$( '#openeditmodel' ).modal( 'hide' );
					
				}
			},
			error: function ( xhr, ajaxOptions, thrownError ) {
				swal( '@lang("dingsu.error")', '@lang("dingsu.try_again")', "error" );
			}
		} );
		
		
	} );


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
					url: '{{route('banner.remove')}}',
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
						

							$( '#tr_' + id ).hide();
						}

					},
					error: function ( xhr, ajaxOptions, thrownError ) {
						swal( '@lang("dingsu.delete_error")', '@lang("dingsu.try_again")', "error" );
					}
				} );

			}
		} )
	}


	$( function () {


		$( ".filter" ).on( "click", ".search", function ( e ) {
			e.preventDefault();
			getdatalist( '' );

		} );

		$( ".filter" ).on( "click", "#reset_search", function ( e ) {
			e.preventDefault();
			$( '#searchform' )[ 0 ].reset();
			getdatalist( '' );
		} );


		$( 'body' ).on( 'click', '.pagination a', function ( e ) {
			e.preventDefault();
			var url = $( this ).attr( 'href' );
			getdatalist( url );

		} );

		function getdatalist( url ) {
			if ( !url ) {
				var url = "{{route('banner.list')}}";
			}
			window.history.pushState( "", "", url );

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
				url: url,
				data: {
					_method: 'get',
					_token: "{{ csrf_token() }}",
					_data: $( "#searchform" ).serialize()
				},
			} ).done( function ( data ) {
				$( '.datalist' ).html( data );
				swal.close();
			} ).fail( function () {
				alert( 'datalist could not be loaded.' );
				swal.close();
			} );
		}
	} );
</script>