<!-- Modal starts -->
<div class="modal fade" id="childlist" tabindex="-1" role="dialog" aria-labelledby="childlist" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">@lang('dingsu.member') @lang('dingsu.list') </h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>				
				</div>
				<div class="modal-body">
					<div class="" id="mvalidation-errors"></div>
					<div class="row">
						<div class="col-md-12">	
							<div class="table-responsive">				
							<table class="table table-hover">
								<thead>
									<tr>
										<th>#</th>										
										<th>@lang('dingsu.played_time')</th>
										<th>@lang('dingsu.drawid')</th>
										<th>@lang('dingsu.game_result')</th>
										<th>@lang('dingsu.play_result')</th>
										<th>@lang('dingsu.play_status')</th>
										<th>@lang('dingsu.name')</th>
										<th>@lang('dingsu.wechat') @lang('dingsu.name')</th>
										<th>@lang('dingsu.wechat_status')</th>
										<th>@lang('dingsu.status')</th>
									</tr>
								</thead>
								<tbody class="playedmemberlist" id="playedmemberlist">
								</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>				
			</div>
		</div>
	</div>
<!-- Modal Ends -->

