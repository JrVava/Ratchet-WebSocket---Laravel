<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class WebSocketMessageSent
{
    use Dispatchable, SerializesModels;

    public $type;
    public $message;
    public $targetId;

    /**
     * Create a new event instance.
     *
     * @param string $type
     * @param string $message
     * @param int|null $targetId
     */
    public function __construct($type, $message, $targetId = null)
    {
        $this->type = $type;
        $this->message = $message;
        $this->targetId = $targetId;
    }
}
