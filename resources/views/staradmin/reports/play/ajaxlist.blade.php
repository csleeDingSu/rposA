<div class="row">
	@if(!$result->isEmpty())
	<div class="col-lg-12 grid-margin stretch-card">
		<div class="card">
			<div class="card-body">
				<h4 class="card-title">@lang('dingsu.play') @lang('dingsu.list')</h4>
				<div class="table-responsive">
					<table class="table table-hover listtable" id="listtable">
						<thead>
							<tr>
								
								<th>@lang('dingsu.played_time')</th>
										<th>@lang('dingsu.drawid')</th>
										<th>@lang('dingsu.game_result')</th>
										<th>@lang('dingsu.play_result')</th>
										<th>@lang('dingsu.play_status')</th>
										<th>@lang('dingsu.name')</th>
										<th>@lang('dingsu.wechat') @lang('dingsu.name')</th>
										<th>@lang('dingsu.wechat_status')</th>
										<th>@lang('dingsu.status')</th>
							</tr>
						</thead>
						<tbody>
							@foreach($result as $list)
							
							<tr id="tr">
								
								
	<td>{{ $list->played_time }}</td>
	<td>{{ $list->draw_id }}</td>
	<td>{{ $list->bet }}</td>
	<td>{{ $list->game_result }}</td>
	<td>
		@if($list->is_win == 1)
		<label class="badge badge-success">@lang('dingsu.win')</label> 		
		@else 
		<label class="badge badge-danger">@lang('dingsu.lose')</label> 		
		@endif
	</td>
	<td>{{ $list->username }}</td>							
	<td>
		{{ $list->wechat_name }}
	</td>
	<td>
		@if($list->wechat_verification_status == 0)
		<label class="badge badge-success">@lang('dingsu.verified')</label> 
		@elseif ($list->wechat_verification_status == 1)
		<label class="badge badge-info">@lang('dingsu.unverified')</label> 
		@elseif ($list->wechat_verification_status == 2)
		<label class="badge badge-warning">@lang('dingsu.rejected')</label> 
		@elseif ($list->wechat_verification_status == 3)
		<label class="badge badge-danger">@lang('dingsu.suspended')</label> 
		@else 
		@endif
	</td>
	<td>
		@if($list->member_status == 0)
		<label class="badge badge-success">@lang('dingsu.active')</label> 
		@elseif ($list->member_status == 1)
		<label class="badge badge-danger">@lang('dingsu.inactive')</label> 
		@elseif ($list->member_status == 2)
		<label class="badge badge-warning">@lang('dingsu.suspended')</label> 
		@else 
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