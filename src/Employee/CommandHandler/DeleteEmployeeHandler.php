<?php

namespace App\Employee\CommandHandler;

use App\Employee\Command\CreateEmployeeCommand;
use App\Employee\Command\DeleteEmployeeCommand;
use App\Employee\Command\UpdateEmployeeCommand;
use App\Employee\Service\EmployeeService;
use App\Shared\Exception\EntityDoesNotExistException;
use App\Shared\Exception\InvalidFormException;
use App\Shared\Service\CQRS\Command\CommandHandler;

class DeleteEmployeeHandler implements CommandHandler
{
    public function __construct(private EmployeeService $employeeService) {}

    /**
     * @throws EntityDoesNotExistException
     */
    public function __invoke(DeleteEmployeeCommand $command)
    {
        $this->employeeService->deleteEmployee($command->getId());
    }
}