<?php

namespace App\Company\QueryHandler;

use App\Company\Command\UpdateCompanyCommand;
use App\Company\Query\GetCompanyQuery;
use App\Company\Service\CompanyService;
use App\Shared\Service\CQRS\Query\QueryHandler;

class GetCompanyQueryHandler implements QueryHandler
{
    public function __construct(private CompanyService $companyService) {}

    public function __invoke(GetCompanyQuery $query): ?array
    {
        return $this->companyService->getCompanyAsArray($query->getId());
    }
}