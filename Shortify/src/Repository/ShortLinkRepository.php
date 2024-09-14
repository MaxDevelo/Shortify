<?php

declare(strict_types= 1);

namespace App\Repository;

use App\Entity\ShortLink;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ShortLink>
 */
class ShortLinkRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ShortLink::class);
    }
    
    /**
     * @param  ShortLink $shortLink
     * @param  bool $flush
     * @return void
     */
    public function save(ShortLink $shortLink, bool $flush = false): void
    {
        $this->getEntityManager()->persist($shortLink);

        if ($flush)
        {
            $this->getEntityManager()->flush();
        }
    }
    
    /**
     * @param  mixed $shortLink
     * @param  mixed $flush
     * @return void
     */
    public function remove(ShortLink $shortLink, bool $flush = false): void
    {
        $this->getEntityManager()->remove($shortLink);

        if ($flush)
        {
            $this->getEntityManager()->flush();
        }
    }
    
    /**
     * @param  string $shortLink
     * @return ShortLink
     */
    public function verifyShortLinkExists(string $shortLink): ?ShortLink
    {
        return $this->createQueryBuilder("sl")
        ->where("sl.short_link = :short_link")
        ->setParameter("short_link", $shortLink)
        ->getQuery()
        ->getOneOrNullResult();
    }

    //    /**
    //     * @return ShortLink[] Returns an array of ShortLink objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('s.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?ShortLink
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
