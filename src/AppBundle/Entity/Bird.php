<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Bird
 *
 * @ORM\Table(name="nao_bird")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BirdRepository")
 */
class Bird
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="species", type="string", length=255)
     */
    private $species;

    /**
     * @var string
     *
     * @ORM\Column(name="reign", type="string", length=255, nullable=true)
     */
    private $reign;

    /**
     * @var string
     *
     * @ORM\Column(name="phylum", type="string", length=255, nullable=true)
     */
    private $phylum;

    /**
     * @var string
     *
     * @ORM\Column(name="ranking", type="string", length=255, nullable=true)
     */
    private $ranking;

    /**
     * @var string
     *
     * @ORM\Column(name="family", type="string", length=255, nullable=true)
     */
    private $family;

    /**
     * @var string
     *
     * @ORM\Column(name="lb_name", type="string", length=255, nullable=true)
     */
    private $lbName;

    /**
     * @var string
     *
     * @ORM\Column(name="lb_author", type="string", length=255, nullable=true)
     */
    private $lbAuthor;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set species
     *
     * @param string $species
     *
     * @return Bird
     */
    public function setSpecies($species)
    {
        $this->species = $species;

        return $this;
    }

    /**
     * Get species
     *
     * @return string
     */
    public function getSpecies()
    {
        return $this->species;
    }

    /**
     * Set reign
     *
     * @param string $reign
     *
     * @return Bird
     */
    public function setReign($reign)
    {
        $this->reign = $reign;

        return $this;
    }

    /**
     * Get reign
     *
     * @return string
     */
    public function getReign()
    {
        return $this->reign;
    }

    /**
     * Set phylum
     *
     * @param string $phylum
     *
     * @return Bird
     */
    public function setPhylum($phylum)
    {
        $this->phylum = $phylum;

        return $this;
    }

    /**
     * Get phylum
     *
     * @return string
     */
    public function getPhylum()
    {
        return $this->phylum;
    }

    /**
     * Set ranking
     *
     * @param string $ranking
     *
     * @return Bird
     */
    public function setRanking($ranking)
    {
        $this->ranking = $ranking;

        return $this;
    }

    /**
     * Get ranking
     *
     * @return string
     */
    public function getRanking()
    {
        return $this->ranking;
    }

    /**
     * Set family
     *
     * @param string $family
     *
     * @return Bird
     */
    public function setFamily($family)
    {
        $this->family = $family;

        return $this;
    }

    /**
     * Get family
     *
     * @return string
     */
    public function getFamily()
    {
        return $this->family;
    }

    /**
     * Set lbName
     *
     * @param string $lbName
     *
     * @return Bird
     */
    public function setLbName($lbName)
    {
        $this->lbName = $lbName;

        return $this;
    }

    /**
     * Get lbName
     *
     * @return string
     */
    public function getLbName()
    {
        return $this->lbName;
    }

    /**
     * Set lbAuthor
     *
     * @param string $lbAuthor
     *
     * @return Bird
     */
    public function setLbAuthor($lbAuthor)
    {
        $this->lbAuthor = $lbAuthor;

        return $this;
    }

    /**
     * Get lbAuthor
     *
     * @return string
     */
    public function getLbAuthor()
    {
        return $this->lbAuthor;
    }
}
