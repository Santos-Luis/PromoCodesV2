<?php

namespace App\Repository;

use App\Entity\PromoCode;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

/**
 * PromoCodeRepository.
 */
class PromoCodeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PromoCode::class);
    }

    /**
     * @param PromoCode $promoCode
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(PromoCode $promoCode): void
    {
        $em = $this->getEntityManager();
        $em->persist($promoCode);
        $em->flush();
    }
}
