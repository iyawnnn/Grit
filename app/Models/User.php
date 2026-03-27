<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;

// 1. Add the FilamentUser interface to the class definition
class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    // 2. Add this required method to grant access to the panel
    public function canAccessPanel(Panel $panel): bool
    {
        // This line checks if the user's email ends with a specific domain,
        // or you can simply return true to let ANY registered user log in.
        // Since this is a personal portfolio app, letting anyone log in is fine:
        return true; 
        
        // OR, if you ONLY want yourself to access it, change it to this:
        // return $this->email === 'your.actual.email@gmail.com';
    }
}