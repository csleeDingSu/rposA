@foreach( $result as $list )
<tr id="tr_{{$list->id}}">
	<td scope="row">{{$list->id}}</td>
	<td>{{$list->created_at}}</td>
	<td>
	@if ($list->member_id)
		{{ $list->member->phone ?? $list->member->wechat_name }}
	@endif	
	</td>
	<td>{{$list->point ?? '-' }}</td>
	<td>{{$list->amount ?? '-' }}</td>
	<td>{{$list->buyer->phone ?? '-'  }}</td>
	<td>
		<label class="text-capitalize badge badge-{{$list->status->color}}">
			{{trans('dingsu.' . $list->status->name )}}
		</label>
		@if ($list->is_locked)
			<label class="text-capitalize badge badge-warning">
			{{trans('dingsu.pending_payment' )}}
		</label>
		@endif	
	</td>	
	<td>				
		
		<button type="button" data-id="{{$list->id}}" id="{{$list->id}}" class="btn btn-icons btn-rounded btn-outline-info btn-inverse-success editrow"> <i class="fa fa-pencil-alt"></i> </button>		

		<button type="button" data-id="{{$list->id}}" id="{{$list->id}}" class="btn btn-icons btn-rounded btn-outline-danger btn-inverse-danger rejectrow"> <i class="fa fa-trash"></i> </button>	
	
	</td>
</tr>
@endforeach

