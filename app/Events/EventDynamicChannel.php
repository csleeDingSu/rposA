<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class EventDynamicChannel implements ShouldBroadcastNow
{
    use SerializesModels;

    public $data;
	public $id;
	public $channel;
	
    public function __construct($channel, $id = NULL, $data = [])
    {
      $this->data    = $data;
	  $this->id      = $id;
	  $this->channel = $channel;
    }

    public function broadcastOn()
    {
		return [$this->channel];
    }

    public function broadcastWith()
	{
	    return ['data' => $this->data,'id'=>$this->id];
	}
}
