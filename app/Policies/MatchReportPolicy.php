<?php

namespace App\Policies;

use App\Models\MatchReport;
use App\Models\User;

class MatchReportPolicy
{
    public function view(User $user, MatchReport $matchReport): bool
    {
        return $user->id === $matchReport->user_id;
    }

    public function update(User $user, MatchReport $matchReport): bool
    {
        return $user->id === $matchReport->user_id;
    }

    public function delete(User $user, MatchReport $matchReport): bool
    {
        return $user->id === $matchReport->user_id;
    }
}