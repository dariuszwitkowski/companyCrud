<?php

namespace App\Company\Entity;

use App\Company\Repository\CompanyRepository;
use App\Employee\Entity\Employee;
use App\Shared\Model\EntityModel;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CompanyRepository::class)]
class Company extends EntityModel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(
        min: 5,
        max: 50,
        minMessage: 'Min length of company name is {{ limit }}',
        maxMessage: 'Max length of company name is {{ limit }}',
    )]
    private ?string $name = null;

    #[ORM\Column(length: 10)]
    #[Assert\NotBlank]
    #[Assert\Length(
        exactly: 10,
        exactMessage: 'NIP length must be exactly 10'
    )]
    #[Assert\Regex(
        pattern: '/^[0-9]*$/',
        message: 'NIP must contain only digits'
    )]
    private ?string $nip = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(
        min: 5,
        max: 255,
        minMessage: 'Min length of address is {{ limit }}',
        maxMessage: 'Max length of address is {{ limit }}',
    )]
    private ?string $address = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(
        min: 5,
        max: 255,
        minMessage: 'Min length of city is {{ limit }}',
        maxMessage: 'Max length of city is {{ limit }}',
    )]
    private ?string $city = null;

    #[ORM\Column(length: 5)]
    #[Assert\NotBlank]
    #[Assert\Length(
        exactly: 5,
        exactMessage: 'Postal code length must be exactly {{ limit }}'
    )]
    #[Assert\Regex(
        pattern: '/^[0-9]*$/',
        message: 'Postal code must contain only digits'
    )]
    private ?string $postalCode = null;

    #[ORM\OneToMany(mappedBy: 'company', targetEntity: Employee::class, orphanRemoval: true)]
    #[Assert\NotBlank]
    private Collection $employees;

    public function __construct()
    {
        $this->employees = new ArrayCollection();
        $this->createdAt = new \DateTime();
        $this->isDeleted = false;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getNip(): ?string
    {
        return $this->nip;
    }

    public function setNip(string $nip): self
    {
        $this->nip = $nip;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setPostalCode(string $postalCode): self
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    /**
     * @return Collection<int, Employee>
     */
    public function getEmployees(): Collection
    {
        return $this->employees;
    }

    public function addEmployee(Employee $employee): self
    {
        if (!$this->employees->contains($employee)) {
            $this->employees->add($employee);
            $employee->setCompany($this);
        }

        return $this;
    }

    public function removeEmployee(Employee $employee): self
    {
        if ($this->employees->removeElement($employee)) {
            if ($employee->getCompany() === $this) {
                $employee->setCompany(null);
            }
        }

        return $this;
    }
}
