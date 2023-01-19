<?php

namespace App\Company\CommandHandler;

use App\Company\Command\CreateCompanyCommand;
use App\Company\Command\DeleteCompanyCommand;
use App\Company\Command\UpdateCompanyCommand;
use App\Company\Service\CompanyService;
use App\Shared\Exception\EntityDoesNotExistException;
use App\Shared\Exception\InvalidFormException;
use App\Shared\Service\CQRS\Command\CommandHandler;

class DeleteCompanyHandler implements CommandHandler
{
    public function __construct(private CompanyService $companyService) {}

    /**
     * @throws EntityDoesNotExistException
     */
    public function __invoke(DeleteCompanyCommand $command)
    {
        $this->companyService->deleteCompany($command->getId());
    }
}