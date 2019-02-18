<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class EventNoBetting implements ShouldBroadcast
{
    use SerializesModels;

    public $data;
	public $id;
	public $type;
	
    public function __construct($id, $data,$type = FALSE)
    {
      $this->id   = $id;
	  $this->data = $data;
	  $this->type = $type;
    }
    public function broadcastOn()
    {
		$id = $this->id;
		$this->id = NULL;
		return $id;
		/*if (!$this->type)
		{
			return ['no-betting-user-'. $this->id ];
		}		
		return ['no-vipbetting-user-'. $this->id ];
		*/
    }
}
