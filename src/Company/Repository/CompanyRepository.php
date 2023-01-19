<?php

namespace App\Company\Repository;

use App\Company\Entity\Company;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Company>
 *
 * @method Company|null find($id, $lockMode = null, $lockVersion = null)
 * @method Company|null findOneBy(array $criteria, array $orderBy = null)
 * @method Company[]    findAll()
 * @method Company[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompanyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Company::class);
    }
    public function createQueryBuilder($alias, $indexBy = null): QueryBuilder
    {
        return $this->_em->createQueryBuilder()
            ->select($alias)
            ->from($this->_entityName, $alias, $indexBy)
            ->andWhere("${alias}.isDeleted = :isDeleted")
            ->setParameter('isDeleted', false);
    }
    public function save(Company $entity, bool $flush = false): void
    {
        $entity->setUpdatedAt(new \DateTime());
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Company $entity, bool $flush = false, bool $softDelete = true): void
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
        $qb = $this->createQueryBuilder('c');
        $qb->select(['c.id', 'c.name', 'c.nip', 'c.address',  'c.postalCode']);
        if ($id) {
            $qb->andWhere("c.id = :id")
                ->setParameter('id', $id);
        }
        return $qb->getQuery()->getArrayResult();
    }

    public function companyExists(string $nip, ?int $excludedId = null): bool
    {
        $qb = $this->createQueryBuilder('c');
        $qb->select(['COUNT(c.id)'])
            ->where('c.nip = :nip')
            ->setParameter('nip', $nip);
        if ($excludedId) {
            $qb->andWhere('c.id != :excludedId')
                ->setParameter('excludedId', $excludedId);
        }
        $qb->setMaxResults(1);
        return $qb->getQuery()->getSingleColumnResult()[0] > 0;
    }
}
