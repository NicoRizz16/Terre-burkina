<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Child
 *
 * @ORM\Table(name="child")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ChildRepository")
 * @UniqueEntity(
 *     fields={"dateOfBirth", "firstName", "lastName"},
 *     message="Un filleul avec les mêmes nom, prénom et date de naissance existe déjà."
 * )
 * @Vich\Uploadable
 */
class Child
{
    const NUM_ITEMS = 15;

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
     * @ORM\Column(name="first_name", type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 2,
     *      max = 255,
     *      minMessage = "Le prénom doit faire au moins {{ limit }} caractères.",
     *      maxMessage = "Le prénom doit faire moins de {{ limit }} caractères."
     * )
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 2,
     *      max = 255,
     *      minMessage = "Le nom doit faire au moins {{ limit }} caractères.",
     *      maxMessage = "Le nom doit faire moins de {{ limit }} caractères."
     * )
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
     * @ORM\Column(name="date_of_birth", type="datetime")
     * @Assert\Date()
     * @Assert\LessThanOrEqual("today")
     */
    private $dateOfBirth;

    /**
     * @var string
     *
     * @ORM\Column(name="adress", type="text", nullable=true)
     * @Assert\Length(
     *      min = 5,
     *      max = 1000,
     *      minMessage = "L'adresse doit faire au moins {{ limit }} caractères.",
     *      maxMessage = "L'adresse doit faire moins de {{ limit }} caractères."
     * )
     */
    private $adress;

    /**
     * @var string
     *
     * @ORM\Column(name="school", type="string", length=255, nullable=true)
     * @Assert\Length(
     *      min = 2,
     *      max = 255,
     *      minMessage = "Le nom d'école doit faire au moins {{ limit }} caractères.",
     *      maxMessage = "Le nom d'école doit faire moins de {{ limit }} caractères."
     * )
     */
    private $school;

    /**
     * @var string
     *
     * @ORM\Column(name="class", type="string", length=255, nullable=true)
     * @Assert\Length(
     *      min = 2,
     *      max = 255,
     *      minMessage = "La classe doit faire au moins {{ limit }} caractères.",
     *      maxMessage = "La classe doit faire moins de {{ limit }} caractères."
     * )
     */
    private $class;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=255, nullable=true)
     * @Assert\Length(
     *      min = 2,
     *      max = 255,
     *      minMessage = "Le numéro de téléphone doit faire au moins {{ limit }} caractères.",
     *      maxMessage = "Le numéro de téléphone doit faire moins de {{ limit }} caractères."
     * )
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="family_situation", type="string", length=255, nullable=true)
     * @Assert\Length(
     *      min = 2,
     *      max = 255,
     *      minMessage = "La situation familiale doit faire au moins {{ limit }} caractères.",
     *      maxMessage = "La situation familiale doit faire moins de {{ limit }} caractères."
     * )
     */
    private $familySituation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="sponsorship_start", type="datetime")
     * @Assert\Date()
     */
    private $sponsorshipStart;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="sponsorship_end", type="datetime", nullable=true)
     * @Assert\Date()
     */
    private $sponsorshipEnd;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_letter_date", type="datetime", nullable=true)
     * @Assert\Date()
     */
    private $lastLetterDate;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_sponsored", type="boolean")
     */
    private $isSponsored;

    /**
     * @var bool
     *
     * @ORM\Column(name="news_seen", type="boolean")
     */
    private $newsSeen;

    /**
     * @var bool
     *
     * @ORM\Column(name="photos_seen", type="boolean")
     */
    private $photosSeen;

    /**
     * @var bool
     *
     * @ORM\Column(name="results_seen", type="boolean")
     */
    private $resultsSeen;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="photos_child_profile", fileNameProperty="profilePhotoName")
     *
     * @var File
     * @Assert\Image()
     */
    private $profilePhoto;

    /**
     * @ORM\Column(name="profile_photo_name", type="string", length=255, nullable=true)
     *
     * @var string
     */
    private $profilePhotoName;

    /**
     * @ORM\Column(name="profile_photo_updated_date", type="datetime", nullable=true)
     *
     * @var \DateTime
     */
    private $profilePhotoUpdatedAt;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Photo", mappedBy="child")
     */
    private $photos;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\News", mappedBy="child")
     */
    private $news;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Result", mappedBy="child")
     */
    private $results;

    /**
     * @ORM\ManyToMany(targetEntity="ChildGroup")
     * @ORM\JoinTable(name="childs_groups",
     *      joinColumns={@ORM\JoinColumn(name="child_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="group_id", referencedColumnName="id")}
     *  )
     */
    private $groups;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="childs")
     * @ORM\JoinColumn(name="sponsor_id", referencedColumnName="id")
     */
    private $sponsor;


    public function __construct()
    {
        $this->setResultsSeen(true);
        $this->setPhotosSeen(true);
        $this->setNewsSeen(true);
        $this->setIsSponsored(false);
        $this->setSponsorshipStart(new \DateTime());
        $this->setSponsorshipEnd(new \DateTime());
        $this->groups = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the  update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $photo
     *
     * @return Child
     */
    public function setProfilePhoto(File $photo = null)
    {
        $this->profilePhoto = $photo;

        if ($photo) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->profilePhotoUpdatedAt = new \DateTimeImmutable();
        }

        return $this;
    }

    /**
     * @return File|null
     */
    public function getProfilePhoto()
    {
        return $this->profilePhoto;
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
     * Set firstName
     *
     * @param string $firstName
     *
     * @return Child
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
     * @return Child
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
     * @return Child
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
     * @return Child
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
     * Set school
     *
     * @param string $school
     *
     * @return Child
     */
    public function setSchool($school)
    {
        $this->school = $school;

        return $this;
    }

    /**
     * Get school
     *
     * @return string
     */
    public function getSchool()
    {
        return $this->school;
    }

    /**
     * Set class
     *
     * @param string $class
     *
     * @return Child
     */
    public function setClass($class)
    {
        $this->class = $class;

        return $this;
    }

    /**
     * Get class
     *
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return Child
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
     * Set familySituation
     *
     * @param string $familySituation
     *
     * @return Child
     */
    public function setFamilySituation($familySituation)
    {
        $this->familySituation = $familySituation;

        return $this;
    }

    /**
     * Get familySituation
     *
     * @return string
     */
    public function getFamilySituation()
    {
        return $this->familySituation;
    }

    /**
     * Set sponsorshipStart
     *
     * @param \DateTime $sponsorshipStart
     *
     * @return Child
     */
    public function setSponsorshipStart($sponsorshipStart)
    {
        $this->sponsorshipStart = $sponsorshipStart;

        return $this;
    }

    /**
     * Get sponsorshipStart
     *
     * @return \DateTime
     */
    public function getSponsorshipStart()
    {
        return $this->sponsorshipStart;
    }

    /**
     * Set sponsorshipEnd
     *
     * @param \DateTime $sponsorshipEnd
     *
     * @return Child
     */
    public function setSponsorshipEnd($sponsorshipEnd)
    {
        $this->sponsorshipEnd = $sponsorshipEnd;

        return $this;
    }

    /**
     * Get sponsorshipEnd
     *
     * @return \DateTime
     */
    public function getSponsorshipEnd()
    {
        return $this->sponsorshipEnd;
    }

    /**
     * Set lastLetterDate
     *
     * @param \DateTime $lastLetterDate
     *
     * @return Child
     */
    public function setLastLetterDate($lastLetterDate)
    {
        $this->lastLetterDate = $lastLetterDate;

        return $this;
    }

    /**
     * Get lastLetterDate
     *
     * @return \DateTime
     */
    public function getLastLetterDate()
    {
        return $this->lastLetterDate;
    }

    /**
     * Set isSponsored
     *
     * @param boolean $isSponsored
     *
     * @return Child
     */
    public function setIsSponsored($isSponsored)
    {
        $this->isSponsored = $isSponsored;

        return $this;
    }

    /**
     * Get isSponsored
     *
     * @return bool
     */
    public function getIsSponsored()
    {
        return $this->isSponsored;
    }

    /**
     * Set newsSeen
     *
     * @param boolean $newsSeen
     *
     * @return Child
     */
    public function setNewsSeen($newsSeen)
    {
        $this->newsSeen = $newsSeen;

        return $this;
    }

    /**
     * Get newsSeen
     *
     * @return bool
     */
    public function getNewsSeen()
    {
        return $this->newsSeen;
    }

    /**
     * Set photosSeen
     *
     * @param boolean $photosSeen
     *
     * @return Child
     */
    public function setPhotosSeen($photosSeen)
    {
        $this->photosSeen = $photosSeen;

        return $this;
    }

    /**
     * Get photosSeen
     *
     * @return bool
     */
    public function getPhotosSeen()
    {
        return $this->photosSeen;
    }

    /**
     * Set resultsSeen
     *
     * @param boolean $resultsSeen
     *
     * @return Child
     */
    public function setResultsSeen($resultsSeen)
    {
        $this->resultsSeen = $resultsSeen;

        return $this;
    }

    /**
     * Get resultsSeen
     *
     * @return bool
     */
    public function getResultsSeen()
    {
        return $this->resultsSeen;
    }

    /**
     * Set profilePhotoName
     *
     * @param string $profilePhotoName
     *
     * @return Child
     */
    public function setProfilePhotoName($profilePhotoName)
    {
        $this->profilePhotoName = $profilePhotoName;

        return $this;
    }

    /**
     * Get profilePhotoName
     *
     * @return string
     */
    public function getProfilePhotoName()
    {
        return $this->profilePhotoName;
    }

    /**
     * Set profilePhotoUpdatedAt
     *
     * @param \DateTime $profilePhotoUpdatedAt
     *
     * @return Child
     */
    public function setProfilePhotoUpdatedAt($profilePhotoUpdatedAt)
    {
        $this->profilePhotoUpdatedAt = $profilePhotoUpdatedAt;

        return $this;
    }

    /**
     * Get profilePhotoUpdatedAt
     *
     * @return \DateTime
     */
    public function getProfilePhotoUpdatedAt()
    {
        return $this->profilePhotoUpdatedAt;
    }

    /**
     * Add photo
     *
     * @param \AppBundle\Entity\Photo $photo
     *
     * @return Child
     */
    public function addPhoto(\AppBundle\Entity\Photo $photo)
    {
        $this->photos[] = $photo;

        return $this;
    }

    /**
     * Remove photo
     *
     * @param \AppBundle\Entity\Photo $photo
     */
    public function removePhoto(\AppBundle\Entity\Photo $photo)
    {
        $this->photos->removeElement($photo);
    }

    /**
     * Get photos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPhotos()
    {
        return $this->photos;
    }

    /**
     * Add group
     *
     * @param \AppBundle\Entity\ChildGroup $group
     *
     * @return Child
     */
    public function addGroup(\AppBundle\Entity\ChildGroup $group)
    {
        $this->groups[] = $group;

        return $this;
    }

    /**
     * Remove group
     *
     * @param \AppBundle\Entity\ChildGroup $group
     */
    public function removeGroup(\AppBundle\Entity\ChildGroup $group)
    {
        $this->groups->removeElement($group);
    }

    /**
     * Has group
     *
     * @param \AppBundle\Entity\ChildGroup $group
     * @return boolean
     */
    public function hasGroup(ChildGroup $group)
    {
        foreach ($this->groups as $item) {
            if($item == $group){
                return true;
            }
        }
        return false;
    }

    /**
     * Get groups
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getGroups()
    {
        return $this->groups;
    }

    /**
     * Add news
     *
     * @param \AppBundle\Entity\News $news
     *
     * @return Child
     */
    public function addNews(\AppBundle\Entity\News $news)
    {
        $this->news[] = $news;

        return $this;
    }

    /**
     * Remove news
     *
     * @param \AppBundle\Entity\News $news
     */
    public function removeNews(\AppBundle\Entity\News $news)
    {
        $this->news->removeElement($news);
    }

    /**
     * Get news
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getNews()
    {
        return $this->news;
    }

    /**
     * Add result
     *
     * @param \AppBundle\Entity\Result $result
     *
     * @return Child
     */
    public function addResult(\AppBundle\Entity\Result $result)
    {
        $this->results[] = $result;

        return $this;
    }

    /**
     * Remove result
     *
     * @param \AppBundle\Entity\Result $result
     */
    public function removeResult(\AppBundle\Entity\Result $result)
    {
        $this->results->removeElement($result);
    }

    /**
     * Get results
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getResults()
    {
        return $this->results;
    }

    public function getAge()
    {
        $now = new \DateTime();
        $interval = $this->dateOfBirth->diff($now);
        return $interval->format('%y');
    }

    /**
     * Set sponsor
     *
     * @param \AppBundle\Entity\User $sponsor
     *
     * @return Child
     */
    public function setSponsor(\AppBundle\Entity\User $sponsor = null)
    {
        $this->sponsor = $sponsor;

        return $this;
    }

    /**
     * Get sponsor
     *
     * @return \AppBundle\Entity\User
     */
    public function getSponsor()
    {
        return $this->sponsor;
    }

    /**
     * Set fullName
     *
     * @param string $fullName
     *
     * @return Child
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
}
