<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class EventGameSetting implements ShouldBroadcast
{
    use SerializesModels;

    public $data;
	public $id;
	public $type;
	
    public function __construct($id, $data, $onload = FALSE)
    {
      $this->id   = $id;
	  $this->data = $data; 
	  $this->type = $onload; 
	  
    }
    public function broadcastOn()
    {
		if ($this->type) return ['loadsetting-'. $this->id ];
		
		return ['initsetting-'. $this->id ];
    }
}
