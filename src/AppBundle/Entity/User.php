<?php
// src/AppBundle/Entity/User.php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 */
class User extends BaseUser
{
    const NUM_ITEMS = 10;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="civility", type="string", length=255, nullable=true)
     */
    private $civility;

    /**
     * @var string
     *
     * @ORM\Column(name="first_name", type="string", length=255, nullable=true)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", length=255, nullable=true)
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="full_name", type="string", length=255, nullable=true)
     */
    private $fullName;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_of_birth", type="datetime", nullable=true)
     */
    private $dateOfBirth;

    /**
     * @var string
     *
     * @ORM\Column(name="adress", type="text", nullable=true)
     */
    private $adress;

    /**
     * @var string
     *
     * @ORM\Column(name="complement_adresse", type="text", nullable=true)
     */
    private $complementAdress;

    /**
     * @var string
     *
     * @ORM\Column(name="code_postal", type="string", nullable=true)
     */
    private $codePostal;

    /**
     * @var string
     *
     * @ORM\Column(name="ville", type="string", nullable=true)
     */
    private $ville;

    /**
     * @var string
     *
     * @ORM\Column(name="pays", type="string", nullable=true)
     */
    private $pays;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=255, nullable=true)
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="payment_choice", type="string", length=255, nullable=true)
     */
    private $paymentChoice;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_payment", type="datetime", nullable=true)
     */
    private $lastPayment;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_contact", type="datetime", nullable=true)
     */
    private $lastContact;

    /**
     * @var bool
     *
     * @ORM\Column(name="document_consulted", type="boolean")
     */
    private $documentConsulted;

    /**
     * @var bool
     *
     * @ORM\Column(name="message_consulted", type="boolean")
     */
    private $messageConsulted;

    /**
     * @var bool
     *
     * @ORM\Column(name="profile_changed", type="boolean")
     */
    private $profileChanged;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Child", mappedBy="sponsor")
     */
    private $childs;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Child", mappedBy="coordinator")
     */
    private $coordinatorChilds;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Document", mappedBy="user", cascade={"remove"})
     */
    private $documents;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Message", mappedBy="user", cascade={"remove"})
     */
    private $messages;

    /**
     * @ORM\ManyToMany(targetEntity="SponsorGroup", inversedBy="users")
     * @ORM\JoinTable(name="sponsors_groups",
     *      joinColumns={@ORM\JoinColumn(name="sponsor_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="group_id", referencedColumnName="id")}
     *  )
     */
    private $sponsorGroups;


    public function __construct()
    {
        parent::__construct();
        $this->setDocumentConsulted(true);
        $this->setMessageConsulted(true);
        $this->setProfileChanged(false);
        $this->setLastContact(new \DateTime());
        $this->sponsorGroups = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set civility
     *
     * @param string $civility
     *
     * @return User
     */
    public function setCivility($civility)
    {
        $this->civility = $civility;

        return $this;
    }

    /**
     * Get civility
     *
     * @return string
     */
    public function getCivility()
    {
        return $this->civility;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     *
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
        $this->setFullName();

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
        $this->setFullName();

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set dateOfBirth
     *
     * @param \DateTime $dateOfBirth
     *
     * @return User
     */
    public function setDateOfBirth($dateOfBirth)
    {
        $this->dateOfBirth = $dateOfBirth;

        return $this;
    }

    /**
     * Get dateOfBirth
     *
     * @return \DateTime
     */
    public function getDateOfBirth()
    {
        return $this->dateOfBirth;
    }

    /**
     * Set adress
     *
     * @param string $adress
     *
     * @return User
     */
    public function setAdress($adress)
    {
        $this->adress = $adress;

        return $this;
    }

    /**
     * Get adress
     *
     * @return string
     */
    public function getAdress()
    {
        return $this->adress;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return User
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set paymentChoice
     *
     * @param string $paymentChoice
     *
     * @return User
     */
    public function setPaymentChoice($paymentChoice)
    {
        $this->paymentChoice = $paymentChoice;

        return $this;
    }

    /**
     * Get paymentChoice
     *
     * @return string
     */
    public function getPaymentChoice()
    {
        return $this->paymentChoice;
    }

    /**
     * Set lastPayment
     *
     * @param \DateTime $lastPayment
     *
     * @return User
     */
    public function setLastPayment($lastPayment)
    {
        $this->lastPayment = $lastPayment;

        return $this;
    }

    /**
     * Get lastPayment
     *
     * @return \DateTime
     */
    public function getLastPayment()
    {
        return $this->lastPayment;
    }

    /**
     * Set lastContact
     *
     * @param \DateTime $lastContact
     *
     * @return User
     */
    public function setLastContact($lastContact)
    {
        $this->lastContact = $lastContact;

        return $this;
    }

    /**
     * Get lastContact
     *
     * @return \DateTime
     */
    public function getLastContact()
    {
        return $this->lastContact;
    }

    /**
     * Set documentConsulted
     *
     * @param boolean $documentConsulted
     *
     * @return User
     */
    public function setDocumentConsulted($documentConsulted)
    {
        $this->documentConsulted = $documentConsulted;

        return $this;
    }

    /**
     * Get documentConsulted
     *
     * @return boolean
     */
    public function getDocumentConsulted()
    {
        return $this->documentConsulted;
    }

    /**
     * Set messageConsulted
     *
     * @param boolean $messageConsulted
     *
     * @return User
     */
    public function setMessageConsulted($messageConsulted)
    {
        $this->messageConsulted = $messageConsulted;

        return $this;
    }

    /**
     * Get messageConsulted
     *
     * @return boolean
     */
    public function getMessageConsulted()
    {
        return $this->messageConsulted;
    }

    /**
     * Add child
     *
     * @param \AppBundle\Entity\Child $child
     *
     * @return User
     */
    public function addChild(\AppBundle\Entity\Child $child)
    {
        $this->childs[] = $child;

        return $this;
    }

    /**
     * Remove child
     *
     * @param \AppBundle\Entity\Child $child
     */
    public function removeChild(\AppBundle\Entity\Child $child)
    {
        $this->childs->removeElement($child);
    }

    /**
     * Get childs
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getChilds()
    {
        return $this->childs;
    }

    /**
     * Has group
     *
     * @param \AppBundle\Entity\Child $child
     * @return boolean
     */
    public function hasChild(\AppBundle\Entity\Child $child)
    {
        foreach ($this->childs as $item) {
            if($item == $child){
                return true;
            }
        }
        return false;
    }

    /**
     * Set fullName
     *
     * @param string $fullName
     *
     * @return User
     */
    public function setFullName()
    {
        $this->fullName = $this->getFirstName()." ".$this->getLastName();

        return $this;
    }

    /**
     * Get fullName
     *
     * @return string
     */
    public function getFullName()
    {
        return $this->fullName;
    }

    /**
     * Add document
     *
     * @param \AppBundle\Entity\Document $document
     *
     * @return User
     */
    public function addDocument(\AppBundle\Entity\Document $document)
    {
        $this->documents[] = $document;

        return $this;
    }

    /**
     * Remove document
     *
     * @param \AppBundle\Entity\Document $document
     */
    public function removeDocument(\AppBundle\Entity\Document $document)
    {
        $this->documents->removeElement($document);
    }

    /**
     * Get documents
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDocuments()
    {
        return $this->documents;
    }

    /**
     * Add message
     *
     * @param \AppBundle\Entity\Message $message
     *
     * @return User
     */
    public function addMessage(\AppBundle\Entity\Message $message)
    {
        $this->messages[] = $message;

        return $this;
    }

    /**
     * Remove message
     *
     * @param \AppBundle\Entity\Message $message
     */
    public function removeMessage(\AppBundle\Entity\Message $message)
    {
        $this->messages->removeElement($message);
    }

    /**
     * Get messages
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMessages()
    {
        return $this->messages;
    }

    /**
     * Add sponsorGroup
     *
     * @param \AppBundle\Entity\SponsorGroup $sponsorGroup
     *
     * @return User
     */
    public function addSponsorGroup(\AppBundle\Entity\SponsorGroup $sponsorGroup)
    {
        $this->sponsorGroups[] = $sponsorGroup;

        return $this;
    }

    /**
     * Remove sponsorGroup
     *
     * @param \AppBundle\Entity\SponsorGroup $sponsorGroup
     */
    public function removeSponsorGroup(\AppBundle\Entity\SponsorGroup $sponsorGroup)
    {
        $this->sponsorGroups->removeElement($sponsorGroup);
    }

    /**
     * Get sponsorGroups
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSponsorGroups()
    {
        return $this->sponsorGroups;
    }

    /**
     * Has group
     *
     * @param \AppBundle\Entity\SponsorGroup $group
     * @return boolean
     */
    public function hasSponsorGroup(SponsorGroup $group)
    {
        foreach ($this->sponsorGroups as $item) {
            if($item == $group){
                return true;
            }
        }
        return false;
    }

    /**
     * Set profileChanged
     *
     * @param boolean $profileChanged
     *
     * @return User
     */
    public function setProfileChanged($profileChanged)
    {
        $this->profileChanged = $profileChanged;

        return $this;
    }

    /**
     * Get profileChanged
     *
     * @return boolean
     */
    public function getProfileChanged()
    {
        return $this->profileChanged;
    }

    /**
     * Set complementAdress
     *
     * @param string $complementAdress
     *
     * @return User
     */
    public function setComplementAdress($complementAdress)
    {
        $this->complementAdress = $complementAdress;

        return $this;
    }

    /**
     * Get complementAdress
     *
     * @return string
     */
    public function getComplementAdress()
    {
        return $this->complementAdress;
    }

    /**
     * Set codePostal
     *
     * @param string $codePostal
     *
     * @return User
     */
    public function setCodePostal($codePostal)
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    /**
     * Get codePostal
     *
     * @return string
     */
    public function getCodePostal()
    {
        return $this->codePostal;
    }

    /**
     * Set ville
     *
     * @param string $ville
     *
     * @return User
     */
    public function setVille($ville)
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * Get ville
     *
     * @return string
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * Set pays
     *
     * @param string $pays
     *
     * @return User
     */
    public function setPays($pays)
    {
        $this->pays = $pays;

        return $this;
    }

    /**
     * Get pays
     *
     * @return string
     */
    public function getPays()
    {
        return $this->pays;
    }

    /**
     * Add coordinatorChild
     *
     * @param \AppBundle\Entity\Child $coordinatorChild
     *
     * @return User
     */
    public function addCoordinatorChild(\AppBundle\Entity\Child $coordinatorChild)
    {
        $this->coordinatorChilds[] = $coordinatorChild;

        return $this;
    }

    /**
     * Remove coordinatorChild
     *
     * @param \AppBundle\Entity\Child $coordinatorChild
     */
    public function removeCoordinatorChild(\AppBundle\Entity\Child $coordinatorChild)
    {
        $this->coordinatorChilds->removeElement($coordinatorChild);
    }

    /**
     * Get coordinatorChilds
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCoordinatorChilds()
    {
        return $this->coordinatorChilds;
    }
}
