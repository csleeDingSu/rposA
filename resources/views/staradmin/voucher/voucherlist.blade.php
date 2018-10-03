
<div class="col-12 d-flex  text-right">
	
	<a href="/voucher/upload" class="btn btn-success mr-2">@lang('dingsu.add')</a>
	
	<a href="/voucher/import" class="btn btn-info mr-2">@lang('dingsu.upload')</a>

</div>


<p>&nbsp;</p>

<div class="col-lg-12 grid-margin stretch-card">
	
	
	
	<div class="card">
		<div class="card-body">
			<h4 class="card-title">@lang('dingsu.voucher') @lang('dingsu.list')</h4>
			<div class="table-responsive">
				<table class="table table-hover table-responsive">
					<thead>
						<tr>
							<th>@lang('dingsu.action')</th>
							<th>@lang('dingsu.id')</th>
							<th>@lang('dingsu.name')</th>
							<th>@lang('dingsu.category')</th>
							<th>@lang('dingsu.product_price')</th>
							<th>@lang('dingsu.ads_link')</th>
							<th>@lang('dingsu.used_voucher')</th>
							
						</tr>
					</thead>
					<tbody>
						@foreach($result as $list)
						<tr>
							<td>							
								<a href="/voucher/edit/{{ $list->id }}"  class="btn btn-icons btn-inverse-info"><i class="icon-pencil"></i></a>
								<a onClick="confirm_Delete({{ $list->id }}, '{{ csrf_token() }}')" data-token="{{ csrf_token() }}" href="#" class="btn btn-icons btn-inverse-danger"><i class="icon-trash"></i></a>
								
								
								
							</td>
							<td>{{ $list->id }}</td>
							<td class="is-breakable">{{ $list->product_name }}</td>
							<td class="is-breakable" style="word-break: break-all">
								{{ $list->product_category }}
							</td>
							<td >
								{{ $list->product_price }}
							</td>
							<td>
								<a href="{{ $list->ads_link }}" target="new" >@lang('dingsu.click_here') </a>
							</td>
							<td>
								{{ $list->used_vouchers }}
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
function confirm_Delete(id,token)
	{
Swal({
  title: '@lang("dingsu.delete_confirmation")',
  text: '@lang("dingsu.delete_conf_text")',
  type: 'warning',
  showCancelButton: true,
  confirmButtonText: '@lang("dingsu.delete")',
  cancelButtonText: '@lang("dingsu.cancel")',
	confirmButtonColor: "#DD6B55",
  closeOnConfirm: false
}).then((result) => {
  if (result.value) {
	  
	  $.ajax({
            url: "/member/delete/"+id,
            type: "POST",
            data: {_method: 'delete', _token :token},
            dataType: "html",
            success: function (data) {
				if (data === 'false')
					{
						swal('@lang("dingsu.delete_error")', '@lang("dingsu.try_again")', "error");
					}
				else 
					{
						swal("Done!", '@lang("dingsu.delete_success")', "success");
						
						$('#tr_'+id).hide(); 
					}
                
            },
            error: function (xhr, ajaxOptions, thrownError) {
                swal('@lang("dingsu.delete_error")', '@lang("dingsu.try_again")', "error");
            }
        });
	  
  } else if (result.dismiss === Swal.DismissReason.cancel) {
   
  }
})
	}
	
	
</script>
