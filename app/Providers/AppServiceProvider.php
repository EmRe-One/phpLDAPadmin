<?php

namespace App\Providers;

use App\Ldap\LdapUserRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;
use LdapRecord\Configuration\DomainConfiguration;
use LdapRecord\Laravel\LdapRecord;

class AppServiceProvider extends ServiceProvider {
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        // Add a new option available to be set in the configuration:
        DomainConfiguration::extend('name', $default = null);

        // Use our LdapUserRepository to support multiple baseDN querying
        LdapRecord::locateUsersUsing(LdapUserRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
        $this->loadViewsFrom(__DIR__ . '/../../resources/themes/architect/views/', 'architect');

        // Enable pluck on collections to work on private values
        Collection::macro('ppluck', function ($attr) {
            return $this->map(function (object $item) use ($attr) {
                return $item->{$attr};
            })->values();
        });
    }
}