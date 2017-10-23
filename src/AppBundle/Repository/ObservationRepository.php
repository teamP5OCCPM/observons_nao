<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * ObservationRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ObservationRepository extends EntityRepository
{
    /**
     * @param $limit
     *
     * @return array
     */
    public function getIndexObservations($limit) : array
    {
        $qb = $this->createQueryBuilder('o');
        $qb->leftJoin('o.bird', 'bird')
            ->addSelect('bird')
            ->leftJoin('o.user', 'user')
            ->addSelect('user')
            ->orderBy('o.createdAt', 'DESC')
            ->setMaxResults($limit);

        return $qb->getQuery()->getResult();
    }

    /**
     * @param $page
     * @param $nbPerPage
     *
     * @return Paginator
     */
    public function getObservations($page, $nbPerPage) : Paginator
    {
        $query = $this->createQueryBuilder('o')
            ->leftJoin('o.bird', 'bir')
            ->addSelect('bir')
            ->leftJoin('o.user', 'usr')
            ->addSelect('usr')
            ->orderBy('o.createdAt', 'DESC')
            ->getQuery();

        $query
            ->setFirstResult(($page-1) * $nbPerPage)
            ->setMaxResults($nbPerPage);

        return new Paginator($query, true);
    }
}
