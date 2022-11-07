<?php

namespace App\Events\Models\Offers;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OffersUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    protected $offer;

    /**
     * Create a new event instance.
     * @param Post $model
     * @return void
     */
    public function __construct( $offer )
    {
        $this->offer = $offer;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PresenceChannel('offers.post.' . $this->offer->id);
    }

    public function broadcastAs()
    {
        return 'offers.updated';
    }

    public function broadcastWith()
    {
        return [
            'offer' => $this->offer,
        ];
    }
}
