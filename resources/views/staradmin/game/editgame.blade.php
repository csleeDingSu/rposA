<div class="col-12 grid-margin">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">@lang('dingsu.edit_product')</h4>
                  <form class="form-sample" action="" method="post" autocomplete="on">
					  
					  {{ csrf_field() }}
					  
					  
					  @foreach ($errors->all() as $error)
						<div class="alert alert-danger" role="alert">@lang($error)</div>
					  @endforeach
					  
					  
					  @if(session()->has('message'))
						<div class="alert alert-success" role="alert">
							{{ session()->get('message') }}
						</div>
					@endif
					  
					  
					  <div class="row">
						
                      <div class="col-md-6">
                        <div class="form-group row"> 
							<label for="game_id" class="col-sm-3 col-form-label">@lang('dingsu.game') @lang('dingsu.id')</label>
                          
							 
                          <div class="col-sm-9">
                            <input id="game_id" name="game_id" class="form-control" type="text" autofocus value="{{ old('game_id', $out->game_id) }}">
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label for="game_name" class="col-sm-3 col-form-label">@lang('dingsu.game') @lang('dingsu.name')</label>
                          <div class="col-sm-9">
                            <input id="game_name" readonly name="game_name" class="form-control" type="text" value="{{ old('game_name', $out->game_name) }}" maxlength="5">
                          </div>
                        </div>
                      </div>
                    </div>
					  
					  
					  <div class="row"> 
						<div class="col-md-6">
                        <div class="form-group row">
                          <label for="is_active" class="col-sm-3 col-form-label">@lang('dingsu.is_active')</label>
                          <div class="col-sm-9">
								<select id="is_active" name="is_active" class="form-control">
								<option {{old('is_active',$out->is_active)=="0"? 'selected':''}}  value="0" >@lang('dingsu.no')</option>
								<option {{old('is_active',$out->is_active)=="1"? 'selected':''}}  value="1" >@lang('dingsu.yes')</option>
								</select>
							</div>
                        </div>
                      </div>
						  	
                    <div class="col-md-6">
                        <div class="form-group row">
                          <label for="membership" class="col-sm-3 col-form-label">@lang('dingsu.membership')</label>
                          <div class="col-sm-9">
                            <input id="membership" name="membership" class="form-control" type="text" required value="{{ $out->membership }}" readonly  maxlength="5">
                          </div>
                        </div>
                      </div>
						  
                      
                    
                    </div>
					  
					  
					  
					  <div class="row"> 
					<div class="col-md-6">
						<div class="form-group row">
							<label for="category" class="col-sm-3 col-form-label">@lang('dingsu.category')</label>
							<div class="col-sm-9">
								<select id="category" name="category" class="form-control">
								<option {{old('game_category',$out->game_category)=="0"? 'selected':''}}  value="0" >@lang('dingsu.category') 1</option>
								<option {{old('game_category',$out->game_category)=="1"? 'selected':''}}  value="1" >@lang('dingsu.category') 2</option>
								<option {{old('game_category',$out->game_category)=="2"? 'selected':''}}  value="2" >@lang('dingsu.category') 3</option>
								<option {{old('game_category',$out->game_category)=="3"? 'selected':''}}  value="3" >@lang('dingsu.category') 4</option>
								</select>
							</div>
						</div>
                      </div>
                     <div class="col-md-6">
                        <div class="form-group row">
                          <label for="game_status" class="col-sm-3 col-form-label">@lang('dingsu.game_status')</label>
                          <div class="col-sm-9">
                            <select id="game_status" name="game_status" class="form-control">
							 <option {{old('game_status',$out->game_status)=="0"? 'selected':''}}  value="0" >@lang('dingsu.active')</option>
							 <option {{old('game_status',$out->game_status)=="1"? 'selected':''}}  value="1" >@lang('dingsu.inactive')</option>
							 <option {{old('game_status',$out->game_status)=="2"? 'selected':''}}  value="2" >@lang('dingsu.reserved')</option>
                            </select>
                          </div>
                        </div>
                      </div>
                    </div>



					  <div class="row"> 
					<div class="col-md-6">
                        <div class="form-group row">
                          <label for="is_support_game_resume" class="col-sm-3 col-form-label">@lang('dingsu.is_support_game_resume')</label>
                          <div class="col-sm-9">
								<select id="is_support_game_resume" name="is_support_game_resume" class="form-control">
								<option {{old('is_support_game_resume',$out->is_support_game_resume)=="0"? 'selected':''}}  value="0" >@lang('dingsu.no')</option>
								<option {{old('is_support_game_resume',$out->is_support_game_resume)=="1"? 'selected':''}}  value="1" >@lang('dingsu.yes')</option>
								</select>
							</div>
                        </div>
                      </div>
					  <div class="col-md-6">
                        <div class="form-group row">
                          <label for="notes" class="col-sm-3 col-form-label">@lang('dingsu.notes')</label>
                          <div class="col-sm-9">
                            <input id="notes" name="notes" class="form-control" type="text" value="{{ old('notes', $out->notes) }}"  maxlength="5">
                          </div>
                        </div>
                      </div>
                    </div>
					  
					  
					
					  
                    <button type="submit" class="btn btn-success mr-2">@lang('dingsu.submit')</button>
					  <a href="/game/list" type="submit" class="btn btn-light mr-2">@lang('dingsu.back')</a>
                  </form>
              </div>
            </div>

<!-- ---------------------------------------------------------------------------------- -->
<div class="card-body">
	<h5 class="my-4">@lang('dingsu.gamelevels')</h5>
	<input type="hidden" name="gameID" id="gameID" value="{{ \Request::segment(3) }}">
	<div class="col-12 d-flex  text-right"><a href="/game/addlevel/{{$out->id}}" class="btn btn-success mr-2">@lang('dingsu.add_level')</a></div>
	<!-- <button type="button" name="add" id="add_data" class="btn btn-success btn-sm">@lang('dingsu.add_level')</button> -->

	<div id="gamelevel_table" class="table-responsive">
		<table class="table table-hover">
			<thead>
				<tr>
					<th>@lang('dingsu.gamelevel')</th>
					<th>@lang('dingsu.playtime')</th>
					<th>@lang('dingsu.bet_amount')</th>
					<th>@lang('dingsu.reward')</th>
					<th>@lang('dingsu.status')</th>
					<th class="">@lang('dingsu.action')</th>
				</tr>
			</thead>
			<tbody>
				@foreach($levels as $level)
				<tr id="tr_{{ $level->id }}">
					<td width ="10" >{{ $level->game_level }}</td>
					<td width ="10" >{{ $level->play_time }}</td>
					<td width ="10" >{{ $level->bet_amount }}</td>
					<td width ="10" >{{ $level->prize_reward }}</td>
					<td>
						@if($level->status == 0)
						<label class="badge badge-success">@lang('dingsu.active')</label> @elseif ($level->status == 1)
						<label class="badge badge-danger">@lang('dingsu.inactive')</label> @elseif ($level->status == 2)
						<label class="badge badge-info">@lang('dingsu.suspended')</label> @else @endif
					</td>
					<td>
					<a href="/game/level/edit/{{ $level->id }}"  class="btn btn-icons btn-rounded btn-outline-info btn-inverse-info"><i class=" icon-pencil "></i></a>
					<a href="javascript:void(0)" onClick="confirm_Delete({{ $level->id }}, '{{ csrf_token() }}')" class="btn btn-icons btn-rounded btn-outline-danger btn-inverse-danger"><i class=" icon-trash  "></i></a>
																	
					<!-- <a onClick="confirm_Delete({{ $level->id }}, '{{ csrf_token() }}')" data-token="{{ csrf_token() }}" href="#" class="btn btn-danger btn-fw">@lang('dingsu.delete')</a> -->
					</td>

					
				</tr>
				@endforeach
			</tbody>
		</table>
						<button type="submit" class="btn btn-success mr-2">@lang('dingsu.save')</button>
						<a href="/game/list" type="" class="btn btn-light mr-2">@lang('dingsu.back')</a>

	</div>
</div>		

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.26.11/sweetalert2.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.26.11/sweetalert2.all.min.js"></script>


<script language="javascript">
function confirm_Delete(id,token)
	{

Swal({
  title: '@lang("dingsu.delete_confirmation")',
  text: '@lang("dingsu.delete_conf_text")',
  type: 'warning',
  showCancelButton: true,
  confirmButtonText: '@lang("dingsu.delete")',
  cancelButtonText: '@lang("dingsu.cancel")',
	confirmButtonColor: "#DD6B55",
  closeOnConfirm: false
}).then((result) => {
  if (result.value) {
	  
	  $.ajax({
            url: "/game/level/delete/"+id,
            type: "POST",
            data: {_method: 'delete', _token :token},
            dataType: "html",
            success: function (data) {
				if (data === 'false')
					{
						swal('@lang("dingsu.delete_error")', '@lang("dingsu.try_again")', "error");
					}
				else 
					{
						swal("Done!", '@lang("dingsu.delete_success")', "success");
						
						$('#tr_'+id).hide(); 
					}
                
            },
            error: function (xhr, ajaxOptions, thrownError) {
                swal('@lang("dingsu.delete_error")', '@lang("dingsu.try_again")', "error");
            }
        });
	  
  } else if (result.dismiss === Swal.DismissReason.cancel) {
   
  }
})
	}
	
	
</script>

