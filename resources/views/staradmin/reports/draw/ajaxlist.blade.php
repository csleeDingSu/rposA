<div class="row">
	@if(!$result->isEmpty())
	<div class="col-lg-12 grid-margin stretch-card">
		<div class="card">
			<div class="card-body">
				<h4 class="card-title">@lang('dingsu.redeem') @lang('dingsu.history') @lang('dingsu.list')</h4>
				<div class="table-responsive">
					<table class="table table-hover listtable" id="listtable">
						<thead>
							<tr>
								<th>@lang('dingsu.drawid')</th>
								<th>@lang('dingsu.game_id')</th>
								<th>@lang('dingsu.played_users')</th>
								<th>@lang('dingsu.game_result')</th>
								<th>@lang('dingsu.odd')</th>
								<th>@lang('dingsu.even')</th>
								<th>@lang('dingsu.created_at')</th>
							</tr>
						</thead>
						<tbody>
							@foreach($result as $list)
							
							 @if ($list->game_result % 2 == 0)
								$list->odd  = $list->win ;
								$list->even = $list->lose ;
							 @else
						     	$list->odd  = $list->lose ;
								$list->even = $list->win ;
							 @endif 
							<tr id="tr_{{ $list->drawid }}">
								<td>{{ $list->drawid }}</td>
								<td>{{ $list->game_id }}</td>
								<td>{{ $list->played_users }}</td>
								<td>{{ $list->game_result }}</td>
								<td>{{ $list->odd }}</td>
								<td>{{ $list->even }}</td>
								<td>
									
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
	@else
	<div class="col-lg-12 grid-margin stretch-card">
		<div class="card">
			<h3 class="mt-3 mb-3 text-danger font-weight-medium text-center">
                     @lang('dingsu.no_record_found') </h>               
              </div>
            </div>	
	@endif
	</div>