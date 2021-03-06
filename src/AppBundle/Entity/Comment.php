<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Comment
 *
 * @ORM\Table(name="nao_comment")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CommentRepository")
 */
class Comment
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
     * @ORM\Column(name="message", type="text")
     * @Assert\NotBlank(message="Veuillez écrire un message")
     */
    private $message;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     * @Assert\Email(
     *     message="'{{ value }}' n'est pas un e-mail valide.",
     *     checkMX = true
     * )
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="author", type="string", length=50)
     * @Assert\Type("string", message="la valeur {{ value.type }} n'est pas un {{ type }} valide.")
     * @Assert\NotBlank(message="Veuillez entrer un pseudo")
     * @Assert\Length(max=50, maxMessage="Votre pseudo ne peut pas depasser les 50 caracteres")
     */
    private $author;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     * @Assert\NotBlank()
     */
    private $createdAt;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_reported", type="boolean")
     */
    private $isReported = false;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_hidden", type="boolean")
     */
    private $isHidden = false;


    /**
     * @var integer
     * @ORM\Column(name="level", type="integer")
     */
    private $level = 1;


    /**
     * @var
     * @ORM\ManyToOne(targetEntity="Article", inversedBy="comments", cascade={"remove"})
     * @Assert\Valid()
     */
    private $article;



    /**
     * @ORM\ManyToOne(targetEntity="Comment", inversedBy="children", cascade={"remove"})
     * @Assert\Valid()
     */
    private $parent;


    /**
     * @var integer
     */
    private $parentId;


    /**
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="parent")
     * @Assert\Valid()
     */
    private $children;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->children = new \Doctrine\Common\Collections\ArrayCollection();
        $this->createdAt = new \DateTime();
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
     * Set message
     *
     * @param string $message
     *
     * @return Comment
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Comment
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set author
     *
     * @param string $author
     *
     * @return Comment
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Comment
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set isReported
     *
     * @param boolean $isReported
     *
     * @return Comment
     */
    public function setIsReported($isReported)
    {
        $this->isReported = $isReported;

        return $this;
    }

    /**
     * Get isReported
     *
     * @return bool
     */
    public function getIsReported()
    {
        return $this->isReported;
    }

    /**
     * Set isHidden
     *
     * @param boolean $isHidden
     *
     * @return Comment
     */
    public function setIsHidden($isHidden)
    {
        $this->isHidden = $isHidden;

        return $this;
    }

    /**
     * Get isHidden
     *
     * @return bool
     */
    public function getIsHidden()
    {
        return $this->isHidden;
    }

    /**
     * Set article
     *
     * @param \AppBundle\Entity\Article $article
     *
     * @return Comment
     */
    public function setArticle(\AppBundle\Entity\Article $article = null)
    {
        $this->article = $article;

        return $this;
    }

    /**
     * Get article
     *
     * @return \AppBundle\Entity\Article
     */
    public function getArticle()
    {
        return $this->article;
    }

    /**
     * Set parent
     *
     * @param \AppBundle\Entity\Comment $parent
     *
     * @return Comment
     */
    public function setParent(\AppBundle\Entity\Comment $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \AppBundle\Entity\Comment
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Add child
     *
     * @param \AppBundle\Entity\Comment $child
     *
     * @return Comment
     */
    public function addChild(\AppBundle\Entity\Comment $child)
    {
        $this->children[] = $child;

        // return $this;
    }

    /**
     * Remove child
     *
     * @param \AppBundle\Entity\Comment $child
     */
    public function removeChild(\AppBundle\Entity\Comment $child)
    {
        $this->children->removeElement($child);
    }

    /**
     * Get children
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Set level
     *
     * @param integer $level
     *
     * @return Comment
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level
     *
     * @return integer
     */
    public function getLevel()
    {
        return $this->level;
    }


    public function getParentId()
    {
        return $this->parentId;
    }

    public function setParentId($id)
    {
        $this->parentId = $id;
    }
}
