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
								@php
									$list->odd  = $list->win ;
									$list->even = $list->lose ;
									$list->win  = 'odd' ;
								@endphp
							 @else
						     	@php
									$list->odd  = $list->lose ;
									$list->even = $list->win ;
									$list->win  = 'even' ;
								@endphp
							 @endif 
							<tr id="tr_{{ $list->draw_id }}">
								<td>{{ $list->draw_id }}</td>
								<td>{{ $list->game_id }}</td>
								<td id="playedusers_total">
								<button type="button" data-type="all" data-id="{{$list->draw_id}}" data-count="{{$list->played_users}}" id="{{$list->draw_id}}" class="btn   Showplayedmembers  "> {{ $list->played_users }} </button>
								
								</td>
								<td>{{ $list->game_result }}</td>
								<td id="playedusers_odd">
									<button type="button" data-type="all" data-id="{{$list->draw_id}}" data-count="{{$list->odd}}" id="{{$list->draw_id}}" class="btn   Showplayedmembers  "> {{ $list->odd }} </button>	
								</td>
								<td id="playedusers_even">
									<button type="button" data-type="all" data-id="{{$list->draw_id}}" data-count="{{$list->even}}" id="{{$list->draw_id}}" class="btn   Showplayedmembers  "> {{ $list->even }} </button>	
								</td>
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