<?php

namespace Jakmall\Recruitment\Calculator\Database;

use Illuminate\Contracts\Container\Container;
use Jakmall\Recruitment\Calculator\Container\ContainerServiceProviderInterface;
use Jakmall\Recruitment\Calculator\Database\Infrastructure\DatabaseManagerInterface;
use Jakmall\Recruitment\Calculator\Database\DatabaseMysql;

class DatabaseServiceProvider implements ContainerServiceProviderInterface
{
    /**
     * @inheritDoc
     */
    public function register(Container $container): void
    {
        $container->bind(
            DatabaseManagerInterface::class,
            function () {
                //todo: register implementation
                return new DatabaseMysql();
            }
        );
    }
}
