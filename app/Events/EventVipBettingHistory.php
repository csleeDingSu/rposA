<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class EventVipBettingHistory implements ShouldBroadcast
{
    use SerializesModels;

    public $data;
	public $id;
	
    public function __construct($data, $id = FALSE)
    {
      $this->data   = $data;
	  $this->id     = $id;
    }

    public function broadcastOn()
    {
		echo $this->id;
        if (!empty($this->id))
		{
			return ['vipbettinghistory-'. $this->id ];
		}
		return ['vipbettinghistory'];
    }
}
