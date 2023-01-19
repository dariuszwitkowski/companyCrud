<?php

namespace App\Employee\Query;

use App\Shared\Service\CQRS\Query\Query;

class GetEmployeeQuery implements Query
{
    public function __construct(private ?int $id = null) {}

    public function getId(): ?int
    {
        return $this->id;
    }
}