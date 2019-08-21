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


<div class="col-12 grid-margin">
<div class="row">
	
	<div class="col-lg-12 grid-margin stretch-card">
		<div class="card">
			<div class="card-body">
				<h4 class="card-title">@lang('dingsu.cron_importprocess_file') @lang('dingsu.list')</h4>
				
				<div class="table-responsive">
					<table class="table table-hover listtable" id="listtable">
						<thead>
							<tr>
								<th>@lang('dingsu.id')</th>
								<th>@lang('dingsu.create_date')</th>
								<th>@lang('dingsu.lastrun')</th>
								<th>@lang('dingsu.name')</th>
								<th class="">@lang('dingsu.status')</th>
							</tr>
						</thead>
						<tbody class="divimportnoti" id="divimportnoti">
							@foreach($activejob as $list)
							<tr id="tr_{{ $list->id }}">
								<td>{{ $list->id }}</td>
								<td>{{ $list->created_at }}</td>
								<td>{{ $list->updated_at }}</td>
								<td>{{ $list->file_name }}</td>
								<td id="st_{{$list->id}}">								
								@if($list->status == 1)
								<label class="badge badge-info">@lang('dingsu.waiting')</label> 
								@elseif ($list->status == 2)
								<label class="badge badge-success">@lang('dingsu.processing')</label> 
								@else 
									<label class="badge badge-warning">@lang('dingsu.completed')</label>
								@endif								
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	
	</div>
</div>

<!--<h1>Connection Status: <span id="connesction"></span></h1> -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
 
   
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.26.11/dist/sweetalert2.all.min.js"></script>


<script type="text/javascript">	
	var trr = '';
	@section('socket')
    @parent
     socket.on(perfix+"importnoti" + ":App\\Events\\EventDynamicChannel", function(data) {
				$('#divimportnoti').html('');
				$.each(data.data, function( index, row ) {
				  console.log(row);					
					trr = '<tr id=tr_'+row.id+'><td>'+row.id+'</td><td>'+row.created_at+'</td>	<td>'+row.updated_at+'</td>							<td>'+row.file_name+'</td>	<td id=st_'+row.id+'>'+ getstatus(row.status) +'</td></tr>';
					
					$('#divimportnoti').append(trr);
				});
			 });
	@endsection
	
	
	function getstatus(status)
	{
		if (status == 1)
		{
			return "<label class='badge badge-info'>"+'@lang("dingsu.waiting")'+"</label> ";
		}
		else if (status == 2)
		{
			return "<label class='badge badge-success'>"+'@lang("dingsu.processing")'+"</label> ";
		}
		else
		{
			return "<label class='badge badge-warning'>"+'@lang("dingsu.completed")'+"</label> ";
		}
	}
	
    
</script>
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
