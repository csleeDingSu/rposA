<div class="row">
	@if(!$result->isEmpty())
	<div class="col-lg-12 grid-margin stretch-card">
		<div class="card">
			<div class="card-body">
				<h4 class="card-title">@lang('dingsu.redeem_condition') @lang('dingsu.list')</h4>
				<div class="table-responsive">
					<table class="table table-hover listtable" id="listtable">
						<thead>
							<tr>
								<th>@lang('dingsu.id')</th>
								
								<th>@lang('dingsu.num_of_redeem')</th>
								<th>@lang('dingsu.min_point')</th>
								<th>@lang('dingsu.description')</th>
								<th class="">@lang('dingsu.action')</th>
							</tr>
						</thead>
						<tbody>
							@foreach($result as $list)
							<tr id="tr_{{ $list->id }}">
								<td>{{ $list->id }}</td>
								<td id="sp_{{$list->id}}">{{ $list->position }}</td>
								<td id="sm_{{$list->id}}">{{ $list->minimum_point }}</td>
								<td id="sd_{{$list->id}}">{{ $list->description }}</td>
								<td>
									<a href="javascript:void(0)" data-id="{{ $list->id }}"  class="editrecord btn btn-icons btn-rounded btn-outline-info btn-inverse-info"><i class=" icon-pencil "></i></a>
								
									<a href="javascript:void(0)" onClick="confirm_Delete({{ $list->id }});return false;" class="btn btn-icons btn-rounded btn-outline-danger btn-inverse-danger"><i class=" icon-trash  "></i></a> 
									
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