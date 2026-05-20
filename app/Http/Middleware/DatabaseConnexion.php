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
      if (app()->environment('local')) {
        return $next($request);
      }

      $ddb_name = config('database.connections.mysql.database') ?: parse_url(str_replace("www.", "", $request->url()), PHP_URL_HOST);
      config(['database.connections.onthefly' => [
        'driver' => 'mysql',
        'url' => config('database.connections.mysql.url'),
        'host' => config('database.connections.mysql.host', '127.0.0.1'),
        'port' => config('database.connections.mysql.port', '3306'),
        'database' => $ddb_name,
        'username' => config('database.connections.mysql.username', 'root'),
        'password' => config('database.connections.mysql.password', ''),
        'unix_socket' => config('database.connections.mysql.unix_socket', ''),
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
