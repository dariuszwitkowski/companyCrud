<?php

namespace App\Employee\Command;

use App\Shared\Service\CQRS\Command\Command;

class DeleteEmployeeCommand implements Command
{
    public function __construct(private int $id) {}

    public function getId(): int
    {
        return $this->id;
    }
}