<?php

namespace App\Employee\QueryHandler;

use App\Employee\Query\GetEmployeeQuery;
use App\Employee\Service\EmployeeService;
use App\Shared\Service\CQRS\Query\QueryHandler;

class GetEmployeeQueryHandler implements QueryHandler
{
    public function __construct(private EmployeeService $employeeService) {}

    public function __invoke(GetEmployeeQuery $query): ?array
    {
        return $this->employeeService->getEmployeeAsArray($query->getId());
    }
}