<?php

namespace App\Employee\Command;

use App\Shared\Service\CQRS\Command\Command;

class CreateEmployeeCommand implements Command
{
    public function __construct(private array $data) {}

    public function getData(): array
    {
        return $this->data;
    }
}