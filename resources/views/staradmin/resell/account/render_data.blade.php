@foreach( $result as $list )
<tr id="tr_{{$list->id}}" class="{{$highlight ?? ''}}" >
	<td scope="row">{{$list->id}}</td>
	
	
	<td>{{$list->account_name}}</td>
	<td>{{$list->account_number ?? '-' }}</td>
	<td>{{$list->bank_name ?? '-' }}</td>
	<td>
		<button type="button" data-id="{{$list->id}}" id="{{$list->id}}" class="btn btn-icons btn-rounded btn-outline-info btn-inverse-success editrow"> <i class="fa fa-pencil-alt"></i> </button>	
		<button type="button" data-id="{{$list->id}}" id="{{$list->id}} rejectrow" class="btn btn-icons btn-rounded btn-outline-danger btn-inverse-danger rejectrow"> <i class="fa fa-trash"></i> </button>
	</td>
</tr>
@endforeach

