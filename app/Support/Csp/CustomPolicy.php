<?php

namespace App\Support\Csp;

use Spatie\Csp\Directive;
use Spatie\Csp\Policies\Basic;

class CustomPolicy extends Basic
{
    public function configure()
    {
        parent::configure();

        $this
            ->addDirective(Directive::IMG, [
                'self',
                'res.cloudinary.com',
                '*.googleusercontent.com', // For Google OAuth avatars
                'data:', // Often needed for inline SVGs or Livewire/Filament assets
            ])
            ->addDirective(Directive::STYLE, [
                'self',
                'unsafe-inline', // Often required by Livewire and Filament
                'fonts.googleapis.com',
            ])
            ->addDirective(Directive::FONT, [
                'self',
                'fonts.gstatic.com',
            ])
            ->addDirective(Directive::SCRIPT, [
                'self',
                'unsafe-inline', // Required for Livewire/Alpine.js functionality
                'unsafe-eval',   // Required by some frontend build tools/Livewire
            ]);
    }
}