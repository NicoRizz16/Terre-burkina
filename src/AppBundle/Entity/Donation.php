<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Donation
 *
 * @ORM\Table(name="donation")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DonationRepository")
 */
class Donation
{
    const NUM_ITEMS = 20;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var float
     *
     * @ORM\Column(name="amount", type="float")
     */
    private $amount;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="donation_date", type="datetime")
     */
    private $donationDate;


    public function __construct()
    {
        $this->donationDate = new \DateTime();
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
     * Set amount
     *
     * @param float $amount
     *
     * @return Donation
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set donationDate
     *
     * @param \DateTime $donationDate
     *
     * @return Donation
     */
    public function setDonationDate($donationDate)
    {
        $this->donationDate = $donationDate;

        return $this;
    }

    /**
     * Get donationDate
     *
     * @return \DateTime
     */
    public function getDonationDate()
    {
        return $this->donationDate;
    }
}

