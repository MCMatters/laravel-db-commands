## Laravel DB Commands

Package with laravel database commands.

### Installation

```bash
composer require mcmatters/laravel-db-commands
```

If you don't use package discovering feature, then just include the service provider within your `config/app.php` file.

```php
'providers' => [
    McMatters\LaravelDbCommands\ServiceProvider::class,
]
```

## Usage

Available commands:

* `php artisan db:drop-tables` — drops all tables.
* `php artisan migrate:single {"file" or "class"}` — migrate single migration by file or class name.
* `php artisan migrate:drop-single {"file" or "class"}` — drop single migration by file or class name.
