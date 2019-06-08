
@foreach ($result as $key=>$list)
<tr id="tr">
	<td>{{ $list->id }}</td>
	<td>{{ $list->created_at }}</td>
	<td>{{ $list->pin_name }}</td>
	<td>
		{{ $list->username }}
	</td>
	
	
	<td id="statustd_{{ $list->id }}">
		@if($list->redeem_state == 0)
		<label class="badge badge-warning">@lang('dingsu.rejected')</label> 
		@elseif ($list->redeem_state == 1)
		<label class="badge badge-info">@lang('dingsu.pending') @lang('dingsu.confirmation')</label> 
		@elseif ($list->redeem_state == 2)
		<label class="badge badge-success">@lang('dingsu.confirmed')</label> 
		@elseif ($list->redeem_state == 3)
		<label class="badge badge-success">@lang('dingsu.redeemed')</label> 
		@else
		<label class="badge badge-danger">@lang('dingsu.unknown') @lang('dingsu.status')</label> 
		@endif
	</td>							
</tr>
@endforeach
				
