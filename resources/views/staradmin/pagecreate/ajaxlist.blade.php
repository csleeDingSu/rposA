<div class="row">
	@if(!$result->isEmpty())
	<div class="col-lg-12 grid-margin stretch-card">
		<div class="card">
			<div class="card-body">
				<h4 class="card-title">@lang('dingsu.receipt') @lang('dingsu.list')</h4>
				<div class="table-responsive">
					<table class="table table-hover listtable text-capitalize" id="listtable">
						<thead>
							<tr> 	
								<th>#</th>
								<th>@lang('dingsu.created')</th>
								<th>@lang('dingsu.orderid')</th>
								<th>@lang('dingsu.seller')</th>
								<th>@lang('dingsu.point')</th>
								<th>@lang('dingsu.amount')</th>
								<th>@lang('dingsu.buyer')</th>
								<th>@lang('dingsu.status')</th>
								<th>@lang('dingsu.action')</th>
							</tr>
						</thead>
						<tbody>
							@include('resell.render_data')
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
			@if (!empty($firstload))    
            <h3 class="mt-3 mb-3 text-primary font-weight-medium text-center">
            	@lang('dingsu.please_wait') 
            </h3> 
            @else
            <h3 class="mt-3 mb-3 text-danger font-weight-medium text-center">
            	@lang('dingsu.no_record_found') 
            </h3> 
            @endif              
              </div>
            </div>	
	@endif
	</div>



