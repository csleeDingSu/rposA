<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;


class EventWalletUpdate implements ShouldBroadcast
{
    use SerializesModels;

    public $data;
	public $id;

    public function __construct($id)
    {
      $this->id   = $id;
    }

    public function broadcastOn()
    {
		return ['wallet-'. $this->id ];
    }
	
	public function broadcastWith()
	{
		return [ 'data' => \App\Ledger::all_ledger($this->id) ];
	}	
	
}
