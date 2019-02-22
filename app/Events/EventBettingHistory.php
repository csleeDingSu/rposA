<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class EventBettingHistory implements ShouldBroadcast
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
		if (!empty($this->id))
		{
			return ['bettinghistory-'. $this->id ];
		}
		return ['bettinghistory'];
    }
}
