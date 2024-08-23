<?php


use App\Providers\AppServiceProvider;
use Core\Managers\ProviderManager;

$providers = [
    AppServiceProvider::class,
    // Diğer providerlar
];

$providerManager = new ProviderManager($providers);
$providerManager->register();
$providerManager->boot();