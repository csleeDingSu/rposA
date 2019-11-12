@foreach( $result as $list )
<tr id="tr_{{$list->id}}">
	<td scope="row">{{$list->id}}</td>
	<td>{{$list->created_at}}</td>
	<td>{{$list->uuid}}</td>
	<td>
	@if ($list->member_id)
		{{ $list->member->phone ?? (empty($list->member->wechat_name) ? '' : $list->member->wechat_name) }}
	@endif	
	</td>
	<td>{{$list->point ?? '-' }}</td>
	<td>{{$list->amount ?? '-' }}</td>
	<td>{{$list->buyer->phone ?? '-'  }}</td>
	<td>
		<label class="text-capitalize badge badge-{{$list->status->color}}">
			{{trans('dingsu.resell_' . $list->status->name )}}
		</label>
		@if ($list->is_locked)
			<label class="text-capitalize badge badge-warning">
			{{trans('dingsu.pending_payment' )}}
		</label>
		@endif	
	</td>	
	<td>				
		@if (!$list->is_locked)
			<button type="button" data-id="{{$list->id}}" id="{{$list->id}}" class="btn btn-icons btn-rounded btn-outline-info btn-inverse-success editrow"> <i class="fa fa-pencil-alt"></i> </button>	
		@endif		
	
	</td>
</tr>
@endforeach

