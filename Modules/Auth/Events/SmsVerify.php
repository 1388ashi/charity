<?php

namespace Modules\Auth\Events;

use Illuminate\Queue\SerializesModels;

class SmsVerify
{
    use SerializesModels;

    /**
     * @var string
     */
    public string $mobile;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(string $mobile)
    {
        $this->mobile = $mobile;
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
