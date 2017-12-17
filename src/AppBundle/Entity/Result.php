<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Result
 *
 * @ORM\Table(name="result")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ResultRepository")
 */
class Result
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
     * @var int
     *
     * @ORM\Column(name="year", type="integer")
     * @Assert\NotBlank()
     * @Assert\Type(
     *      type="integer",
     *      message="La valeur {{ value }} n'est pas un {{ type }} valide."
     * )
     */
    private $year;

    /**
     * @var string
     *
     * @ORM\Column(name="average1", type="string", nullable=true)
     * @Assert\Length(
     *      max = 10,
     *      maxMessage = "La moyenne doit faire moins de {{ limit }} caractères."
     * )
     */
    private $average1;

    /**
     * @var string
     *
     * @ORM\Column(name="rank1", type="string", nullable=true)
     * @Assert\Length(
     *      max = 10,
     *      maxMessage = "Le rang doit faire moins de {{ limit }} caractères."
     * )
     */
    private $rank1;

    /**
     * @var string
     *
     * @ORM\Column(name="average2", type="string", nullable=true)
     * @Assert\Length(
     *      max = 10,
     *      maxMessage = "La moyenne doit faire moins de {{ limit }} caractères."
     * )
     */
    private $average2;

    /**
     * @var string
     *
     * @ORM\Column(name="rank2", type="string", nullable=true)
     * @Assert\Length(
     *      max = 10,
     *      maxMessage = "Le rang doit faire moins de {{ limit }} caractères."
     * )
     */
    private $rank2;

    /**
     * @var string
     *
     * @ORM\Column(name="average3", type="string", nullable=true)
     * @Assert\Length(
     *      max = 10,
     *      maxMessage = "La moyenne doit faire moins de {{ limit }} caractères."
     * )
     */
    private $average3;

    /**
     * @var string
     *
     * @ORM\Column(name="rank3", type="string", nullable=true)
     * @Assert\Length(
     *      max = 10,
     *      maxMessage = "Le rang doit faire moins de {{ limit }} caractères."
     * )
     */
    private $rank3;

    /**
     * @var string
     *
     * @ORM\Column(name="average_year", type="string", nullable=true)
     * @Assert\Length(
     *      max = 10,
     *      maxMessage = "La moyenne doit faire moins de {{ limit }} caractères."
     * )
     */
    private $averageYear;

    /**
     * @var string
     *
     * @ORM\Column(name="rank_year", type="string", nullable=true)
     * @Assert\Length(
     *      max = 10,
     *      maxMessage = "Le rang doit faire moins de {{ limit }} caractères."
     * )
     */
    private $rankYear;

    /**
     * @ORM\ManyToOne(targetEntity="Child", inversedBy="results")
     * @ORM\JoinColumn(name="child_id", referencedColumnName="id")
     */
    private $child;


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
     * Set year
     *
     * @param integer $year
     *
     * @return Result
     */
    public function setYear($year)
    {
        $this->year = $year;

        return $this;
    }

    /**
     * Get year
     *
     * @return int
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Set average1
     *
     * @param float $average1
     *
     * @return Result
     */
    public function setAverage1($average1)
    {
        $this->average1 = $average1;

        return $this;
    }

    /**
     * Get average1
     *
     * @return float
     */
    public function getAverage1()
    {
        return $this->average1;
    }

    /**
     * Set rank1
     *
     * @param float $rank1
     *
     * @return Result
     */
    public function setRank1($rank1)
    {
        $this->rank1 = $rank1;

        return $this;
    }

    /**
     * Get rank1
     *
     * @return float
     */
    public function getRank1()
    {
        return $this->rank1;
    }

    /**
     * Set average2
     *
     * @param float $average2
     *
     * @return Result
     */
    public function setAverage2($average2)
    {
        $this->average2 = $average2;

        return $this;
    }

    /**
     * Get average2
     *
     * @return float
     */
    public function getAverage2()
    {
        return $this->average2;
    }

    /**
     * Set rank2
     *
     * @param float $rank2
     *
     * @return Result
     */
    public function setRank2($rank2)
    {
        $this->rank2 = $rank2;

        return $this;
    }

    /**
     * Get rank2
     *
     * @return float
     */
    public function getRank2()
    {
        return $this->rank2;
    }

    /**
     * Set average3
     *
     * @param float $average3
     *
     * @return Result
     */
    public function setAverage3($average3)
    {
        $this->average3 = $average3;

        return $this;
    }

    /**
     * Get average3
     *
     * @return float
     */
    public function getAverage3()
    {
        return $this->average3;
    }

    /**
     * Set rank3
     *
     * @param float $rank3
     *
     * @return Result
     */
    public function setRank3($rank3)
    {
        $this->rank3 = $rank3;

        return $this;
    }

    /**
     * Get rank3
     *
     * @return float
     */
    public function getRank3()
    {
        return $this->rank3;
    }

    /**
     * Set averageYear
     *
     * @param float $averageYear
     *
     * @return Result
     */
    public function setAverageYear($averageYear)
    {
        $this->averageYear = $averageYear;

        return $this;
    }

    /**
     * Get averageYear
     *
     * @return float
     */
    public function getAverageYear()
    {
        return $this->averageYear;
    }

    /**
     * Set rankYear
     *
     * @param float $rankYear
     *
     * @return Result
     */
    public function setRankYear($rankYear)
    {
        $this->rankYear = $rankYear;

        return $this;
    }

    /**
     * Get rankYear
     *
     * @return float
     */
    public function getRankYear()
    {
        return $this->rankYear;
    }

    /**
     * Set child
     *
     * @param \AppBundle\Entity\Child $child
     *
     * @return Result
     */
    public function setChild(\AppBundle\Entity\Child $child = null)
    {
        $this->child = $child;

        return $this;
    }

    /**
     * Get child
     *
     * @return \AppBundle\Entity\Child
     */
    public function getChild()
    {
        return $this->child;
    }
}
