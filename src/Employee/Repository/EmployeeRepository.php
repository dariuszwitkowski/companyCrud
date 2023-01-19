<?php

namespace App\Employee\Repository;

use App\Employee\Entity\Employee;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Employee>
 *
 * @method Employee|null find($id, $lockMode = null, $lockVersion = null)
 * @method Employee|null findOneBy(array $criteria, array $orderBy = null)
 * @method Employee[]    findAll()
 * @method Employee[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmployeeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Employee::class);
    }
    public function createQueryBuilder($alias, $indexBy = null)
    {
        return $this->_em->createQueryBuilder()
            ->select($alias)
            ->from($this->_entityName, $alias, $indexBy)
            ->andWhere("${alias}.isDeleted = :isDeleted")
            ->setParameter('isDeleted', false);
    }
    public function save(Employee $entity, bool $flush = false): void
    {
        $entity->setUpdatedAt(new \DateTime());
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Employee $entity, bool $flush = false, bool $softDelete = true): void
    {
        if ($softDelete) {
            $entity->setIsDeleted(true);
            $entity->setDeletedAt(new \DateTime());
            $this->save($entity, $flush);
            return;
        }

        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function get(?int $id = null): array
    {
        $qb = $this->createQueryBuilder('e');
        $qb->select(['e.id', 'e.firstName', 'e.lastName', 'e.email', 'e.phoneNumber', 'c.name'])
            ->leftJoin('e.company', 'c', 'e.company_id = c.id');
        if ($id) {
            $qb->andWhere("e.id = :id")
                ->setParameter('id', $id);
        }
        return $qb->getQuery()->getArrayResult();
    }
}
