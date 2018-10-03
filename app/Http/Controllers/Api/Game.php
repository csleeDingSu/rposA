<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Game;

class Game extends Controller
{
    
	public function listgames()
    {
	}
	
	public function listgamelevels($gameid = false)
    {
	}
	
	public function showresult($gameid = false, $levelid = false)
    {
	}
	
   
    public function show($cid = false)
    {
        if ($cid)
		{
			$vouchers = Unreleasedvouchers::latest()->where('category' ,'=' , $cid)->paginate(10);
		}
		else{
			$vouchers = Unreleasedvouchers::latest()->paginate(10);
		}
		
		$category = Category::all();
		//print_r($category);die();
        return view('client.home', compact('vouchers','category'));		
		
    }
	
	
	public function test(Voucher $signature)
    {
       $signatures = Voucher::latest()
            ->paginate(20);

        return SignatureResource::collection($signatures);
		
		return new SignatureResource($signature);
    }

    
    public function store(Request $request)
    {
        $signature = $this->validate($request, [
            'name' => 'required|min:3|max:50',
            'email' => 'required|email',
            'body' => 'required|min:3'
        ]);

        $signature = Game::create($signature);

        return new SignatureResource($signature);
    }
}