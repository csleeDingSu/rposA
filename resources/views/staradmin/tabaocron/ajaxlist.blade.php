<div class="row">
	@if(!$result->isEmpty())
	<div class="col-lg-12 grid-margin stretch-card">
		<div class="card">
			<div class="card-body">
				<h4 class="card-title">@lang('dingsu.cron') @lang('dingsu.list')</h4>
				<div class="table-responsive">
					<table class="table table-hover listtable" id="listtable">
						<thead>
							<tr>
								
								<th>@lang('dingsu.name')</th>
								<th>@lang('dingsu.last_run')</th>								
								<th>@lang('dingsu.status')</th>
								<th class="">@lang('dingsu.action')</th>
							</tr>
						</thead>
						<tbody>
							@foreach($result as $list)
							<tr id="tr_{{ $list->id }}">
								<td>{{ $list->id }}</td>
								<td id="sp_{{$list->id}}">{{ $list->name }}</td>
								<td id="sl_{{$list->id}}">{{ $list->last_run }}</td>													
								<td id="ss_{{$list->id}}">
									@if($list->status == 1)
									<label class="badge badge-success">@lang('dingsu.active')</label> 
									@elseif ($list->status == 2)
									<label class="badge badge-info">@lang('dingsu.processing')</label> 
									@elseif ($list->status == 3)
									<label class="badge badge-danger">@lang('dingsu.suspended')</label> 
									
									@else 
									@endif
								</td>					
								
								<td>
									@if($list->status == 1)
									<a href="javascript:void(0)" data-id="{{ $list->id }}"  class="editrecord btn btn-icons btn-rounded btn-outline-info btn-inverse-info">@lang('dingsu.run')</a>	
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