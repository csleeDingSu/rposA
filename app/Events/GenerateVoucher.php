<?php

namespace App\Events;
 
use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Http\Request;
 
class GenerateVoucher extends Event
{
    use SerializesModels;
 
    public $user;
 
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Request $request,$fname)
    {
        $this->request  = $request;
		$this->filename = $fname;
    }
 
    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}