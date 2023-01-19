<?php

namespace App\Employee\Service;

use App\Employee\Entity\Employee;
use App\Employee\Form\EmployeeType;
use App\Employee\Repository\EmployeeRepository;
use App\Shared\Exception\EntityDoesNotExistException;
use App\Shared\Exception\InvalidFormException;
use Symfony\Component\Form\FormFactoryInterface;

class EmployeeService
{
    public function __construct(private EmployeeRepository $employeeRepository, private FormFactoryInterface $formFactory) {}

    /**
     * @throws InvalidFormException
     */
    public function createNewEmployee(array $employeeData): void
    {
        $this->saveEmployee($employeeData);
    }

    /**
     * @throws InvalidFormException|EntityDoesNotExistException
     */
    public function editEmployee(array $employeeData, int $id): void
    {
        $employee = $this->getEmployee($id);
        if (!$employee) {
            throw new EntityDoesNotExistException('Employee', $id);
        }
        $this->saveEmployee($employeeData, $employee);
    }

    /**
     * @throws EntityDoesNotExistException
     */
    public function deleteEmployee(int $id): void
    {
        $employee = $this->getEmployee($id);
        if (!$employee) {
            throw new EntityDoesNotExistException('Employee', $id);
        }
        $this->employeeRepository->remove($employee, true);
    }

    /**
     * @throws InvalidFormException
     */
    private function saveEmployee(array $employeeData, ?Employee $employee = null): void
    {
        $form = $this->formFactory->create(EmployeeType::class, $employee ?? new Employee());

        $form->submit($employeeData);

        if(!$form->isValid()) {
            throw new InvalidFormException($form);
        }

        $employeeData = $form->getNormData();

        $this->employeeRepository->save($employeeData, true);
    }
    public function getEmployeeAsArray(?int $id = null): array
    {
        return $this->employeeRepository->get($id);
    }
    private function getEmployee(int $id): ?Employee
    {
        return $this->employeeRepository->findOneBy(['id' => $id, 'isDeleted' => false]);
    }
}