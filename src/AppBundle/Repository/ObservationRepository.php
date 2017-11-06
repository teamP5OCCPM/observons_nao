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
     * @param $status
     *
     * @return array
     */
    public function getIndexObservations($limit, $status) : array
    {
        $qb = $this->createQueryBuilder('o')
            ->where('o.status = :status')
            ->setParameter('status', $status)
            ->leftJoin('o.bird', 'bird')
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
     * @param $species
     *
     * @param $limit
     * @param $id
     *
     * @return array
     */
    public function getSameSpecies($species, $limit, $id) : array
    {
        $query = $this->createQueryBuilder('o')
            ->leftJoin('o.bird', 'bir')
            ->where('bir.species = :species')
            ->andWhere('o.id NOT LIKE :id')
            ->setParameter('id', $id)
            ->setParameter('species', $species)
            ->leftJoin('o.user', 'usr')
            ->addSelect('usr')
            ->orderBy('o.createdAt', 'DESC')
            ->setMaxResults($limit)
            ->getQuery();

        return $query->getResult();
    }

    /**
     * @param $species
     * @param $id
     *
     * @return array
     */
    public function getOtherImgSpecies($species, $id) : array
    {
        $query = $this->createQueryBuilder('o')
            ->leftJoin('o.bird', 'bir')
            ->where('bir.species = :species')
            ->andWhere('o.id NOT LIKE :id')
            ->setParameter('id', $id)
            ->setParameter('species', $species)
            ->getQuery();

        return $query->getResult();
    }

    /**
     * @param $status
     *
     * @return array
     */
    public function findAllBirds($status) : array
    {
        $qb = $this->createQueryBuilder('o');
        $qb->where('o.status = :status')
            ->setParameter('status', $status)
            ->leftJoin('o.bird', 'b')
            ->addSelect('b.species')
            ->groupBy('b.species');

        return $qb->getQuery()->getArrayResult();
    }

    /**
     * @param $status
     *
     * @return array
     */
    public function findAllLocations($status) : array
    {
        $qb = $this->_em->createQuery('SELECT DISTINCT o.city FROM AppBundle:Observation o WHERE o.status = :status');
        $qb->setParameter(':status', $status);
        $results = $qb->getArrayResult();

        return $results;
    }

    /**
     * @param $status
     *
     * @return array
     */
    public function findAllTitles($status) : array
    {
        $qb = $this->_em->createQuery('SELECT o.title FROM AppBundle:Observation o WHERE o.status = :status');
        $qb->setParameter('status', $status);
        $results = $qb->getArrayResult();

        return $results;
    }

    /**
     * @param $status
     * @param $keyword
     * @return array
     */
    public function findBySpecies($status, $keyword) : array
    {
        $qb = $this->createQueryBuilder('o');
        $qb ->where('o.status = :status')
            ->setParameter('status', $status)
            -> leftJoin('o.bird', 'bird')
            -> addSelect('bird')
            ->leftJoin('o.user', 'u')
            ->addSelect('u')
            -> andWhere('bird.species = :species')
            -> setParameter('species', $keyword);



        return $qb->getQuery()->getArrayResult();
    }

    public function findKeyword($status, $keyword) : array
    {
        $qb = $this->createQueryBuilder('o');
        $qb ->where('o.status = :status')
            ->setParameter('status', $status)
            -> leftJoin('o.bird', 'b')
            -> addSelect('b')
            ->leftJoin('o.user', 'u')
            ->addSelect('u')
            -> andWhere('REGEXP(o.title, :regexp) = true')
                ->setParameter('regexp', $keyword)
            ->orWhere('REGEXP(o.city, :regexp) = true')
                ->setParameter('regexp', $keyword)
            ->orWhere('REGEXP(b.species, :regexp) = true')
                ->setParameter('regexp', $keyword);

        return $qb->getQuery()->getArrayResult();
    }

}
