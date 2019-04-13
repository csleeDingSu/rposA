 <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <style>
        .progress { position:relative; width:100%; border: 1px solid #7F98B2; padding: 1px; border-radius: 3px; }
        .bar { background-color: #B4F5B4; width:0%; height:25px; border-radius: 3px; }
        .percent { position:absolute; display:inline-block; top:3px; left:48%; color: #7F98B2;}
    </style>


<div class="col-12 grid-margin">
	<div class="card">
		<div class="card-body">
			<h4 class="card-title">@lang('dingsu.import_voucher')</h4>
			
			<form method="POST" name="importform" id="importform"  class="form-horizontal" action="" enctype="multipart/form-data">
                @csrf
				<div class="" id="validation-errors"></div>
                <div class="form-group">
                    <input name="voucher_file" id="voucher_file" type="file" value="123456" class="form-control"><br/>
                    
                    <input type="submit" id="btnupload" value="@lang('dingsu.upload')" class="btn btn-success">
                </div>
            </form>  
		</div>
	</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
 
    
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.26.11/dist/sweetalert2.all.min.js"></script>


 <script>
	function validate(formData, jqForm, options) {
        var form = jqForm[0];
        if (!form.file.value) {
            alert('File not found');
            return false;
        }
    }
	 $("#importform").on('submit',(function(e) {
		 e.preventDefault();
		var formData = new FormData();
		formData.append('file', $('input[type=file]')[0].files[0]);
		 
		$( '#validation-errors' ).html( '' );
			
		 	swal( {
				title: '@lang("dingsu.please_wait")',
				text: '@lang("dingsu.uploading_data")..',
				allowOutsideClick: false,
				closeOnEsc: false,
				allowEnterKey: false,
				buttons: false,
				onOpen: () => {
					swal.showLoading()
				}
			} )
			$.ajax( {
				url: "{{ route('importpost') }}",
				data: formData,
				type: 'post', 
				contentType: false, 
    			processData: false, 
				dataType: "json",
				
				success: function ( result ) {
					swal( '@lang("dingsu.success")', '@lang("dingsu.upload_success")', "success" );$('#importform').trigger("reset");
					$( '#validation-errors' ).append( '<div class="alert alert-success">' + result.success + '</div' );
				},
				error: function ( xhr, ajaxOptions, thrownError ) {
					$.each(xhr.responseJSON.errors, function(key,value) {
						$( '#validation-errors' ).append( '<div class="alert alert-danger">' + value + '</div' );
					} );
					swal.close();$('#importform').trigger("reset");
				}
			} );
		
	 }));
	 
</script>
