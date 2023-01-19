<?php

namespace App\Shared\Service\CQRS\Query;

interface QueryBus
{
    public function handle(Query $query): mixed;
}