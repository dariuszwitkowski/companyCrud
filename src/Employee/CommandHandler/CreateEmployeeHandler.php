<?php

namespace App\Employee\CommandHandler;

use App\Employee\Command\CreateEmployeeCommand;
use App\Employee\Service\EmployeeService;
use App\Shared\Exception\InvalidFormException;
use App\Shared\Service\CQRS\Command\CommandHandler;

class CreateEmployeeHandler implements CommandHandler
{
    public function __construct(private EmployeeService $employeeService) {}

    /**
     * @throws InvalidFormException
     */
    public function __invoke(CreateEmployeeCommand $command)
    {
        $this->employeeService->createNewEmployee($command->getData());
    }
}