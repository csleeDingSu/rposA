<?php
/***
 *
 *
 ***/

namespace App\Http\Controllers;
use DB;
use App;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

use App\Game;

class GameController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
	
	public function index() {
		return self::get_game();
	}
	
	public function get_game_list()
	{
		
		$result =  DB::table('games')->paginate(25);
		$data['page'] = 'game.gamelist'; 
				
		$data['result'] = $result;
		
		return view('main', $data);
	}
	
	public function new_game ()
	{
		$data['page'] = 'game.newgame';
			
		return view('main', $data);
	}
	
	public function save_game(Request $request)
	{		
		$validator = $this->validate(
            $request,
            [
                'game_name' => 'required|string|min:4',
                'game_id' => 'required|min:6|unique:games,game_id',
            ]
        );
		
		try{
		    $game = new Game();
			$game->game_name = $request->game_name;
			$game->game_id = $request->game_id;
			$game->game_status = $request->status;
			$game->category = $request->category;
			$game->membership = $request->membership;
			$game->notes = $request->notes;

			$game->save();
		}
		catch(\Exception $e){
		   echo $e->getMessage();   die();
		}
		
		
		return redirect()->back()->with('message', trans('dingsu.game_success_save_message') );
		
		//@todo : add mail
		//self::sendmail($request->all());
		
		
	}
	
	public function add_level($id)
	{
		$data['page'] = 'game.addlevel'; 
		return view('main', $data);


	}

	public function update_level(Request $request)
	{
		if($request->get('button_action')=="insert")
		{
			$game = new Game([
				'level_id' =>$request->get('level_id')
				,
				'reward' =>$request->get('reward')
			]);
			$game->save();



		}
	}
	
	public function edit_game($id)
	{

		
		$data['out'] = $game = Game::get_game($id);
		
		$data['page'] = 'common.error';
		
		if ($game)
		{
			$data['page'] = 'game.editgame';
			
			$data['levels'] = Game::get_gamelevel($id);
			
		}		
		
		return view('main', $data);
		
	}


	public function update_game ($id)
	{

		
		$data['out'] = $game = Game::get_game($id);
		
		$data['page'] = 'common.error';
		
		if ($game)
		{
			$data['page'] = 'game.editgame';
			
			$data['levels'] = Game::get_gamelevel($id);
			
		}		
		
		return view('main', $data);
		
	}


	
	public function get_game_levels($gameid = FALSE)
	{
		if ($gameid == FALSE) return FALSE; 
	}
	
	public function get_game_level_options()
	{
		
	}
	
	public function get_game_result()
	{
		
	}









	
}
