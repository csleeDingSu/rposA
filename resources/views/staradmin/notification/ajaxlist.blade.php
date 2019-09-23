<div class="row">
	@if(!$result->isEmpty())
	<div class="col-lg-12 grid-margin stretch-card">
		<div class="card">
			<div class="card-body">
				<h4 class="card-title">@lang('dingsu.notification') @lang('dingsu.list')</h4>
				<div class="table-responsive">
					<table class="table table-hover listtable text-capitalize" id="listtable">
						<thead>
							<tr> 	
								<th>#</th>
								<th>@lang('dingsu.created_at')</th>
								<th>@lang('dingsu.read_at')</th>
								<th>@lang('dingsu.member')</th>
								<th>@lang('dingsu.credit_type')</th>
								<th>@lang('dingsu.amount') / @lang('dingsu.life')</th>
								<th>@lang('dingsu.status')</th>
								<th>@lang('dingsu.notes')</th>
							</tr>
						</thead>
						<tbody>
							
							@include('notification.render_notification')
							
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



