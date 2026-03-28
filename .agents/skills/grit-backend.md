# @grit-backend
Description: Core backend architecture, security, and PHP coding standards for Grit.

## Stack & Standards
* Framework: Laravel 12 running on PHP 8.4.
* Typing: Enforce strict typing (`declare(strict_types=1);`) in all new PHP files. Use PHP 8.4 features like readonly properties and match expressions where appropriate.
* Naming Conventions: 
  - Classes/Models: PascalCase
  - Methods: camelCase
  - Database Columns: snake_case
  - URLs/Routes: kebab-case
* Documentation: Keep code comments minimal. Only explain highly complex business logic.

## Security & Routing
* API Security: All API endpoints must be protected using Laravel Sanctum.
* OAuth Integration: Manage third-party logins (Google) exclusively via Laravel Socialite.
* Business Logic: Keep controllers extremely thin. Move data manipulation and business logic into dedicated Service classes or Actions.
* Validation: Always use Form Request classes for incoming data validation before processing.