<?php

namespace App\Company\CommandHandler;

use App\Company\Command\CreateCompanyCommand;
use App\Company\Command\UpdateCompanyCommand;
use App\Company\Service\CompanyService;
use App\Shared\Exception\EntityDoesNotExistException;
use App\Shared\Exception\InvalidFormException;
use App\Shared\Service\CQRS\Command\CommandHandler;

class UpdateCompanyHandler implements CommandHandler
{
    public function __construct(private CompanyService $companyService) {}

    /**
     * @throws InvalidFormException
     * @throws EntityDoesNotExistException
     */
    public function __invoke(UpdateCompanyCommand $command)
    {
        $this->companyService->editCompany($command->getData(), $command->getId());
    }
}