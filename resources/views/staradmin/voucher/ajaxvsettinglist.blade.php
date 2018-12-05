<div class="row ">
	@if(!$result->isEmpty())
<div class="col-lg-12 grid-margin stretch-card">	
	<div class="card">
		<div class="card-body">
			<h4 class="card-title">@lang('dingsu.voucher_category')@lang('dingsu.list')</h4>



			<button type="button" class="btn btn-inverse-info" data-toggle="modal" data-target="#add_cate">@lang('dingsu.add')</button>





			
			{!! $result->render() !!}
			<div class="table-responsive">				
				<table class="table table-hover">
					<thead>
						<tr>
							<th>@lang('dingsu.number')</th>
							<th>@lang('dingsu.voucher_category')</th>
							<th class="">@lang('dingsu.action')</th>
						</tr>
					</thead>
					<tbody>
						@foreach($result as $key=>$list)

						<tr id="tr_{{$key+1}}">
							<td>{{$key+1}}</td>
							<td>{{ $list->display_name }}</td>
							<td>							
								<a href="/voucher/setting/category/edit/{{ $list->id }}"  class="btn btn-icons btn-rounded btn-outline-info btn-inverse-info"><i class=" icon-pencil "></i></a>
								<a onClick="return deletecategory({{$list->id}})"  href="javascript:void(0)" class="btn btn-icons btn-rounded btn-outline-danger btn-inverse-danger"><i class=" icon-trash  "></i></a>
								

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
	
