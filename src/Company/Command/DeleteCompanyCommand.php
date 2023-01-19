<?php

namespace App\Company\Command;

use App\Shared\Service\CQRS\Command\Command;

class DeleteCompanyCommand implements Command
{
    public function __construct(private int $id) {}

    public function getId(): int
    {
        return $this->id;
    }
}