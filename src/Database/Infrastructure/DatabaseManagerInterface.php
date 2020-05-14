<?php

namespace Jakmall\Recruitment\Calculator\Database\Infrastructure;

//TODO: create implementation.
interface DatabaseManagerInterface
{
    /**
     * Returns array of command history.
     *
     * @return array
     */
    public function getAll(): array;

}
