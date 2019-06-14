
@foreach ($result as $key=>$list)
<tr id="tr">
	<td>{{ $list->id }}</td>
	<td>{{ $list->created_at }}</td>
	<td>
		
		{{ $list->pin_name }}
		</td>
	<td>
		{{ $list->username }}  {{ $list->redeem_status }}
	</td>
	
	
	<td id="statustd_{{ $list->id }}">
		
		
		@if($list->redeem_status == 'Active')
		<label class="badge badge-warning">@lang('dingsu.active')</label>
		@elseif ($list->redeem_status == 1)
		<label class="badge badge-success">@lang('dingsu.redeemed')</label> 
		@elseif ($list->redeem_status == 'confirmed')
		<label class="badge badge-success">@lang('dingsu.confirmed')</label> 
		@elseif ($list->redeem_status == 'rejected')
		<label class="badge badge-danger">@lang('dingsu.rejected')</label> 
		@elseif ($list->redeem_status == 'pending')
		<label class="badge badge-info">@lang('dingsu.pending') @lang('dingsu.confirmation')</label> @else
		<label class="badge badge-danger">@lang('dingsu.unknown') @lang('dingsu.status')</label> @endif
		
		
	</td>							
</tr>
@endforeach
				
