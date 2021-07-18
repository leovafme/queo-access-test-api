<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\UrlGenerator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            \Auth0\Login\Contract\Auth0UserRepository::class,
            \App\Repositories\CustomUserRepository::class,
        );

        $this->app->bind(
            \App\Repositories\CompanyRepositoryInterface::class,
            \App\Repositories\CompanyRepository::class,
        );

        $this->app->bind(
            \App\Repositories\EmployeeRepositoryInterface::class,
            \App\Repositories\EmployeeRepository::class,
        );

        if (env('REDIRECT_HTTPS')) {
            $this->app['request']->server->set('HTTPS', true);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(UrlGenerator $url)
    {
        if (env('REDIRECT_HTTPS')) {
            $url->formatScheme('https://');
        }
    }
}
