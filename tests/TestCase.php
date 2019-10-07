<?php

namespace MikeTiEm\Valkyrie\Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;
use MikeTiEm\Valkyrie\ValkyrieServiceProvider;

class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app)
    {
        return [
            ValkyrieServiceProvider::class
        ];
    }
}