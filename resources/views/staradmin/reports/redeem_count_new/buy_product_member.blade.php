<thead>
	<tr>
		<th>@lang('dingsu.id')</th>
		<th>@lang('dingsu.create_Date')</th>
		<th>@lang('dingsu.package') @lang('dingsu.name')</th>
		<th>@lang('dingsu.type')</th>
		<th>@lang('dingsu.phone')</th>
		<th>@lang('dingsu.wechat_name')</th>
		<th>@lang('dingsu.product_price')</th>
		<th>@lang('dingsu.quantity')</th>
		<th>@lang('dingsu.used_point')</th>
		<th>@lang('dingsu.status')</th>										
	</tr>
</thead>

<tbody >
@foreach ($result as $key=>$list)
<tr id="tr">
	<td>{{ $list->id }}</td>
	<td>{{ $list->created_at }}</td>
	<td>		
		{{ $list->product->name }}
		</td>
	<td>									
		@switch($list->product->type)
			@case('1')
				<label class="badge badge-success">@lang('dingsu.virtual_card')</label>
				@break
			@case('2')
				<label class="badge badge-info">@lang('dingsu.product')</label>
				@break

			@default
				<label class="badge badge-danger">@lang('dingsu.unknown') @lang('dingsu.type')</label>
		@endswitch

	</td> 
	<td>
		{{ $list->member->phone }}  
	</td>
	<td>
		{{ $list->member->wechat_name }}  
	</td>
	<td>
		{{ $list->product->point_to_redeem }}
	</td>
	<td>{{ $list->quantity }}</td>								
	<td>{{ $list->used_point }}</td>
	
	<td id="statustd_{{ $list->id }}">
		
		
		
		@if ($list->redeem_state == 3)
		<label class="badge badge-success">@lang('dingsu.confirmed')</label> 
		@elseif ($list->redeem_state == 0)
		<label class="badge badge-danger">@lang('dingsu.rejected')</label> 
		@elseif ($list->redeem_state == 1)
		<label class="badge badge-info">@lang('dingsu.pending') @lang('dingsu.confirmation')</label> @else
		<label class="badge badge-danger">@lang('dingsu.unknown') @lang('dingsu.status')</label> @endif
		
		
	</td>							
</tr>
@endforeach
</tbody>	

{!! $result->render() !!}


