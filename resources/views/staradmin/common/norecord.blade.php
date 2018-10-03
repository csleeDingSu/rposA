<div class="col-12 grid-margin">
	<div class="card">
		<div class="card-body">
			<h4 class="card-title text-info display-3">@lang('dingsu.no_items_to_show')</h4>
			<span class="red display-4">
						
				@if(isset($error_msg))
				  {{trans('dingsu.' . $error_msg )}}
				@else
					@lang('dingsu.no_items_to_show')
				@endif
			</span>
		</div>
	</div>
</div>