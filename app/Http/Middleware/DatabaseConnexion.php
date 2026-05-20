<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use PDO;
use Tymon\JWTAuth\Facades\JWTAuth;

class DatabaseConnexion
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
      // En local (APP_ENV=local), on utilise directement la connexion définie dans .env
      if (env('APP_ENV') === 'local') {
        return $next($request);
      }

      $ddb_name = env('DB_DATABASE') ?: parse_url(str_replace("www.", "", $request->url()), PHP_URL_HOST);
      config(['database.connections.onthefly' => [
        'driver' => 'mysql',
        'url' => env('DATABASE_URL'),
        'host' => env('DB_HOST', '127.0.0.1'),
        'port' => env('DB_PORT', '3306'),
        'database' => $ddb_name,
        'username' => env('DB_USERNAME', 'root'),
        'password' => env('DB_PASSWORD', 'tomay46'),
        'unix_socket' => env('DB_SOCKET', ''),
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
        'prefix' => '',
        'prefix_indexes' => true,
        'strict' => true,
        'engine' => null,
        'options' => extension_loaded('pdo_mysql') ? array_filter([
            PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
        ]) : [],
      ]]);
      Config::set('database.default', 'onthefly');

      return $next($request);
    }
}
