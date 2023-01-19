<?php

namespace App\Shared\Model;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\MappedSuperclass;
use Doctrine\ORM\Mapping\InheritanceType;

#[MappedSuperclass]
#[InheritanceType('SINGLE_TABLE')]
class EntityModel
{
    #[ORM\Column(type: 'datetime')]
    protected \DateTimeInterface $createdAt;

    #[ORM\Column(type: 'datetime')]
    protected \DateTimeInterface $updatedAt;

    #[ORM\Column(type: 'datetime', nullable: true)]
    protected \DateTimeInterface $deletedAt;

    #[ORM\Column(type: 'boolean')]
    protected bool $isDeleted;

    public function setDeletedAt(\DateTimeInterface $deletedAt): EntityModel
    {
        $this->deletedAt = $deletedAt;
        return $this;
    }

    public function getDeletedAt(): \DateTimeInterface
    {
        return $this->deletedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): EntityModel
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    public function getUpdatedAt(): \DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): EntityModel
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setIsDeleted(bool $isDeleted): EntityModel
    {
        $this->isDeleted = $isDeleted;
        return $this;
    }

    public function isDeleted(): bool
    {
        return $this->isDeleted;
    }
}