<?php

namespace App\Company\CommandHandler;

use App\Company\Command\CreateCompanyCommand;
use App\Company\Service\CompanyService;
use App\Shared\Exception\InvalidFormException;
use App\Shared\Service\CQRS\Command\CommandHandler;

class CreateCompanyHandler implements CommandHandler
{
    public function __construct(private CompanyService $companyService) {}

    /**
     * @throws InvalidFormException
     */
    public function __invoke(CreateCompanyCommand $command)
    {
        $this->companyService->createNewCompany($command->getData());
    }
}