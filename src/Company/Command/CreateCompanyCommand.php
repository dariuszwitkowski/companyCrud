<?php

namespace App\Company\Command;

use App\Shared\Service\CQRS\Command\Command;

class CreateCompanyCommand implements Command
{
    public function __construct(private array $data) {}

    public function getData(): array
    {
        return $this->data;
        elo kruwa
    }
}