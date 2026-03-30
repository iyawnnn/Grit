# Grit Project Rules

## Core Architecture
* Framework: Laravel 12 and PHP 8.4
* Admin Panel: Filament v5
* Styling: Tailwind CSS v4

## Brand and Design Guidelines
* Color Palette: Use a soft orange accent (#FF8A5B), alabaster background (#FAF8F5), and ink black text (#2D2A26).
* Typography: Use the Inter font for everything.
* Layout: Default to clean, minimalist, and editorial designs.
* Tech Stack: Strictly use Tailwind CSS v4 utility classes. No arbitrary values.

## Backend and Authentication Rules
* When generating authentication views or custom pages, always use Filament v5 namespaces (example: `Filament\Auth\Pages\Login`).
* Use Livewire bindings (like `wire:submit`) instead of standard HTML form actions for all dashboard views.
* Always secure API routes using Laravel Sanctum.
* Implement Google OAuth using Laravel Socialite.

## Coding Standards
* Keep code comments minimal. Only explain complex logic.
* Use strict typing in all PHP files.
* Ensure all images have SEO-optimized alt text.
* Use PascalCase for classes, camelCase for methods, and snake_case for database columns.