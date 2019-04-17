<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class EventDashboardChannel implements ShouldBroadcast
{
    use SerializesModels;

    public $data;
	public $channel;

    public function __construct($channel, $data = [])
    {
      $this->data    = $data;
	  $this->channel = $channel;
    }

    public function broadcastOn()
    {
		return [$this->channel];
    }

    public function broadcastWith()
	{
	    return ['data' => $this->data];
	}
}
