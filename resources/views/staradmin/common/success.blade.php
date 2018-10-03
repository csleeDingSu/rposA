<div class="col-12 grid-margin">
	<div class="card">
		<div class="card-body">
			<h4 class="card-title text-success display-3">@lang('dingsu.message_success')</h4>
			<span class="text-success display-4">
						
						@isset($msg)
							{{ trans('dingsu.'.$msg ) }}
						@endisset

						@empty($msg)
							{{ trans('dingsu.message_success' ) }}
						@endempty
						
					</span>
		</div>
	</div>
</div>