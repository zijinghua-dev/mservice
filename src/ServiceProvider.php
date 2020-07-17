<?php
namespace Zijinghua\Mservice;

use Illuminate\Auth\RequestGuard;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Http\Request;
use Tymon\JWTAuth\JWTGuard;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function boot()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/auth.php', 'auth');
        $this->extendAuthGuard();
    }

    public function getUserUuid(Request $request)
    {
        return $request->input('usr')? $request->input('usr'):$request->header('usr');
    }

    protected function extendAuthGuard()
    {
        $callback = function (Request $request, UserProvider $provider) {
            return $provider->retrieveByCredentials(['uuid'=>$this->getUserUuid($request)]);
        };

        $this->app['auth']->extend('user', function ($app, $name, array $config) use ($callback) {
            $guard = new RequestGuard($callback, $this->app['request'], $app['auth']->createUserProvider($config['provider']));

            $this->app->refresh('request', $guard, 'setRequest');

            return $guard;
        });
    }

    protected function mergeConfigFrom($path, $key)
    {
        if (! $this->app->configurationIsCached()) {
            $this->app['config']->set($key, array_merge(
                $this->app['config']->get($key, []), require $path
            ));
        }
    }
}