
<div class="col-lg-12 grid-margin stretch-card">	
	<div class="card">
		<div class="card-body">
			<h4 class="card-title">@lang('dingsu.redeem') @lang('dingsu.list')</h4>
			<div class="table-responsive">				
				<table class="table table-hover">
					<thead>
						<tr>
							<th>@lang('dingsu.id')</th>
							<th>@lang('dingsu.create_Date')</th>
							<th>@lang('dingsu.product') @lang('dingsu.name')</th>							
							<th>@lang('dingsu.username')</th>
							<th>@lang('dingsu.product') @lang('dingsu.price')</th>
							<th>@lang('dingsu.status')</th>
							<th class="">@lang('dingsu.action')</th>
						</tr>
					</thead>
					<tbody>
						@foreach($result as $list)
						<tr id="tr_{{ $list->id }}">
							<td>{{ $list->id }}</td>
							<td>{{ $list->created_at }}</td>
							<td>{{ $list->product_name }}</td>
							
							<td>
								{{ $list->username }}
							</td>
							<td>
								{{ $list->product_price }}
							</td>
							<td id="statustd_{{ $list->id }}">
								@if($list->pin_status == 0)
								<label class="badge badge-warning">@lang('dingsu.active')</label> 
								@elseif ($list->pin_status == 1)
								<label class="badge badge-success">@lang('dingsu.redeemed')</label> 
								@elseif ($list->pin_status == 2)
								<label class="badge badge-success">@lang('dingsu.confirmed')</label>
								@elseif ($list->pin_status == 3)
								<label class="badge badge-danger">@lang('dingsu.rejected')</label>
								@elseif ($list->pin_status == 4)
								<label class="badge badge-info">@lang('dingsu.pending') @lang('dingsu.confirmation')</label>
								@else 
								<label class="badge badge-danger">@lang('dingsu.unknown') @lang('dingsu.status')</label>
								@endif
							</td>	
							<td id="actiontd_{{ $list->id }}">
								@if($list->pin_status == 4 )								
								<a href="javascript:void(0)" onClick="confirm_redeem({{ $list->id }})" class="btn btn-icons btn-rounded btn-outline-info btn-inverse-info"><i class=" icon-check  "></i></a>								
								<a href="javascript:void(0)" onClick="confirm_Delete({{ $list->id }})" class="btn btn-icons btn-rounded btn-outline-danger btn-inverse-danger"><i class=" icon-close  "></i></a>								
								@endif								
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>				
				{!! $result->render() !!}
			</div>
		</div>
	</div>
</div>


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

	  } else if (result.dismiss === Swal.DismissReason.cancel) {

	  }
	})
}
	
</script>
