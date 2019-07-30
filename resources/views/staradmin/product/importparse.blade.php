<div class="col-12 grid-margin">
	<div class="card">
		<div class="card-body">
			<h4 class="card-title">@lang('dingsu.import_voucher')</h4>
			 <form class="form-horizontal" name="importform" id="importform" method="POST" action="{{route ('pin.process.import')}}" >
                           
				{{ csrf_field() }} 
				 <input type="hidden" id="filename" name="filename" value="{{$filename}}">
				 @foreach ($errors->all() as $error)
				<div class="alert alert-danger" role="alert">@lang($error)</div>
				@endforeach @if(session()->has('message'))
				<div class="alert alert-success" role="alert">
					{{ session()->get('message') }}
				</div>
				@endif
				
			@foreach ($sys_title as $title)
				<div class="row">
					<div class="col-md-8">
						<div class="form-group row">
							<label for="game_name" class="col-sm-3 col-form-label">
								@lang('dingsu.'.$title->title) 

								@if ($title->is_mandatory == 1)
									<span class="text-danger">*</span>
								@endif

							</label>
							<div class="col-sm-9">
																
								<input type="hidden" name="sys_tit[]" id="{{$title->id}}" value="{{$title->id}}">
								<input type="hidden" name="is_mandatory[]" id="is_mandatory_{{$title->id}}" value="{{$title->is_mandatory}}">								
								
								<select id="file_title_{{$loop->iteration}}" name="file_title[]" class="form-control positionTypes">
									<option class="defaultoption" value="">@lang('dingsu.default_select')</option>
									@foreach ($file_title as $key => $etitle)
									<option  value="{{$key}}">@lang('dingsu.'.$etitle) </option>
									@endforeach 
								</select>
 							</div>
							
						</div>
					</div>	
					
					
				</div>
				@endforeach 
				

				<button  type="submit" class="btn btn-success mr-2">@lang('dingsu.continue')</button>
				<a href="" type="submit" class="btn btn-light mr-2">@lang('dingsu.back')</a>


			</form>
		</div>
	</div>
</div>






<script type="text/javascript">
	
	$("select.positionTypes").change(function () {
    $("select.positionTypes option[value='" + $(this).data('index') + "']").prop('disabled', false);
    $(this).data('index', this.value);
    $("select.positionTypes option[value='" + this.value + "']:not([value=''])").prop('disabled', true);
    $(this).find("option[value='" + this.value + "']:not([value=''])").prop('disabled', false);
    });
	
	
$(document).on("submit", "#importform", function(e){
	$( 'select' ) . each( function () {
		var value = $( this ) . val();
		var id = $( this ) . attr( 'id' );
		var is_mandatory = $('#is_mandatory_' + id).val();
		if ( value == '' && is_mandatory == 1) {
			alert( "@lang('dingsu.select_all_dropdown')" );
			e . preventDefault();
			return false;
		}
	} );
});
	
	
</script>