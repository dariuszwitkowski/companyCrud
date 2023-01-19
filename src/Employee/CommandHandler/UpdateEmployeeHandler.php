<?php

namespace App\Employee\CommandHandler;

use App\Employee\Command\CreateEmployeeCommand;
use App\Employee\Command\UpdateEmployeeCommand;
use App\Employee\Service\EmployeeService;
use App\Shared\Exception\EntityDoesNotExistException;
use App\Shared\Exception\InvalidFormException;
use App\Shared\Service\CQRS\Command\CommandHandler;

class UpdateEmployeeHandler implements CommandHandler
{
    public function __construct(private EmployeeService $employeeService) {}

    /**
     * @throws InvalidFormException
     * @throws EntityDoesNotExistException
     */
    public function __invoke(UpdateEmployeeCommand $command)
    {
        $this->employeeService->editEmployee($command->getData(), $command->getId());
    }
}