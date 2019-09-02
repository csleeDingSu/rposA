<div class="row">
	@if(!$result->isEmpty())
	<div class="col-lg-12 grid-margin stretch-card">
		<div class="card">
			<div class="card-body">
				<h4 class="card-title">@lang('lang.notification') @lang('lang.list')</h4>
				<div class="table-responsive">
					<table class="table table-hover listtable text-capitalize" id="listtable">
						<thead>
							<tr> 	
								<th>#</th>
								<th>@lang('lang.created_at')</th>
								<th>@lang('lang.read_at')</th>
								<th>@lang('lang.member')</th>
								<th>@lang('lang.title')</th>
								<th>@lang('lang.status')</th>
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
                     @lang('lang.no_record_found') </h>               
              </div>
            </div>	
	@endif
	</div>



