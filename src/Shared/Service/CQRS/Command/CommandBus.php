<?php

namespace App\Shared\Service\CQRS\Command;

interface CommandBus
{
    public function dispatch(Command $command): void;
}