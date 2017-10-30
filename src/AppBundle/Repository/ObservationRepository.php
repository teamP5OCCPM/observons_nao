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
    public function getIndexObservations($limit, $status) : array
    {
        $qb = $this->createQueryBuilder('o')
            ->where('o.status = :status')
            ->setParameter('status', $status);
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
    public function getObservations($page, $nbPerPage, $status) : Paginator
    {
        $query = $this->createQueryBuilder('o')
            ->where('o.status = :status')
            ->setParameter('status', $status)
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

    /**
     * @return array
     */
    public function findMarkers() : array
    {
        $query = $this->_em->createQuery('SELECT o.title, o.lat, o.lng FROM AppBundle:Observation o');
        $results = $query->getArrayResult();
    
        return $results;
    }

    /**
     * @return array
     */
    public function findAllLocations() : array
    {
        $qb = $this->_em->createQuery('SELECT o.lat, o.lng FROM AppBundle:Observation o GROUP BY o.lat, o.lng');
        $results = $qb->getArrayResult();

        return $results;
    }
}
