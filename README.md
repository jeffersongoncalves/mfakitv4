<div class="filament-hidden">

![EvolutionKit](https://raw.githubusercontent.com/jeffersongoncalves/evolutionkitv4/4.x/art/jeffersongoncalves-evolutionkitv4.png)

</div>

# EvolutionKit Start Kit Filament 4.x and Laravel 12.x

## About EvolutionKit

EvolutionKit is a robust starter kit built on Laravel 12.x and Filament 4.x, designed to accelerate the development of modern
web applications with a ready-to-use multi-panel structure.

## Features

- **Laravel 12.x** - The latest version of the most elegant PHP framework
- **Filament 4.x** - Powerful and flexible admin framework
- **Multi-Panel Structure** - Includes three pre-configured panels:
    - Admin Panel (`/admin`) - For system administrators
    - App Panel (`/app`) - For authenticated application users
    - Public Panel (frontend interface) - For visitors
- **Environment Configuration** - Centralized configuration through the `config/evolutionkit.php` file

## System Requirements

- PHP 8.3 or higher
- Composer
- Node.js and PNPM

## Installation

Clone the repository
``` bash
laravel new my-app --using=jeffersongoncalves/evolutionkitv4 --database=mysql
```

###  Easy Installation

EvolutionKit can be easily installed using the following command:

```bash
php install.php
```

This command automates the installation process by:
- Installing Composer dependencies
- Setting up the environment file
- Generating application key
- Setting up the database
- Running migrations
- Installing Node.js dependencies
- Building assets
- Configuring Herd (if used)

### Manual Installation

Install JavaScript dependencies
``` bash
pnpm install
```
Install Composer dependencies
``` bash
composer install
```
Set up environment
``` bash
cp .env.example .env
php artisan key:generate
```

Configure your database in the .env file

Run migrations
``` bash
php artisan migrate
```
Run the server
``` bash
php artisan serve
```

## Installation with Docker

Clone the repository
```bash
laravel new my-app --using=jeffersongoncalves/evolutionkitv4 --database=mysql
```

Move into the project directory
```bash
cd my-app
```

Install Composer dependencies
```bash
composer install
```

Set up environment
```bash
cp .env.example .env
```

Configuring custom ports may be necessary if you have other services running on the same ports.

```bash
# Application Port (ex: 8080)
APP_PORT=8080

# MySQL Port (ex: 3306)
FORWARD_DB_PORT=3306

# Redis Port (ex: 6379)
FORWARD_REDIS_PORT=6379

# Mailpit Port (ex: 1025)
FORWARD_MAILPIT_PORT=1025
```

Start the Sail containers
```bash
./vendor/bin/sail up -d
```
You won’t need to run `php artisan serve`, as Laravel Sail automatically handles the development server within the container.

Attach to the application container
```bash
./vendor/bin/sail shell
```

Generate the application key
```bash
php artisan key:generate
```

Install JavaScript dependencies
```bash
pnpm install
```

## Authentication Structure

EvolutionKit comes pre-configured with a custom authentication system that supports different types of users:

- `Admin` - For administrative panel access
- `User` - For application panel access

## Development

``` bash
# Run the development server with logs, queues and asset compilation
composer dev

# Or run each component separately
php artisan serve
php artisan queue:listen --tries=1
pnpm run dev
```

## Customization

### Panel Configuration

Panels can be customized through their respective providers:

- `app/Providers/Filament/AdminPanelProvider.php`
- `app/Providers/Filament/AppPanelProvider.php`
- `app/Providers/Filament/PublicPanelProvider.php`

Alternatively, these settings are also consolidated in the `config/evolutionkit.php` file for easier management.

### Themes and Colors

Each panel can have its own color scheme, which can be easily modified in the corresponding Provider files or in the
`evolutionkit.php` configuration file.

### Configuration File

The `config/evolutionkit.php` file centralizes the configuration of the starter kit, including:

- Panel routes
- Middleware for each panel
- Branding options (logo, colors)
- Authentication guards

## User Profile — joaopaulolndev/filament-edit-profile

This project already comes with the Filament Edit Profile plugin integrated for the Admin and App panels. It adds a complete profile editing page with avatar, language, theme color, security (tokens, MFA), browser sessions, and email/password change.

- Routes (defaults in this project):
  - Admin: /admin/my-profile
  - App: /app/my-profile
- Navigation: by default, the page does not appear in the menu (shouldRegisterNavigation(false)). If you want to show it in the sidebar menu, change it to true in the panel provider.

Where to configure
- Panel providers
  - Admin: app/Providers/Filament/AdminPanelProvider.php
  - App: app/Providers/Filament/AppPanelProvider.php
  In these files you can adjust:
  - ->slug('my-profile') to change the URL (e.g., 'profile')
  - ->setTitle('My Profile') and ->setNavigationLabel('My Profile')
  - ->setNavigationGroup('Group Profile'), ->setIcon('heroicon-o-user'), ->setSort(10)
  - ->shouldRegisterNavigation(true|false) to show/hide it in the menu
  - Shown forms: ->shouldShowEmailForm(), ->shouldShowLocaleForm([...]), ->shouldShowThemeColorForm(), ->shouldShowSanctumTokens(), ->shouldShowMultiFactorAuthentication(), ->shouldShowBrowserSessionsForm(), ->shouldShowAvatarForm()

- General settings: config/filament-edit-profile.php
  - locales: language options available on the profile page
  - locale_column: column used in your model for language/locale (default: locale)
  - theme_color_column: column for theme color (default: theme_color)
  - avatar_column: avatar column (default: avatar_url)
  - disk: storage disk used for the avatar (default: public)
  - visibility: file visibility (default: public)

Migrations and models
- The required columns are already included in this kit’s default migrations (users and admins): avatar_url, locale and theme_color, using the names defined in config/filament-edit-profile.php.
- The App\Models\User and App\Models\Admin models already read the avatar using the plugin configuration (getFilamentAvatarUrl).

Avatar storage
- Make sure the filesystem disk is configured and that the storage link exists:
  php artisan storage:link
- Adjust the disk and visibility in the config file according to your infrastructure.

Quick access
- Via direct URL: /admin/my-profile or /app/my-profile
- To make it visible in the sidebar navigation, set shouldRegisterNavigation(true) in the respective Provider.

Reference
- Plugin repository: https://github.com/joaopaulolndev/filament-edit-profile

## WhatsApp Connector — wallacemartinss/filament-whatsapp-conector

This starter kit ships with the WhatsApp Connector plugin (Evolution API v2 client) already required in `composer.json` and registered in the Admin panel. It lets you manage WhatsApp instances, display live QR Codes to connect, log webhooks, and send messages (text, images, videos, audio, documents) from Filament actions or your own services.

What’s already configured in this kit
- Dependency: `wallacemartinss/filament-whatsapp-conector` is included
- Admin panel registration: see `app/Providers/Filament/AdminPanelProvider.php` where `FilamentEvolutionPlugin::make()->whatsappInstanceResource()->viewMessageHistory()->viewWebhookLogs()` is added

1) Publish config and run migrations
```bash
php artisan vendor:publish --tag="filament-evolution-config"
php artisan vendor:publish --tag="filament-evolution-migrations"
php artisan migrate
```

2) Environment variables (.env)
Add your Evolution API credentials and webhook settings:
```env
# Evolution API connection (required)
EVOLUTION_URL=https://your-evolution-api.com
EVOLUTION_API_KEY=your_api_key

# Webhook URL (required to receive events)
# Use the public URL to your app’s webhook endpoint (see below):
EVOLUTION_WEBHOOK_URL=https://your-app.com/api/webhooks/evolution

# Optional security secret (recommended)
EVOLUTION_WEBHOOK_SECRET=your_secret_key

# Optional defaults (useful for single‑instance setups)
EVOLUTION_DEFAULT_INSTANCE=your_instance_id
```

3) Webhook endpoint
- The plugin exposes an endpoint for Evolution API to POST events (QR updates, messages, connection changes, etc.).
- Set `EVOLUTION_WEBHOOK_URL` to your public URL pointing to: `https://your-app.com/api/webhooks/evolution`.
- Ensure your app is accessible publicly and that the route is not blocked by auth or CSRF.

4) Optional configuration (config/filament-evolution.php)
After publishing, you can tune behaviors such as queues, storage, cleanup, and tenancy. Key options:
```php
return [
    'queue' => [
        'enabled' => true,
        'connection' => null, // default connection
        'name' => 'default',
    ],
    'storage' => [
        'webhooks' => true,   // persist webhook payloads
        'messages' => true,   // persist sent/received messages
    ],
    'cleanup' => [
        'webhooks_days' => 30,
        'messages_days' => 90,
    ],
    'instance' => [
        'reject_call' => false,
        'always_online' => false,
        // ...other defaults
    ],
    'tenancy' => [
        'enabled' => false,
        'column' => 'team_id',
        'table' => 'teams',
        'model' => 'App\\Models\\Team',
    ],
];
```

5) Managing WhatsApp instances (Admin panel)
1. Go to: WhatsApp > Instances
2. Create a new instance (name/phone)
3. Save to open the QR Code modal
4. Scan the QR Code with your WhatsApp
5. Watch status updates (Always Online, Read Messages, Reject Calls, etc.)

6) Sending messages
The plugin provides three ways to send WhatsApp messages:
- Filament Action (UI): attach `SendWhatsappMessageAction` to tables/pages/widgets
- Facade: quick sending from anywhere in your code
- Trait: integrate into your services for reusable sending logic

Examples (UI actions)
```php
use WallaceMartinss\FilamentEvolution\Actions\SendWhatsappMessageAction;

// In a resource table
public function table(Table $table): Table
{
    return $table
        ->actions([
            SendWhatsappMessageAction::make(),
        ]);
}

// In a page header
protected function getHeaderActions(): array
{
    return [
        SendWhatsappMessageAction::make()
            // Optional sensible defaults
            ->number('5511999999999')
            ->message('Hello from EvolutionKit!'),
    ];
}
```

Prefilling from records
```php
SendWhatsappMessageAction::make()
    ->numberFrom('phone')                // attribute on the record
    ->instanceFrom('whatsapp_instance_id');
```

Limiting message types or hiding fields
```php
use WallaceMartinss\FilamentEvolution\Enums\MessageTypeEnum;

SendWhatsappMessageAction::make()
    ->allowedTypes([MessageTypeEnum::TEXT, MessageTypeEnum::IMAGE])
    ->hideInstanceSelect()
    ->hideNumberInput()
    ->textOnly();
```

Media storage (optional)
```env
EVOLUTION_MEDIA_DISK=public
EVOLUTION_MEDIA_DIRECTORY=whatsapp-media
EVOLUTION_MEDIA_MAX_SIZE=16384
```
You can also specify a custom disk per action: `SendWhatsappMessageAction::make()->disk('s3');`

7) Multi‑tenancy (optional)
If you use Filament’s native tenancy, enable it so all resources are scoped by tenant:
```env
EVOLUTION_TENANCY_ENABLED=true
EVOLUTION_TENANT_COLUMN=team_id
EVOLUTION_TENANT_TABLE=teams
EVOLUTION_TENANT_MODEL=App\Models\Team
EVOLUTION_TENANT_COLUMN_TYPE=uuid
```

8) Cleanup command
Remove old webhook/message records automatically:
```bash
php artisan evolution:cleanup           # uses config defaults
php artisan evolution:cleanup --dry-run # preview deletions
php artisan evolution:cleanup --webhooks-days=7 --messages-days=30
```
Schedule it (example):
```php
// routes/console.php
use Illuminate\Support\Facades\Schedule;
Schedule::command('evolution:cleanup')->daily();
```

Troubleshooting
- QR Code does not appear: verify `EVOLUTION_URL` and `EVOLUTION_API_KEY`, and that your Evolution API v2 instance is reachable from the app
- Webhooks not received: confirm `EVOLUTION_WEBHOOK_URL` is a public HTTPS URL to `/api/webhooks/evolution`, no auth/CSRF blocking, and that your hosting firewall allows inbound requests
- Media uploads failing: check `EVOLUTION_MEDIA_DISK` permissions and file size limits
- Messages queued but not sent: ensure queues are running (e.g., `php artisan queue:listen`) and that the configured queue connection is available

Reference
- Plugin repository: https://github.com/wallacemartinss/filament-whatsapp-conector

## Resources

EvolutionKit includes support for:

- User and admin management
- Multi-guard authentication system
- Tailwind CSS integration
- Database queue configuration
- Customizable panel routing and branding

## License

This project is licensed under the [MIT License](LICENSE).

## Credits

Developed by [Jefferson Gonçalves](https://github.com/jeffersongoncalves).
