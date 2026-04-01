<?php

namespace App\Enums;

enum ApplicationStatus: string
{
    case Saved = 'saved';
    case Applied = 'applied';
    case Interviewing = 'interviewing';
    case Offered = 'offered';
    case Rejected = 'rejected';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Saved => 'Wishlist',
            self::Applied => 'Applied',
            self::Interviewing => 'Interviewing',
            self::Offered => 'Offer Received',
            self::Rejected => 'Rejected',
        };
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::Saved => 'gray',
            self::Applied => 'info',
            self::Interviewing => 'warning',
            self::Offered => 'success',
            self::Rejected => 'danger',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::Saved => 'heroicon-m-bookmark',
            self::Applied => 'heroicon-m-paper-airplane',
            self::Interviewing => 'heroicon-m-chat-bubble-left-right',
            self::Offered => 'heroicon-m-star',
            self::Rejected => 'heroicon-m-x-circle',
        };
    }
}