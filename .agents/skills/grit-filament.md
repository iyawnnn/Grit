# @grit-filament
Description: Rules for modifying and extending the Filament PHP admin panel in Grit.

## Version Control
* Version: This project uses Filament v5. 

## Strict Implementation Rules
* Namespaces: When overriding or creating authentication pages, ALWAYS use the updated v5 namespaces (e.g., `use Filament\Auth\Pages\Login;` and `use Filament\Auth\Pages\Register;`). Do NOT use `Filament\Pages\Auth\...`.
* Form Bindings: When creating custom Blade views for Filament pages, you must use Livewire bindings (e.g., `wire:submit`, `wire:model.defer`) instead of standard HTML form `action` or `method` attributes.
* UI Components: Utilize Filament's built-in Form Builder and Table Builder classes for all dashboard CRUD operations to maintain a consistent admin UI.