<div class="col-12 grid-margin">
	<div class="card">
		<div class="card-body">
			<h5 class="card-title">@lang('dingsu.edit_game')</h4>
			<form class="form-sample" action="" method="post" autocomplete="on">

				{{ csrf_field() }} @foreach ($errors->all() as $error)
				<div class="alert alert-danger" role="alert">@lang($error)</div>
				@endforeach 
				
				@if(session()->has('message'))
				<div class="alert alert-success" role="alert">
					{{ session()->get('message') }}
				</div>
				@endif
				

				
				<p>&nbsp;</p>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group row">
							<label for="game_name" class="col-sm-3 col-form-label">@lang('dingsu.game_name') <span class="text-danger">*</span></label>
							<div class="col-sm-9">
								<input id="game_name" name="game_name" class="form-control" type="text" required autofocus value="{{ $out->game_name}}">
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group row">
							<label for="game_id" class="col-sm-3 col-form-label">@lang('dingsu.game_id')<span class="text-danger">*</span></label></label>
							<div class="col-sm-9">
								<input readonly class="form-control" type="text" value="{{ $out->game_id}}">
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group row">
							<label for="status" class="col-sm-3 col-form-label">@lang('dingsu.status')</label>
							<div class="col-sm-9">
								<select id="status" name="status" class="form-control">
									<option value="0">@lang('dingsu.active')</option>
									<option  value="1">@lang('dingsu.inactive')</option>
									<option  value="2">@lang('dingsu.suspended')</option>
								</select>
							</div>
						</div>
					</div>
					<div class="col-md-6">

						<div class="form-group row">
							<label for="category" class="col-sm-3 col-form-label">@lang('dingsu.category')</label>
							<div class="col-sm-9">
								<select id="category" name="category" class="form-control">
									<option  value="1">@lang('dingsu.category') 1</option>
									<option  value="2">@lang('dingsu.category') 2</option>
									<option  value="3">@lang('dingsu.category') 3</option>
									<option  value="4">@lang('dingsu.category') 4</option>
								</select>
							</div>
						</div>

					</div>
				</div>
				<div class="row">

					<div class="col-md-6">
						<div class="form-group row">
							<label class="col-sm-3 col-form-label">@lang('dingsu.membership') </label>
							<div class="col-sm-4">
								<div class="form-radio">
									<label for="membershipRadios1" class="form-check-label">
                                <input id="" name="" class="form-check-input" name="membershipRadios" id="membershipRadios1" value="" checked="" type="radio"> @lang('dingsu.free') 
                              <i class="input-helper"></i></label>
								
								</div>
							</div>
							<div class="col-sm-5">
								<div class="form-radio">
									<label for="membershipRadios2" class="form-check-label">
                                <input class="form-check-input" name="membershipRadios" id="membershipRadios2" value="option2" type="radio">  @lang('dingsu.paid')
                              <i class="input-helper"></i></label>
								
								</div>
							</div>
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group row">
							<label for="notes" class="col-sm-3 col-form-label"> @lang('dingsu.notes')</label>
							<div class="col-sm-9">
								<textarea id="notes" name="notes" placeholder="" class="form-control">{{ $out->notes}}</textarea>
							</div>
						</div>
					</div>

				</div>

				


			</form>
		</div>
	
	
	 <!-- Modal starts -->
                  
                  <div class="modal fade" id="addlevelmodel" tabindex="-1" role="dialog" aria-labelledby="addlevelmodelLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                      <div class="modal-content">
						<form id='level_edit' class="form-sample" action="" method="post" autocomplete="on">
                       		<div class="modal-header">
                          	<h5 class="modal-title" id="addlevelmodelLabel">@lang('dingsu.add') @lang('dingsu.level')</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
		
						</div>
						  
						  
						<div class="modal-body">


								{{ csrf_field() }} @foreach ($errors->all() as $error)
								<span id="form_output"></span>
								<div class="alert alert-danger" role="alert">@lang($error)</div>
								@endforeach @if(session()->has('message'))
								<div class="alert alert-success" role="alert">
									{{ session()->get('message') }}
								</div>
								@endif


								<p>&nbsp;</p>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group row">
											<label for="game_level" class="col-sm-3 col-form-label">@lang('dingsu.gamelevel') <span class="text-danger">*</span></label>
											<div class="col-sm-9">
												<input id="game_level" name="game_level" class="form-control" type="text" required autofocus value="">
											</div>
										</div>
									</div>


									<div class="col-md-6">
										<div class="form-group row">
											<label for="reward" class="col-sm-3 col-form-label">@lang('dingsu.reward')</label>
											<div class="col-sm-9">
												<select id="reward" name="reward" class="form-control">
													<option value="0">@lang('1')</option>
													<option value="1">@lang('2')</option>
													<option value="2">@lang('3')</option>
												</select>
											</div>
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-md-6">
										<div class="form-group row">
											<label for="playtime" class="col-sm-3 col-form-label">@lang('dingsu.playtime')<span class="text-danger">*</span></label></label>
											<div class="col-sm-9">
												<input id="playtime" name="playtime" class="form-control" type="text" value="" required>
											</div>
										</div>
									</div>

								
									<div class="col-md-6">
										<div class="form-group row">
											<label for="status" class="col-sm-3 col-form-label">@lang('dingsu.status')</label>
											<div class="col-sm-9">
												<select id="status" name="status" class="form-control">
													<option value="0">@lang('dingsu.active')</option>
													<option value="1">@lang('dingsu.inactive')</option>
													<option value="2">@lang('dingsu.suspended')</option>
												</select>
											</div>
										</div>
									</div>
								</div>
									
								<div class="row">
									<div class="col-md-6">
										<div class="form-group row">
											<label for="notes" class="col-sm-3 col-form-label"> @lang('dingsu.notes')</label>
											<div class="col-sm-9">
												<textarea id="notes" name="notes" placeholder="" class="form-control">{{ $out->notes}}</textarea>
											</div>
										</div>
									</div>

								</div>



						</div>
						<div class="modal-footer">
							<input type="hidden" name="button_action" id="button_action" value="insert"/>
							<input type="submit" name="submit" id="submit" value="Add" class="btn btn-info"/>
							<button type="button" class="btn btn-success addlevel" >@lang('dingsu.submit')</button>
							<button type="button" class="btn btn-dark" data-dismiss="modal">@lang('dingsu.cancel')</button>
						</div>
										
										</form>
					</div>
</div>
</div>
<!-- Modal Ends -->


<div class="card-body">
	<h5 class="my-4">@lang('dingsu.gamelevels')</h5>
	<input type="hidden" name="gameID" id="gameID" value="{{ \Request::segment(3) }}">

	<button type="button" name="add" id="add_data" class="btn btn-success btn-sm">@lang('dingsu.add')</button>

	<div id="gamelevel_table" class="table-responsive">
		<table class="table table-hover">
			<thead>
				<tr>
					<th>@lang('dingsu.gamelevel')</th>
					<th>@lang('dingsu.playtime')</th>
					<th>@lang('dingsu.reward')</th>
					<th>@lang('dingsu.status')</th>

				</tr>
			</thead>
			<tbody>
				@foreach($levels as $level)
				<tr>
					<td width ="10" >{{ $level->id }}</td>
					<td>
					<select id="playtime" name="playtime" class="form-control">
						@foreach ($classname_array as $data)                                       
						<option value="{{ $data->id }}"  >{{ $data->play_time }}</option>                                                      
						@endforeach
					</select>
					</td>


					<td>
					<select id="reward" name="reward" class="form-control">
						@foreach ($classname_array as $data)                                       
						<option value="{{ $data->id }}"  >{{ $data->reward }}</option>                                                      
						@endforeach
					</select>
					</td>




					<td>
						@if($level->status == 0)
						<label class="badge badge-success">@lang('dingsu.active')</label> @elseif ($level->status == 1)
						<label class="badge badge-danger">@lang('dingsu.inactive')</label> @elseif ($level->status == 2)
						<label class="badge badge-info">@lang('dingsu.suspended')</label> @else @endif
					</td>
					<td>
					<a onClick="confirm_Delete({{ $level->id }}, '{{ csrf_token() }}')" data-token="{{ csrf_token() }}" href="#" class="btn btn-danger btn-fw">@lang('dingsu.delete')</a>
					</td>

					
				</tr>
				@endforeach
			</tbody>
		</table>
						<button type="submit" class="btn btn-success mr-2">@lang('dingsu.save')</button>
						<a href="/game/list" type="" class="btn btn-light mr-2">@lang('dingsu.back')</a>
						
	</div>










</div>






</div>
</div>


<script type="text/javascript">
	


//	$('#addlevelmodel').dialog('open');
	
	
	$.ajaxSetup({

        headers: {

            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

        }

    });


	$('#add_data').click(function(){
		$('#addlevelmodel').modal('show');
		$('#level_edit')[0].reset();
		$('#form_output').html('');
		$('#button_action').val('insert');
		$('#submit').val('Add');
	});


	$('#level_edit').on('submit', function(event)
	{
		event.preventDefault();
		var form_data = $(this).serialize();
		$.ajax({
			method:"POST",
			data:form_data,
			dataType:"json",
			succcess:function(data)
			{

			}
		})
	})
