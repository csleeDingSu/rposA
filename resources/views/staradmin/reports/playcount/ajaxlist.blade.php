<div class="row">
	@if(!$result->isEmpty())
	<div class="col-lg-12 grid-margin stretch-card">
		<div class="card">
			<div class="card-body">
				<h4 class="card-title">@lang('dingsu.draw') @lang('dingsu.played') @lang('dingsu.list')</h4>
				<div class="table-responsive">
					<table class="table table-hover listtable" id="listtable">
						<thead>
							<tr>
								<th>@lang('dingsu.created_at')</th>
								<th>@lang('dingsu.game_id')</th>
								<th>@lang('dingsu.played_users')</th>
								
							</tr>
						</thead>
						<tbody>
							@foreach($result as $list)							
							
							
							<tr id="tr_">
								<td>{{ $list->created_at }}</td>
								<td>{{ $list->game_id }}</td>
								<td id="playedusers_total">
									@if($list->total > 0)
									
									<a target="_blank" href="/report/redeem-details?date={{$list->created_at}}&gameid={{$list->game_id}}"
									 class="badge badge-pill badge-success"> {{ $list->played_users }} </a>	
									@else 
										0
									@endif
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