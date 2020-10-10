<?php

declare(strict_types=1);

use Illuminate\Config\Repository as Config;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Application as Laravel;
use Illuminate\Foundation\Bootstrap\LoadConfiguration;

$app = new Laravel(dirname(__DIR__));

$app->instance(LoadConfiguration::class, new class {
    public function bootstrap(Application $app) {
        return;
    }
});

$providers = [
    Illuminate\Auth\AuthServiceProvider::class,
    Illuminate\Broadcasting\BroadcastServiceProvider::class,
    Illuminate\Bus\BusServiceProvider::class,
    Illuminate\Cache\CacheServiceProvider::class,
    Illuminate\Foundation\Providers\ConsoleSupportServiceProvider::class,
    Illuminate\Cookie\CookieServiceProvider::class,
    Illuminate\Database\DatabaseServiceProvider::class,
    Illuminate\Encryption\EncryptionServiceProvider::class,
    Illuminate\Filesystem\FilesystemServiceProvider::class,
    Illuminate\Foundation\Providers\FoundationServiceProvider::class,
    Illuminate\Hashing\HashServiceProvider::class,
    Illuminate\Mail\MailServiceProvider::class,
    Illuminate\Notifications\NotificationServiceProvider::class,
    Illuminate\Pagination\PaginationServiceProvider::class,
    Illuminate\Pipeline\PipelineServiceProvider::class,
    Illuminate\Queue\QueueServiceProvider::class,
    Illuminate\Redis\RedisServiceProvider::class,
    Illuminate\Auth\Passwords\PasswordResetServiceProvider::class,
    Illuminate\Session\SessionServiceProvider::class,
    Illuminate\Translation\TranslationServiceProvider::class,
    Illuminate\Validation\ValidationServiceProvider::class,
    Illuminate\View\ViewServiceProvider::class,
    App\HelloWorld\ServiceProvider::class,
];

$app->instance('config', new Config([
    'app' => [
        'name' => 'Laravel Project',
        $app->env = 'env' => env('APP_ENV', 'production'),
        'debug' => env('APP_DEBUG', false),
        'url' => env('APP_URL', 'http://localhost'),
        'asset_url' => env('ASSET_URL', null),
        'timezone' => (static function (string $timezone): string {
            date_default_timezone_set($timezone);
            return $timezone;
        })('UTC'),
        'locale' => 'en',
        'fallback_locale' => 'en',
        'key' => env('APP_KEY'),
        'cipher' => 'AES-256-CBC',
        'providers' => $providers,
    ],
    'auth' => [
        [
            'defaults' => [
                'guard' => 'web',
            ],
            'guards' => [
                'web' => [
                    'driver' => 'session',
                ],
            ],
        ],
    ],
    'cache' => [
        'default' => env('CACHE_DRIVER', 'array'),
        'stores' => [
            'array' => [
                'driver' => 'array',
            ],
        ],
    ],
    'logging' => [
        [
            'default' => env('LOG_CHANNEL', 'stdout'),
            'channels' => [
                'stdout' => [
                    'driver' => 'monolog',
                    'handler' => StreamHandler::class,
                    'with' => [
                        'stream' => 'php://stdout',
                        'level' => 'warning',
                    ],
                ],
            ],
        ],
    ],
    'session' => [
        'driver' => env('SESSION_DRIVER', 'array'),
    ],
    'view' => [
        'paths' => [
            resource_path('views'),
        ],
        'compiled' => realpath(storage_path('framework/views')),
    ],
]));

$app->singleton(
    Illuminate\Contracts\Http\Kernel::class,
    Illuminate\Foundation\Http\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    Illuminate\Foundation\Console\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    Illuminate\Foundation\Exceptions\Handler::class
);

return $app;
