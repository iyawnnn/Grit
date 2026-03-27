<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum ApplicationStatus: string implements HasColor, HasIcon, HasLabel
{
    case Matched = 'matched';
    case Applied = 'applied';
    case Interviewing = 'interviewing';
    case Offered = 'offered';
    case Hired = 'hired';
    case Rejected = 'rejected';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Matched => '1. Matched',
            self::Applied => '2. Applied',
            self::Interviewing => '3. Interviewing',
            self::Offered => '4. Offer Received',
            self::Hired => '5. Hired',
            self::Rejected => 'Rejected',
        };
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::Matched => 'gray',
            self::Applied => 'info',
            self::Interviewing => 'warning',
            self::Offered => 'success',
            self::Hired => 'success',
            self::Rejected => 'danger',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::Matched => 'heroicon-m-sparkles',
            self::Applied => 'heroicon-m-paper-airplane',
            self::Interviewing => 'heroicon-m-chat-bubble-left-right',
            self::Offered => 'heroicon-m-star',
            self::Hired => 'heroicon-m-check-badge',
            self::Rejected => 'heroicon-m-x-circle',
        };
    }
}