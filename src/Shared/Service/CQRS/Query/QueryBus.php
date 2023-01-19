<?php

namespace App\Shared\Service\CQRS\Query;

interface QueryBus
{
    public function dispatch(Query $query): mixed;
}