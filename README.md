## Laravel DB Commands

Package with laravel database commands.

### Installation

```bash
composer require mcmatters/laravel-db-commands
```

Include the service provider within your `config/app.php` file.

```php
'providers' => [
    McMatters\DbCommands\ServiceProvider::class,
]
```

## Usage

Available commands:

* `php artisan db:drop-tables` — drops all tables.
* `php artisan migrate:single {file}` — migrate single migration by filename.
