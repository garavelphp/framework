<?php

namespace Core\Managers;

class ProviderManager
{
    protected $providers = [];

    public function __construct(array $providers)
    {
        $this->providers = $providers;
    }

    public function register()
    {
        foreach ($this->providers as $provider) {
            (new $provider)->register();
        }
    }

    public function boot()
    {
        foreach ($this->providers as $provider) {
            (new $provider)->boot();
        }
    }
}