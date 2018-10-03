
<div class="col-12 d-flex  text-right"><a href="/member/add" class="btn btn-success mr-2">@lang('dingsu.add')</a></div>
<p>&nbsp;</p>
<div class="col-lg-12 grid-margin stretch-card">	
	<div class="card">
		<div class="card-body">
			<h4 class="card-title">@lang('dingsu.member') @lang('dingsu.list')</h4>
			<div class="table-responsive">				
				<table class="table table-hover">
					<thead>
						<tr>
							<th>@lang('dingsu.id')</th>
							<th>@lang('dingsu.name')</th>
							<th>@lang('dingsu.create_Date')</th>
							<th>@lang('dingsu.credit')</th>
							<th>@lang('dingsu.online_status')</th>
							<th>@lang('dingsu.status')</th>
							<th class="">@lang('dingsu.action')</th>
						</tr>
					</thead>
					<tbody>
						@foreach($result as $list)
						<tr id="tr_{{ $list->id }}">
							<td>{{ $list->id }}</td>
							<td>{{ $list->username }}</td>
							<td>
								{{ $list->created_at }}
							</td>
							<td>
								--
							</td>
							<td>
								--
							</td>
							<td>
								@if($list->member_status == 0)
								<label class="badge badge-success">@lang('dingsu.active')</label> 
								@elseif ($list->member_status == 1)
								<label class="badge badge-danger">@lang('dingsu.inactive')</label> 
								@elseif ($list->member_status == 2)
								<label class="badge badge-info">@lang('dingsu.suspended')</label> 
								@else 
								@endif
							</td>
							<td>							
								<a href="/member/edit/{{ $list->id }}"  class="btn btn-info btn-fw">@lang('dingsu.edit')</a>
								{{-- @if($list->account_type == 1) --}}
								<a href="/member/reset/{{ $list->id }}" data-token="{{ csrf_token() }}"  class="btn btn-warning btn-fw">@lang('dingsu.reset_pass')</a>
								<a onClick="confirm_Delete({{ $list->id }}, '{{ csrf_token() }}')" data-token="{{ csrf_token() }}" href="#" class="btn btn-danger btn-fw">@lang('dingsu.delete')</a>
								{{-- @endif--}}
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
