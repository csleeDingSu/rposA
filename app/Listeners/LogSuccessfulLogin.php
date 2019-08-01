<?php

namespace App\Listeners;
use Illuminate\Auth\Events\Login;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Carbon\Carbon;

class LogSuccessfulLogin
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  GenerateVoucher  $event
     * @return void
     */
    public function handle(Login $event)
    {
		$user = \Auth::guard('member')->user();
		
		if (!$user) return false;
		
		if ($user->is_purged_gamelife != 1)
		{
			$usedlife = \App\Game::IsFirstLife($user->id);
						
			if ($usedlife < 1)
			{
				if (Carbon::parse($user->created_at)->lt(Carbon::now()->subDay(1)))
				{
					$wallet = \App\Wallet::get_wallet_details($user->id);
					
					if (!empty($wallet->life))
					{
						//reduce one life 
						\App\Wallet::update_basic_wallet($user->id,1,0,'PWL','deduct', '.Auto purged 1 life');
						\Log::debug(json_encode(['purged life' => 1,'phone'=>$user->phone,'wechat_name'=>$user->wechat_name], true));
					}					
					//update flag
					$user->is_purged_gamelife = 1;
					$user->save();
				}	
			}
			else
			{
				//update flag
				$user->is_purged_gamelife = 1;
				$user->save();
			}	
		}
	}
	




}