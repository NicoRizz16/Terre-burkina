<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Message
 *
 * @ORM\Table(name="message")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MessageRepository")
 */
class Message
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
     * @ORM\Column(name="creationDate", type="datetime")
     */
    private $creationDate;

    /**
     * @var string
     *
     * @ORM\Column(name="object", type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 2,
     *      max = 255,
     *      minMessage = "L'objet du message doit faire au moins {{ limit }} caractères.",
     *      maxMessage = "L'objet du message doit faire moins de {{ limit }} caractères"
     * )
     */
    private $object;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 5,
     *      max = 10000,
     *      minMessage = "Le message doit faire au moins {{ limit }} caractères.",
     *      maxMessage = "Le message doit faire moins de {{ limit }} caractères."
     * )
     */
    private $content;

    /**
     * @var bool
     *
     * @ORM\Column(name="isSenderAdmin", type="boolean")
     */
    private $isSenderAdmin;

    /**
     * @var bool
     *
     * @ORM\Column(name="isNotificationAdmin", type="boolean")
     */
    private $isNotificationAdmin;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="messages")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="SponsorGroup", inversedBy="messages")
     * @ORM\JoinColumn(name="group_id", referencedColumnName="id")
     */
    private $group;

    public function __construct()
    {
        $this->setCreationDate(new \DateTime());
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
     * Set creationDate
     *
     * @param \DateTime $creationDate
     *
     * @return Message
     */
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    /**
     * Get creationDate
     *
     * @return \DateTime
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * Set object
     *
     * @param string $object
     *
     * @return Message
     */
    public function setObject($object)
    {
        $this->object = $object;

        return $this;
    }

    /**
     * Get object
     *
     * @return string
     */
    public function getObject()
    {
        return $this->object;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return Message
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set isSenderAdmin
     *
     * @param boolean $isSenderAdmin
     *
     * @return Message
     */
    public function setIsSenderAdmin($isSenderAdmin)
    {
        $this->isSenderAdmin = $isSenderAdmin;

        return $this;
    }

    /**
     * Get isSenderAdmin
     *
     * @return bool
     */
    public function getIsSenderAdmin()
    {
        return $this->isSenderAdmin;
    }

    /**
     * Set isNotificationAdmin
     *
     * @param boolean $isNotificationAdmin
     *
     * @return Message
     */
    public function setIsNotificationAdmin($isNotificationAdmin)
    {
        $this->isNotificationAdmin = $isNotificationAdmin;

        return $this;
    }

    /**
     * Get isNotificationAdmin
     *
     * @return bool
     */
    public function getIsNotificationAdmin()
    {
        return $this->isNotificationAdmin;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Message
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set group
     *
     * @param \AppBundle\Entity\SponsorGroup $group
     *
     * @return Message
     */
    public function setGroup(\AppBundle\Entity\SponsorGroup $group = null)
    {
        $this->group = $group;

        return $this;
    }

    /**
     * Get group
     *
     * @return \AppBundle\Entity\SponsorGroup
     */
    public function getGroup()
    {
        return $this->group;
    }
}
