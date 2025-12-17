# Copilot Instructions for SekolahBersih Project

## Project Overview
**SekolahBersih** is a Laravel 7-based school cleanliness evaluation system for Indonesian education administration. It manages cleanliness assessments across schools, with role-based dashboards for schools, inspectors (pengawas), district education offices (cabdis), and government agencies (dinas).

## Architecture & Key Components

### Application Structure
- **Model Namespace**: `App\models` (lowercase - non-standard Laravel convention)
- **Controllers**: Single letter capitalization (`SekolahBersihController`, `VerifikatorSekolahController`)
- **Routes**: Primarily MVC-based in `routes/web.php`, separated by feature (sekolahbersih, verifikator, page)
- **Views**: Blade templates in `resources/views/` organized by feature folders

### Core Modules
1. **SekolahBersih** (Main feature)
   - Assessment questionnaires (`EvaluasiKuesioner`)
   - Assessment results (`HasilKuesioner`) 
   - Verification workflow (`VerifikatorSekolah`)
   - Role-based views: school, inspector, district, government

2. **Data Master**
   - Schools (`Sekolah`), users (`User`), locations (`Provinsi`, `Kabupatenkota`, `Kecamatan`)
   - Configuration via `Parameter` model
   - Assessment criteria in `IconGrid`

3. **Authentication**
   - Custom `LoginController` using `password_hash` field (not Laravel's default)
   - Google OAuth integration (`GoogleAuthController`)
   - User fields: `is_active`, `is_verified`, `id_sekolah` (ties users to schools)

### Database Patterns
- MySQL with `utf8mb4_unicode_ci` collation
- Custom timestamp: `UPDATED_AT` → `last_update`
- School-centric foreign keys (`id_sekolah`, `sekolah` fields)
- No visible soft deletes; models use standard Eloquent

## Development Workflows

### Build & Serve
```bash
# Frontend asset compilation
npm run dev        # Development build
npm run watch      # Watch mode
npm run production # Production build

# PHP development server (if needed)
php artisan serve
```

### Key Artisan Commands
- `php artisan migrate` - Run pending migrations
- `php artisan tinker` - Interactive shell
- Database: MySQL configured in `.env` (DB_HOST, DB_USERNAME, etc.)

### Testing
- PHPUnit configuration in `phpunit.xml`
- Test location: `tests/` directory (Feature/ and Unit/ folders exist)
- Run with: `phpunit` or `php artisan test`

## Code Patterns & Conventions

### Model Conventions
- Namespace: `App\models` (lowercase, differs from PSR-4 convention)
- Always declare `$table` property explicitly
- Fillable arrays are comprehensive
- Custom timestamp fields via `const UPDATED_AT`

Example:
```php
namespace App\models;
class Sekolah extends Model {
    protected $table = 'sekolah';
    const UPDATED_AT = 'last_update';
    protected $fillable = ['nama', 'npsn', 'alamat_jalan', ...];
}
```

### Controller Patterns
- Fat controllers handling multiple concerns (views, data retrieval, PDF generation)
- Heavy use of `SekolahBersihController` (2400+ lines) for questionnaire logic
- Custom methods: `indexsekolah()`, `indexpengawas()`, `indexdinas()` for role-based views
- Data returned via `getData()` routes for DataTables AJAX consumption

### View Conventions
- Blade extensions with custom styling (e.g., `.widget-user-header`, `.card-footer`)
- Role-based conditional rendering based on `Auth::user()->role`
- jQuery DataTables integration for data grids
- Print functionality via `Pdf` facade (DomPDF)

### Authentication Flow
- Session-based guard ('web')
- Verify `is_active` AND `is_verified` flags
- User linked to school via `id_sekolah`
- Password hashed in `password_hash` column (not `password`)

## Integration Points & External Dependencies

### Key Packages
- **barryvdh/laravel-dompdf**: PDF generation (print routes)
- **yajra/laravel-datatables**: Server-side DataTables
- **spatie/laravel-permission**: Permission management
- **laravel/socialite**: OAuth (Google auth)
- **phpoffice/phpword**: Word document generation
- **realrashid/sweet-alert**: SweetAlert notifications

### API Routes
- Minimal API usage in `routes/api.php`
- Most functionality through web routes returning Blade views

### External Data Sources
- School data (`Sekolah` table)
- Geographic data (provinces, districts, subdistricts)
- User roles mapped to display different views

## Common Pitfalls & Important Notes

1. **Model Namespace**: Always use `App\models` (lowercase) not `App\Models`
2. **Authentication Field**: Use `password_hash`, not `password`
3. **User Association**: Schools-focused app - always link operations to `Auth::user()->id_sekolah`
4. **PDF Generation**: Routes ending in `/print` use DomPDF; watch for large view rendering
5. **DataTables**: `getData()` routes return formatted JSON for AJAX consumption
6. **Blade Components**: Custom CSS classes are defined in blade files, not all in external stylesheets
7. **Role-Based Logic**: Check `$user->role` field, may differ from permissions table

## File Reference Guide

| Pattern | Files |
|---------|-------|
| Main questionnaire logic | `app/Http/Controllers/SekolahBersihController.php` |
| Authentication | `app/Http/Controllers/Auth/LoginController.php` |
| Models | `app/models/*.php` (use lowercase namespace) |
| Views | `resources/views/{feature}/*.blade.php` |
| Routes | `routes/web.php` |
| Config | `config/app.php`, `config/auth.php`, `config/database.php` |
