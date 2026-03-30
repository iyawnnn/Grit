<?php

namespace App\Events;

use App\Models\MatchReport;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MatchReportUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public MatchReport $matchReport)
    {
    }

    public function broadcastOn(): array
    {
        return [
            new Channel('match-reports.' . $this->matchReport->user_id),
        ];
    }
}