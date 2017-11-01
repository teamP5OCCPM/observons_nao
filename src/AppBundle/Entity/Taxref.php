<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Taxref
 *
 * @ORM\Table(name="nao_taxref")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TaxrefRepository")
 * @Vich\Uploadable
 */
class Taxref
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
     * @var \DateTime
     *
     * @ORM\Column(name="update_at", type="datetime")
     */
    private $updateAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="version", type="date", unique=true, nullable=true)
     */
    private $version;

    /**
     * @Vich\UploadableField(mapping="taxref_csv", fileNameProperty="csvName")
     *
     * @var File
     * @Assert\File(
     *     maxSize = "2048k",
     *     mimeTypes = {"text/plain"},
     *     mimeTypesMessage = "Veuillez ajouter un fichier valide !!"
     * )
     */
    private $csvFile;

    /**
     * @var string
     *
     * @ORM\Column(name="csv_name", type="string", length=255)
     */
    private $csvName;


    public function __construct()
    {
        $this->updateAt = new \DateTime();
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
     * Set updateAt
     *
     * @param \DateTime $updateAt
     *
     * @return Taxref
     */
    public function setUpdateAt($updateAt)
    {
        $this->updateAt = $updateAt;

        return $this;
    }

    /**
     * Get updateAt
     *
     * @return \DateTime
     */
    public function getUpdateAt()
    {
        return $this->updateAt;
    }

    /**
     * Set version
     *
     * @param \DateTime $version
     *
     * @return Taxref
     */
    public function setVersion($version)
    {
        $this->version = $version;

        return $this;
    }

    /**
     * Get version
     *
     * @return \DateTime
     */
    public function getVersion()
    {
        return $this->version;
    }


    /**
     * @param File|null $csv
     *
     * @return $this
     */
    public function setCsvFile(File $csv = null)
    {
        $this->csvFile = $csv;

        if ($csv) {
            $this->updatedAt = new \DateTimeImmutable();
        }

        return $this;
    }

    /**
     * @return File|null
     */
    public function getCsvFile()
    {
        return $this->csvFile;
    }


    /**
     * Set csvName
     *
     * @param string $csvName
     *
     * @return Taxref
     */
    public function setCsvName($csvName)
    {
        $this->csvName = $csvName;

        return $this;
    }

    /**
     * Get csvName
     *
     * @return string
     */
    public function getCsvName()
    {
        return $this->csvName;
    }
}
