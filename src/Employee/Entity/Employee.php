<?php

namespace App\Employee\Entity;

use App\Company\Entity\Company;
use App\Employee\Repository\EmployeeRepository;
use App\Shared\Model\EntityModel;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: EmployeeRepository::class)]
class Employee extends EntityModel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(
        min: 3,
        max: 20,
        minMessage: 'Min length of first name is {{ limit }}',
        maxMessage: 'Max length of first name is {{ limit }}',
    )]
    private ?string $firstName = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(
        min: 3,
        max: 40,
        minMessage: 'Min length of last name is {{ limit }}',
        maxMessage: 'Max length of last name is {{ limit }}',
    )]
    private ?string $lastName = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Email(
        message: 'The email {{ value }} is not a valid email.',
    )]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(
        min: 9,
        max: 15,
        minMessage: 'Min length of phone number is {{ limit }}',
        maxMessage: 'Max length of phone number is {{ limit }}',
    )]
    private ?string $phoneNumber = null;

    #[ORM\ManyToOne(inversedBy: 'employees')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank]
    private ?Company $company = null;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->isDeleted = false;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(?string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(?Company $company): self
    {
        $this->company = $company;

        return $this;
    }
}
