<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @Assert\Type("string",
     *     message="Cet input doit etre une chaine de caracteres")
     * @Assert\NotBlank(message="Cet input ne doit pas etre vide")
     * @Assert\Length(max=255, maxMessage="Cet input ne doit pas depasser 255 caracteres")
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
     * @ORM\Column(name="lb_name", type="string", length=255)
     */
    private $lbName;


    /**
     * @var integer
     * @ORM\Column(name="cd_ref", type="integer", unique=true)
     * @Assert\Type("integer",message="la valeur {{ value.type }} n'est pas un {{ type }} valide")
     */
    private $cdRef;

    /**
     * @var string
     *
     * @ORM\Column(name="lb_author", type="string", length=255, nullable=true)
     * @Assert\Type("string", message="la valeur {{ value.type }} n'est pas un {{ type }} valide")
     * @Assert\Length(max=255, maxMessage="le reign ne peut pas depasser 255 caracteres")
     */
    private $lbAuthor;

    public function __toString()
    {
        return $this->species;
    }


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

    /**
     * Set cdRef
     *
     * @param integer $cdRef
     *
     * @return Bird
     */
    public function setCdRef($cdRef)
    {
        $this->cdRef = $cdRef;

        return $this;
    }

    /**
     * Get cdRef
     *
     * @return integer
     */
    public function getCdRef()
    {
        return $this->cdRef;
    }
}
