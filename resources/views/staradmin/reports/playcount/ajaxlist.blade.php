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
							
							
							<tr id="tr_{{ $list->draw_id }}">
								<td>{{ $list->created_at }}</td>
								<td>{{ $list->game_id }}</td>
								<td id="playedusers_total">
								<button type="button" data-type="all" data-id="{{$list->draw_id}}" data-count="{{$list->played_users}}" id="{{$list->draw_id}}" class="btn   Showplayedmembers  "> {{ $list->played_users }} </button>
								
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