<div class="row ">
	@if(!$result->isEmpty())
	<div class="col-lg-12 grid-margin stretch-card">
		<div class="card">
			<div class="card-body">
				<h4 class="card-title">@lang('dingsu.user') @lang('dingsu.list')</h4> {!! $result->render() !!}
				<div class="table-responsive">
					<table class="table table-hover">
						<thead>
							<tr>
								<th>@lang('dingsu.id')</th>
								<th>@lang('dingsu.name')</th>
								<th>@lang('dingsu.create_Date')</th>
								<th>@lang('dingsu.status')</th>
								<th class="">@lang('dingsu.action')</th>
							</tr>
						</thead>
						<tbody>
							@foreach($result as $list)
							<tr id="tr_{{ $list->id }}">

								<input type="hidden" name="show_status_{{ $list->id }}" id="show_status_{{ $list->id }}" value="{{ $list->user_status }}">


								<td>{{ $list->id }}</td>
								<td>{{ $list->username }}</td>
								<td>
									{{ $list->created_at }}
								</td>


								<td onClick="OpenUpdateStatus('{{ $list->id }}')" class="show_update_status_{{ $list->id }}">
									@if($list->user_status == 1)
									<label class="badge badge-success">@lang('dingsu.active')</label> @elseif ($list->user_status == 2)
									<label class="badge badge-danger">@lang('dingsu.inactive')</label> @elseif ($list->user_status == 3)
									<label class="badge badge-warning">@lang('dingsu.suspended')</label> @else @endif
								</td>
								<td>

									@if ($list->id != 1)


									<a href="/user/edit/{{ $list->id }}" class="btn btn-icons btn-rounded btn-outline-info btn-inverse-info"><i class=" icon-pencil "></i></a>


									<a href="javascript:void(0)" onClick="resetpassword('{{ $list->id }}')" class="btn btn-icons btn-rounded btn-outline-danger btn-inverse-warning"><i class="icon-key"></i></a>




									<a onClick="confirm_Delete({{ $list->id }})" href="javascript:void(0)" class="btn btn-icons btn-rounded btn-outline-danger btn-inverse-danger"><i class=" icon-trash  "></i></a> @endif








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