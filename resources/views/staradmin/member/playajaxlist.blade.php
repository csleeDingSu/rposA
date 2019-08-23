@if( !$result->isEmpty() )
<div class="table-responsive">
	<table class="table table-hover listtable" id="listtable">
		<thead>
			<tr>
				<th>@lang('dingsu.played_time')</th>
				<th>@lang('dingsu.game') @lang('dingsu.name')</th>
				<th>@lang('dingsu.bet_amount')</th>
				<th>@lang('dingsu.game_result')</th>
				<th>@lang('dingsu.play_result')</th>
				<th>@lang('dingsu.play_status')</th>
			</tr>
		</thead>
		<tbody>
			@foreach($result as $list)
			<tr id="tr">
				<td>{{ $list->played_time }}</td>
				<td>{{ $list->game_name }}</td>
				<td>
					{{ $list->bet_amount }}
				</td>
				<td>{{ $list->bet }}</td>
				<td>{{ $list->game_result }}</td>
				<td>
					@if($list->is_win == 1)
					<label class="badge badge-success">@lang('dingsu.win')</label> @else
					<label class="badge badge-danger">@lang('dingsu.lose')</label> @endif
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div>
@else
<h3 class="mt-3 mb-3 text-danger font-weight-medium text-center">
                     @lang('dingsu.no_record_found') </h>               
              	
	@endif