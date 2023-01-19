<?php

namespace App\Company\Command;

use App\Shared\Service\CQRS\Command\Command;

class UpdateCompanyCommand implements Command
{
    public function __construct(private array $data, private int $id) {}

    public function getData(): array
    {
        return $this->data;
    }

    public function getId(): int
    {
        return $this->id;
    }
}