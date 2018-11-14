<div class="row">
	@if(!$result->isEmpty())
	<div class="col-lg-12 grid-margin stretch-card">
		<div class="card">
			<div class="card-body">
				<h4 class="card-title">@lang('dingsu.banner') @lang('dingsu.list')</h4>
				<div class="table-responsive">
					<table class="table table-hover listtable" id="listtable">
						<thead>
							<tr>
								<th>@lang('dingsu.id')</th>
								<th>@lang('dingsu.create_date')</th>
								<th>@lang('dingsu.status')</th>
								<th>@lang('dingsu.image')</th>
								<th class="">@lang('dingsu.action')</th>
							</tr>
						</thead>
						<tbody>
							@foreach($result as $list)
							<tr id="tr_{{ $list->id }}">
								<td>{{ $list->id }}</td>
								<td>{{ $list->created_at }}</td>
								<td>
								
								@if($list->is_status == 1)
									<label class="badge badge-success">@lang('dingsu.active')</label> @elseif ($list->is_status == 2)
									<label class="badge badge-warning">@lang('dingsu.inactive')</label> @else
									<label class="badge badge-danger">@lang('dingsu.unknown') @lang('dingsu.status')</label> @endif
								
								</td>
								<td id="st_{{$list->id}}">
								
								<img style="width: 200px !important;height: 200px !important" width="300px" height="200px" class="bannerimg bannerimg_{{$list->id}} img-md  mb-4 mb-md-0 d-block mx-md-auto" src="/ad/banner/{{ $list->banner_image }}" alt="image">
								
								</td>
								
								<td>
									<a href="javascript:void(0)" data-id="{{ $list->id }}"  class="editbanner btn btn-icons btn-rounded btn-outline-info btn-inverse-info"><i class=" icon-pencil "></i></a>
								
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