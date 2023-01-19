<?php

namespace App\Company\Query;

use App\Shared\Service\CQRS\Query\Query;

class GetCompanyQuery implements Query
{
    public function __construct(private ?int $id = null) {}

    public function getId(): ?int
    {
        return $this->id;
    }
}