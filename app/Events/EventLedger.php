<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;


class EventLedger implements ShouldBroadcast
{
    use SerializesModels;

    public $data;
	public $id;

    public function __construct($id, $data)
    {
      $this->id     = $id;
		$this->data = $data;
    }

    public function broadcastOn()
    {
		return ['ledger-'. $this->id ];
    }
	
	public function broadcastWith()
	{
		return [ 'data' => $this->data ];
		return [ 'data' => \App\Ledger::get_wallet_details($this->id) ];
	}	
	
}
