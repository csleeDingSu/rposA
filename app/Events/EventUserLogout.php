<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class EventUserLogout implements ShouldBroadcast
{
    use SerializesModels;

    public $id;
	public $data;
	
    public function __construct($id = 73, $data = [])
    {
      $this->id   = $id;
	  $this->data   = $id;		
    }
    public function broadcastOn()
    {	
		\DB::table('redis')->where('member_id', $this->id)->delete();
		//return new PrivateChannel("user.{$this->id}.logout");
		echo 'imhere';
		//return ['userlogout-'. $this->id ];
		return ['userlogout' ];
		
		return ['userlogout-'. $this->id ];
    }
}
