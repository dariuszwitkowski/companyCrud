<?php

namespace App\Company\Service;

use App\Company\Entity\Company;
use App\Company\Form\CompanyType;
use App\Company\Repository\CompanyRepository;
use App\Shared\Exception\EntityAlreadyExistsException;
use App\Shared\Exception\EntityDoesNotExistException;
use App\Shared\Exception\InvalidFormException;
use Symfony\Component\Form\FormFactoryInterface;

class CompanyService
{
    public function __construct(private CompanyRepository $companyRepository, private FormFactoryInterface $formFactory) {}

    /**
     * @throws InvalidFormException
     */
    public function createNewCompany(array $companyData): void
    {
        $this->saveCompany($companyData);
    }

    /**
     * @throws InvalidFormException|EntityDoesNotExistException
     */
    public function editCompany(array $companyData, int $id): void
    {
        $company = $this->getCompany($id);
        if (!$company) {
            throw new EntityDoesNotExistException('Company', $id);
        }
        $this->saveCompany($companyData, $company);
    }

    /**
     * @throws EntityDoesNotExistException
     */
    public function deleteCompany(int $id): void
    {
        $company = $this->getCompany($id);
        if (!$company) {
            throw new EntityDoesNotExistException('Company', $id);
        }
        $this->companyRepository->remove($company, true);
    }

    /**
     * @throws InvalidFormException|EntityAlreadyExistsException
     */
    private function saveCompany(array $companyData, ?Company $company = null): void
    {
        if (
            $companyData['nip'] &&
            $this->companyRepository->companyExists($companyData['nip'], $company?->getId())
        ) {
            throw new EntityAlreadyExistsException('Company');
        }
        $form = $this->formFactory->create(CompanyType::class, $company ?? new Company());

        $form->submit($companyData);

        if(!$form->isValid()) {
            throw new InvalidFormException($form);
        }

        $companyData = $form->getNormData();

        $this->companyRepository->save($companyData, true);
    }
    public function getCompanyAsArray(?int $id = null): array
    {
        return $this->companyRepository->get($id);
    }
    private function getCompany(int $id): ?Company
    {
        return $this->companyRepository->findOneBy(['id' => $id, 'isDeleted' => false]);
    }
}