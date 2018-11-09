<div class="col-12 grid-margin">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">@lang('dingsu.edit_level')</h4>
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
					           <label for="game_level" class="col-sm-3 col-form-label">@lang('dingsu.game') @lang('dingsu.level')</label>
                      <div class="col-sm-9">
                      <input id="game_level" name="game_level" class="form-control" type="text" autofocus value="{{ old('game_level', $levels->game_level) }}">
                    </div>
                </div>
             </div>
              <div class="col-md-6">
                <div class="form-group row">
                <label for="play_time" class="col-sm-3 col-form-label">@lang('dingsu.play') @lang('dingsu.time')</label>
                  <div class="col-sm-9">
                  <input id="play_time" name="play_time" class="form-control" type="text" value="{{ old('play_time', $levels->play_time) }}" maxlength="5">
                  </div>
                </div>
              </div>
            </div>





         <div class="row"> 
           <div class="col-md-6">
              <div class="form-group row">
               <label for="bet_amount" class="col-sm-3 col-form-label">@lang('dingsu.bet_amount')</label>
                <div class="col-sm-9">
                 <input id="bet_amount" name="bet_amount" class="form-control" type="text" required value="{{ $levels->bet_amount }}"   maxlength="5">
                </div>
              </div>
            </div>
					<div class="col-md-6">
						<div class="form-group row">
							<label for="prize_reward" class="col-sm-3 col-form-label">@lang('dingsu.prize_reward')</label>
							<div class="col-sm-9">
								<select id="prize_reward" name="prize_reward" class="form-control">
								<option {{old('prize_reward',$levels->prize_reward)=="0"? 'selected':''}}  value="0" >@lang('dingsu.category') 1</option>
								<option {{old('prize_reward',$levels->prize_reward)=="1"? 'selected':''}}  value="1" >@lang('dingsu.category') 2</option>
								<option {{old('prize_reward',$levels->prize_reward)=="2"? 'selected':''}}  value="2" >@lang('dingsu.category') 3</option>
								<option {{old('prize_reward',$levels->prize_reward)=="3"? 'selected':''}}  value="3" >@lang('dingsu.category') 4</option>
								</select>
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
							 <option {{old('status',$levels->status)=="0"? 'selected':''}}  value="0" >@lang('dingsu.active')</option>
							 <option {{old('status',$levels->status)=="1"? 'selected':''}}  value="1" >@lang('dingsu.inactive')</option>
							 <option {{old('status',$levels->status)=="2"? 'selected':''}}  value="2" >@lang('dingsu.reserved')</option>
                </select>
                  </div>
                </div>
              </div> 

					<div class="col-md-6">
            <div class="form-group row">
             <label for="point_reward" class="col-sm-3 col-form-label">@lang('dingsu.point_reward')</label>
              <div class="col-sm-9">
							<select id="point_reward" name="point_reward" class="form-control">
								<option {{old('point_reward',$levels->point_reward)=="0"? 'selected':''}}  value="0" >@lang('dingsu.no')</option>
								<option {{old('point_reward',$levels->point_reward)=="1"? 'selected':''}}  value="1" >@lang('dingsu.yes')</option>
								</select>
							  </div>
              </div>
            </div>
          </div>


          <div class="row"> 
					  <div class="col-md-6">
               <div class="form-group row">
                 <label for="notes" class="col-sm-3 col-form-label">@lang('dingsu.notes')</label>
                  <div class="col-sm-9">
                    <input id="notes" name="notes" class="form-control" type="text" value="{{ old('notes', $levels->notes) }}"  maxlength="5">
                  </div>
                </div>
            </div>
         </div>
				
					  
					
					  
                    <button type="submit" class="btn btn-success mr-2">@lang('dingsu.submit')</button>
					  <a href="/game/edit/{{ $levels->game_id }}" type="submit" class="btn btn-light mr-2">@lang('dingsu.back')</a>
                  </form>
              </div>
            </div>