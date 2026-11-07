<?php

namespace Modules\Partner\Providers;

use Nwidart\Modules\Support\ModuleServiceProvider;

class PartnerServiceProvider extends ModuleServiceProvider
{
    /**
     * The name of the module.
     */
    protected string $name = 'Partner';

    /**
     * The lowercase version of the module name.
     */
    protected string $nameLower = 'partner';

    /**
     * Provider classes to register.
     *
     * @var string[]
     */
    protected array $providers = [
        RouteServiceProvider::class,
    ];
}
