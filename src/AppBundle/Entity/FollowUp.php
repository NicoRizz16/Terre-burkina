<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FollowUp
 *
 * @ORM\Table(name="follow_up")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FollowUpRepository")
 */
class FollowUp
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
     * @ORM\OneToOne(targetEntity="Child", inversedBy="followUp")
     * @ORM\JoinColumn(name="child_id", referencedColumnName="id")
     */
    private $child;

    /**
     * @var bool
     *
     * @ORM\Column(name="letter1", type="boolean")
     */
    private $letter1;

    /**
     * @var bool
     *
     * @ORM\Column(name="photo1", type="boolean")
     */
    private $photo1;

    /**
     * @var bool
     *
     * @ORM\Column(name="news1", type="boolean")
     */
    private $news1;

    /**
     * @var bool
     *
     * @ORM\Column(name="result1", type="boolean")
     */
    private $result1;

    /**
     * @var bool
     *
     * @ORM\Column(name="letter2", type="boolean")
     */
    private $letter2;

    /**
     * @var bool
     *
     * @ORM\Column(name="photo2", type="boolean")
     */
    private $photo2;

    /**
     * @var bool
     *
     * @ORM\Column(name="news2", type="boolean")
     */
    private $news2;

    /**
     * @var bool
     *
     * @ORM\Column(name="result2", type="boolean")
     */
    private $result2;

    /**
     * @var bool
     *
     * @ORM\Column(name="letter3", type="boolean")
     */
    private $letter3;

    /**
     * @var bool
     *
     * @ORM\Column(name="photo3", type="boolean")
     */
    private $photo3;

    /**
     * @var bool
     *
     * @ORM\Column(name="news3", type="boolean")
     */
    private $news3;

    /**
     * @var bool
     *
     * @ORM\Column(name="result3", type="boolean")
     */
    private $result3;

    /**
     * @var bool
     *
     * @ORM\Column(name="letter4", type="boolean")
     */
    private $letter4;

    /**
     * @var bool
     *
     * @ORM\Column(name="photo4", type="boolean")
     */
    private $photo4;

    /**
     * @var bool
     *
     * @ORM\Column(name="news4", type="boolean")
     */
    private $news4;

    /**
     * @var bool
     *
     * @ORM\Column(name="result4", type="boolean")
     */
    private $result4;

    /**
     * @var bool
     *
     * @ORM\Column(name="letter5", type="boolean")
     */
    private $letter5;

    /**
     * @var bool
     *
     * @ORM\Column(name="photo5", type="boolean")
     */
    private $photo5;

    /**
     * @var bool
     *
     * @ORM\Column(name="news5", type="boolean")
     */
    private $news5;

    /**
     * @var bool
     *
     * @ORM\Column(name="result5", type="boolean")
     */
    private $result5;

    /**
     * @var bool
     *
     * @ORM\Column(name="letter6", type="boolean")
     */
    private $letter6;

    /**
     * @var bool
     *
     * @ORM\Column(name="photo6", type="boolean")
     */
    private $photo6;

    /**
     * @var bool
     *
     * @ORM\Column(name="news6", type="boolean")
     */
    private $news6;

    /**
     * @var bool
     *
     * @ORM\Column(name="result6", type="boolean")
     */
    private $result6;

    /**
     * @var bool
     *
     * @ORM\Column(name="letter7", type="boolean")
     */
    private $letter7;

    /**
     * @var bool
     *
     * @ORM\Column(name="photo7", type="boolean")
     */
    private $photo7;

    /**
     * @var bool
     *
     * @ORM\Column(name="news7", type="boolean")
     */
    private $news7;

    /**
     * @var bool
     *
     * @ORM\Column(name="result7", type="boolean")
     */
    private $result7;

    /**
     * @var bool
     *
     * @ORM\Column(name="letter8", type="boolean")
     */
    private $letter8;

    /**
     * @var bool
     *
     * @ORM\Column(name="photo8", type="boolean")
     */
    private $photo8;

    /**
     * @var bool
     *
     * @ORM\Column(name="news8", type="boolean")
     */
    private $news8;

    /**
     * @var bool
     *
     * @ORM\Column(name="result8", type="boolean")
     */
    private $result8;

    /**
     * @var bool
     *
     * @ORM\Column(name="letter9", type="boolean")
     */
    private $letter9;

    /**
     * @var bool
     *
     * @ORM\Column(name="photo9", type="boolean")
     */
    private $photo9;

    /**
     * @var bool
     *
     * @ORM\Column(name="news9", type="boolean")
     */
    private $news9;

    /**
     * @var bool
     *
     * @ORM\Column(name="result9", type="boolean")
     */
    private $result9;

    /**
     * @var bool
     *
     * @ORM\Column(name="letter10", type="boolean")
     */
    private $letter10;

    /**
     * @var bool
     *
     * @ORM\Column(name="photo10", type="boolean")
     */
    private $photo10;

    /**
     * @var bool
     *
     * @ORM\Column(name="news10", type="boolean")
     */
    private $news10;

    /**
     * @var bool
     *
     * @ORM\Column(name="result10", type="boolean")
     */
    private $result10;

    /**
     * @var bool
     *
     * @ORM\Column(name="letter11", type="boolean")
     */
    private $letter11;

    /**
     * @var bool
     *
     * @ORM\Column(name="photo11", type="boolean")
     */
    private $photo11;

    /**
     * @var bool
     *
     * @ORM\Column(name="news11", type="boolean")
     */
    private $news11;

    /**
     * @var bool
     *
     * @ORM\Column(name="result11", type="boolean")
     */
    private $result11;

    /**
     * @var bool
     *
     * @ORM\Column(name="letter12", type="boolean")
     */
    private $letter12;

    /**
     * @var bool
     *
     * @ORM\Column(name="photo12", type="boolean")
     */
    private $photo12;

    /**
     * @var bool
     *
     * @ORM\Column(name="news12", type="boolean")
     */
    private $news12;

    /**
     * @var bool
     *
     * @ORM\Column(name="result12", type="boolean")
     */
    private $result12;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="endYearDate", type="datetime")
     */
    private $endYearDate;

    
    public function __construct()
    {
        $this->setLetter1(false);
        $this->setLetter2(false);
        $this->setLetter3(false);
        $this->setLetter4(false);
        $this->setLetter5(false);
        $this->setLetter6(false);
        $this->setLetter7(false);
        $this->setLetter8(false);
        $this->setLetter9(false);
        $this->setLetter10(false);
        $this->setLetter11(false);
        $this->setLetter12(false);
        
        $this->setPhoto1(false);
        $this->setPhoto2(false);
        $this->setPhoto3(false);
        $this->setPhoto4(false);
        $this->setPhoto5(false);
        $this->setPhoto6(false);
        $this->setPhoto7(false);
        $this->setPhoto8(false);
        $this->setPhoto9(false);
        $this->setPhoto10(false);
        $this->setPhoto11(false);
        $this->setPhoto12(false);

        $this->setNews1(false);
        $this->setNews2(false);
        $this->setNews3(false);
        $this->setNews4(false);
        $this->setNews5(false);
        $this->setNews6(false);
        $this->setNews7(false);
        $this->setNews8(false);
        $this->setNews9(false);
        $this->setNews10(false);
        $this->setNews11(false);
        $this->setNews12(false);

        $this->setResult1(false);
        $this->setResult2(false);
        $this->setResult3(false);
        $this->setResult4(false);
        $this->setResult5(false);
        $this->setResult6(false);
        $this->setResult7(false);
        $this->setResult8(false);
        $this->setResult9(false);
        $this->setResult10(false);
        $this->setResult11(false);
        $this->setResult12(false);

        $this->calculateEndYearDate();
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
     * Set letter1
     *
     * @param boolean $letter1
     *
     * @return FollowUp
     */
    public function setLetter1($letter1)
    {
        $this->letter1 = $letter1;

        return $this;
    }

    /**
     * Get letter1
     *
     * @return bool
     */
    public function getLetter1()
    {
        return $this->letter1;
    }

    /**
     * Set photo1
     *
     * @param boolean $photo1
     *
     * @return FollowUp
     */
    public function setPhoto1($photo1)
    {
        $this->photo1 = $photo1;

        return $this;
    }

    /**
     * Get photo1
     *
     * @return bool
     */
    public function getPhoto1()
    {
        return $this->photo1;
    }

    /**
     * Set news1
     *
     * @param boolean $news1
     *
     * @return FollowUp
     */
    public function setNews1($news1)
    {
        $this->news1 = $news1;

        return $this;
    }

    /**
     * Get news1
     *
     * @return bool
     */
    public function getNews1()
    {
        return $this->news1;
    }

    /**
     * Set result1
     *
     * @param boolean $result1
     *
     * @return FollowUp
     */
    public function setResult1($result1)
    {
        $this->result1 = $result1;

        return $this;
    }

    /**
     * Get result1
     *
     * @return bool
     */
    public function getResult1()
    {
        return $this->result1;
    }

    /**
     * Set letter2
     *
     * @param boolean $letter2
     *
     * @return FollowUp
     */
    public function setLetter2($letter2)
    {
        $this->letter2 = $letter2;

        return $this;
    }

    /**
     * Get letter2
     *
     * @return bool
     */
    public function getLetter2()
    {
        return $this->letter2;
    }

    /**
     * Set photo2
     *
     * @param boolean $photo2
     *
     * @return FollowUp
     */
    public function setPhoto2($photo2)
    {
        $this->photo2 = $photo2;

        return $this;
    }

    /**
     * Get photo2
     *
     * @return bool
     */
    public function getPhoto2()
    {
        return $this->photo2;
    }

    /**
     * Set news2
     *
     * @param boolean $news2
     *
     * @return FollowUp
     */
    public function setNews2($news2)
    {
        $this->news2 = $news2;

        return $this;
    }

    /**
     * Get news2
     *
     * @return bool
     */
    public function getNews2()
    {
        return $this->news2;
    }

    /**
     * Set result2
     *
     * @param boolean $result2
     *
     * @return FollowUp
     */
    public function setResult2($result2)
    {
        $this->result2 = $result2;

        return $this;
    }

    /**
     * Get result2
     *
     * @return bool
     */
    public function getResult2()
    {
        return $this->result2;
    }

    /**
     * Set letter3
     *
     * @param boolean $letter3
     *
     * @return FollowUp
     */
    public function setLetter3($letter3)
    {
        $this->letter3 = $letter3;

        return $this;
    }

    /**
     * Get letter3
     *
     * @return bool
     */
    public function getLetter3()
    {
        return $this->letter3;
    }

    /**
     * Set photo3
     *
     * @param boolean $photo3
     *
     * @return FollowUp
     */
    public function setPhoto3($photo3)
    {
        $this->photo3 = $photo3;

        return $this;
    }

    /**
     * Get photo3
     *
     * @return bool
     */
    public function getPhoto3()
    {
        return $this->photo3;
    }

    /**
     * Set news3
     *
     * @param boolean $news3
     *
     * @return FollowUp
     */
    public function setNews3($news3)
    {
        $this->news3 = $news3;

        return $this;
    }

    /**
     * Get news3
     *
     * @return bool
     */
    public function getNews3()
    {
        return $this->news3;
    }

    /**
     * Set result3
     *
     * @param boolean $result3
     *
     * @return FollowUp
     */
    public function setResult3($result3)
    {
        $this->result3 = $result3;

        return $this;
    }

    /**
     * Get result3
     *
     * @return bool
     */
    public function getResult3()
    {
        return $this->result3;
    }

    /**
     * Set letter4
     *
     * @param boolean $letter4
     *
     * @return FollowUp
     */
    public function setLetter4($letter4)
    {
        $this->letter4 = $letter4;

        return $this;
    }

    /**
     * Get letter4
     *
     * @return bool
     */
    public function getLetter4()
    {
        return $this->letter4;
    }

    /**
     * Set photo4
     *
     * @param boolean $photo4
     *
     * @return FollowUp
     */
    public function setPhoto4($photo4)
    {
        $this->photo4 = $photo4;

        return $this;
    }

    /**
     * Get photo4
     *
     * @return bool
     */
    public function getPhoto4()
    {
        return $this->photo4;
    }

    /**
     * Set news4
     *
     * @param boolean $news4
     *
     * @return FollowUp
     */
    public function setNews4($news4)
    {
        $this->news4 = $news4;

        return $this;
    }

    /**
     * Get news4
     *
     * @return bool
     */
    public function getNews4()
    {
        return $this->news4;
    }

    /**
     * Set result4
     *
     * @param boolean $result4
     *
     * @return FollowUp
     */
    public function setResult4($result4)
    {
        $this->result4 = $result4;

        return $this;
    }

    /**
     * Get result4
     *
     * @return bool
     */
    public function getResult4()
    {
        return $this->result4;
    }

    /**
     * Set letter5
     *
     * @param boolean $letter5
     *
     * @return FollowUp
     */
    public function setLetter5($letter5)
    {
        $this->letter5 = $letter5;

        return $this;
    }

    /**
     * Get letter5
     *
     * @return bool
     */
    public function getLetter5()
    {
        return $this->letter5;
    }

    /**
     * Set photo5
     *
     * @param boolean $photo5
     *
     * @return FollowUp
     */
    public function setPhoto5($photo5)
    {
        $this->photo5 = $photo5;

        return $this;
    }

    /**
     * Get photo5
     *
     * @return bool
     */
    public function getPhoto5()
    {
        return $this->photo5;
    }

    /**
     * Set news5
     *
     * @param boolean $news5
     *
     * @return FollowUp
     */
    public function setNews5($news5)
    {
        $this->news5 = $news5;

        return $this;
    }

    /**
     * Get news5
     *
     * @return bool
     */
    public function getNews5()
    {
        return $this->news5;
    }

    /**
     * Set result5
     *
     * @param boolean $result5
     *
     * @return FollowUp
     */
    public function setResult5($result5)
    {
        $this->result5 = $result5;

        return $this;
    }

    /**
     * Get result5
     *
     * @return bool
     */
    public function getResult5()
    {
        return $this->result5;
    }

    /**
     * Set letter6
     *
     * @param boolean $letter6
     *
     * @return FollowUp
     */
    public function setLetter6($letter6)
    {
        $this->letter6 = $letter6;

        return $this;
    }

    /**
     * Get letter6
     *
     * @return bool
     */
    public function getLetter6()
    {
        return $this->letter6;
    }

    /**
     * Set news6
     *
     * @param boolean $news6
     *
     * @return FollowUp
     */
    public function setNews6($news6)
    {
        $this->news6 = $news6;

        return $this;
    }

    /**
     * Get news6
     *
     * @return bool
     */
    public function getNews6()
    {
        return $this->news6;
    }

    /**
     * Set result6
     *
     * @param boolean $result6
     *
     * @return FollowUp
     */
    public function setResult6($result6)
    {
        $this->result6 = $result6;

        return $this;
    }

    /**
     * Get result6
     *
     * @return bool
     */
    public function getResult6()
    {
        return $this->result6;
    }

    /**
     * Set letter7
     *
     * @param boolean $letter7
     *
     * @return FollowUp
     */
    public function setLetter7($letter7)
    {
        $this->letter7 = $letter7;

        return $this;
    }

    /**
     * Get letter7
     *
     * @return bool
     */
    public function getLetter7()
    {
        return $this->letter7;
    }

    /**
     * Set photo7
     *
     * @param boolean $photo7
     *
     * @return FollowUp
     */
    public function setPhoto7($photo7)
    {
        $this->photo7 = $photo7;

        return $this;
    }

    /**
     * Get photo7
     *
     * @return bool
     */
    public function getPhoto7()
    {
        return $this->photo7;
    }

    /**
     * Set news7
     *
     * @param boolean $news7
     *
     * @return FollowUp
     */
    public function setNews7($news7)
    {
        $this->news7 = $news7;

        return $this;
    }

    /**
     * Get news7
     *
     * @return bool
     */
    public function getNews7()
    {
        return $this->news7;
    }

    /**
     * Set result7
     *
     * @param boolean $result7
     *
     * @return FollowUp
     */
    public function setResult7($result7)
    {
        $this->result7 = $result7;

        return $this;
    }

    /**
     * Get result7
     *
     * @return bool
     */
    public function getResult7()
    {
        return $this->result7;
    }

    /**
     * Set letter8
     *
     * @param boolean $letter8
     *
     * @return FollowUp
     */
    public function setLetter8($letter8)
    {
        $this->letter8 = $letter8;

        return $this;
    }

    /**
     * Get letter8
     *
     * @return bool
     */
    public function getLetter8()
    {
        return $this->letter8;
    }

    /**
     * Set photo8
     *
     * @param boolean $photo8
     *
     * @return FollowUp
     */
    public function setPhoto8($photo8)
    {
        $this->photo8 = $photo8;

        return $this;
    }

    /**
     * Get photo8
     *
     * @return bool
     */
    public function getPhoto8()
    {
        return $this->photo8;
    }

    /**
     * Set news8
     *
     * @param boolean $news8
     *
     * @return FollowUp
     */
    public function setNews8($news8)
    {
        $this->news8 = $news8;

        return $this;
    }

    /**
     * Get news8
     *
     * @return bool
     */
    public function getNews8()
    {
        return $this->news8;
    }

    /**
     * Set result8
     *
     * @param boolean $result8
     *
     * @return FollowUp
     */
    public function setResult8($result8)
    {
        $this->result8 = $result8;

        return $this;
    }

    /**
     * Get result8
     *
     * @return bool
     */
    public function getResult8()
    {
        return $this->result8;
    }

    /**
     * Set letter9
     *
     * @param boolean $letter9
     *
     * @return FollowUp
     */
    public function setLetter9($letter9)
    {
        $this->letter9 = $letter9;

        return $this;
    }

    /**
     * Get letter9
     *
     * @return bool
     */
    public function getLetter9()
    {
        return $this->letter9;
    }

    /**
     * Set photo9
     *
     * @param boolean $photo9
     *
     * @return FollowUp
     */
    public function setPhoto9($photo9)
    {
        $this->photo9 = $photo9;

        return $this;
    }

    /**
     * Get photo9
     *
     * @return bool
     */
    public function getPhoto9()
    {
        return $this->photo9;
    }

    /**
     * Set news9
     *
     * @param boolean $news9
     *
     * @return FollowUp
     */
    public function setNews9($news9)
    {
        $this->news9 = $news9;

        return $this;
    }

    /**
     * Get news9
     *
     * @return bool
     */
    public function getNews9()
    {
        return $this->news9;
    }

    /**
     * Set result9
     *
     * @param boolean $result9
     *
     * @return FollowUp
     */
    public function setResult9($result9)
    {
        $this->result9 = $result9;

        return $this;
    }

    /**
     * Get result9
     *
     * @return bool
     */
    public function getResult9()
    {
        return $this->result9;
    }

    /**
     * Set letter10
     *
     * @param boolean $letter10
     *
     * @return FollowUp
     */
    public function setLetter10($letter10)
    {
        $this->letter10 = $letter10;

        return $this;
    }

    /**
     * Get letter10
     *
     * @return bool
     */
    public function getLetter10()
    {
        return $this->letter10;
    }

    /**
     * Set photo10
     *
     * @param boolean $photo10
     *
     * @return FollowUp
     */
    public function setPhoto10($photo10)
    {
        $this->photo10 = $photo10;

        return $this;
    }

    /**
     * Get photo10
     *
     * @return bool
     */
    public function getPhoto10()
    {
        return $this->photo10;
    }

    /**
     * Set news10
     *
     * @param boolean $news10
     *
     * @return FollowUp
     */
    public function setNews10($news10)
    {
        $this->news10 = $news10;

        return $this;
    }

    /**
     * Get news10
     *
     * @return bool
     */
    public function getNews10()
    {
        return $this->news10;
    }

    /**
     * Set result10
     *
     * @param boolean $result10
     *
     * @return FollowUp
     */
    public function setResult10($result10)
    {
        $this->result10 = $result10;

        return $this;
    }

    /**
     * Get result10
     *
     * @return bool
     */
    public function getResult10()
    {
        return $this->result10;
    }

    /**
     * Set letter11
     *
     * @param boolean $letter11
     *
     * @return FollowUp
     */
    public function setLetter11($letter11)
    {
        $this->letter11 = $letter11;

        return $this;
    }

    /**
     * Get letter11
     *
     * @return bool
     */
    public function getLetter11()
    {
        return $this->letter11;
    }

    /**
     * Set photo11
     *
     * @param boolean $photo11
     *
     * @return FollowUp
     */
    public function setPhoto11($photo11)
    {
        $this->photo11 = $photo11;

        return $this;
    }

    /**
     * Get photo11
     *
     * @return bool
     */
    public function getPhoto11()
    {
        return $this->photo11;
    }

    /**
     * Set news11
     *
     * @param boolean $news11
     *
     * @return FollowUp
     */
    public function setNews11($news11)
    {
        $this->news11 = $news11;

        return $this;
    }

    /**
     * Get news11
     *
     * @return bool
     */
    public function getNews11()
    {
        return $this->news11;
    }

    /**
     * Set result11
     *
     * @param boolean $result11
     *
     * @return FollowUp
     */
    public function setResult11($result11)
    {
        $this->result11 = $result11;

        return $this;
    }

    /**
     * Get result11
     *
     * @return bool
     */
    public function getResult11()
    {
        return $this->result11;
    }

    /**
     * Set letter12
     *
     * @param boolean $letter12
     *
     * @return FollowUp
     */
    public function setLetter12($letter12)
    {
        $this->letter12 = $letter12;

        return $this;
    }

    /**
     * Get letter12
     *
     * @return bool
     */
    public function getLetter12()
    {
        return $this->letter12;
    }

    /**
     * Set photo12
     *
     * @param boolean $photo12
     *
     * @return FollowUp
     */
    public function setPhoto12($photo12)
    {
        $this->photo12 = $photo12;

        return $this;
    }

    /**
     * Get photo12
     *
     * @return bool
     */
    public function getPhoto12()
    {
        return $this->photo12;
    }

    /**
     * Set news12
     *
     * @param boolean $news12
     *
     * @return FollowUp
     */
    public function setNews12($news12)
    {
        $this->news12 = $news12;

        return $this;
    }

    /**
     * Get news12
     *
     * @return bool
     */
    public function getNews12()
    {
        return $this->news12;
    }

    /**
     * Set result12
     *
     * @param boolean $result12
     *
     * @return FollowUp
     */
    public function setResult12($result12)
    {
        $this->result12 = $result12;

        return $this;
    }

    /**
     * Get result12
     *
     * @return bool
     */
    public function getResult12()
    {
        return $this->result12;
    }

    /**
     * Set endYearDate
     *
     * @param \DateTime $endYearDate
     *
     * @return FollowUp
     */
    public function setEndYearDate($endYearDate)
    {
        $this->endYearDate = $endYearDate;

        return $this;
    }

    /**
     * Get endYearDate
     *
     * @return \DateTime
     */
    public function getEndYearDate()
    {
        return $this->endYearDate;
    }

    /**
     * Set photo6
     *
     * @param boolean $photo6
     *
     * @return FollowUp
     */
    public function setPhoto6($photo6)
    {
        $this->photo6 = $photo6;

        return $this;
    }

    /**
     * Get photo6
     *
     * @return boolean
     */
    public function getPhoto6()
    {
        return $this->photo6;
    }

    public function calculateEndYearDate()
    {
        // Calcul de la date de fin d'année de suivi (fin septembre) par rapport à la date actuelle
        $date = new \DateTime();
        $year = (int) $date->format('Y');
        $endYearDateYear = $year;
        $month = (int) $date->format('m');
        if($month>9) { // Si on est après le mois de septembre
            $endYearDateYear = $year+1;
        }
        $endYearDate = new \DateTime($endYearDateYear.'-09-30');

        $this->endYearDate = $endYearDate;

        return $this;
    }

    public function getBeginYearDate()
    {
        $endYearDate = $this->getEndYearDate();
        $beginYearDate = $endYearDate->modify('+1 day');
        $beginYearDate = $beginYearDate->modify('-1 year');

        return $beginYearDate;
    }

    public function resetFollowUp()
    {
        $this->setLetter1(false);
        $this->setLetter2(false);
        $this->setLetter3(false);
        $this->setLetter4(false);
        $this->setLetter5(false);
        $this->setLetter6(false);
        $this->setLetter7(false);
        $this->setLetter8(false);
        $this->setLetter9(false);
        $this->setLetter10(false);
        $this->setLetter11(false);
        $this->setLetter12(false);

        $this->setPhoto1(false);
        $this->setPhoto2(false);
        $this->setPhoto3(false);
        $this->setPhoto4(false);
        $this->setPhoto5(false);
        $this->setPhoto6(false);
        $this->setPhoto7(false);
        $this->setPhoto8(false);
        $this->setPhoto9(false);
        $this->setPhoto10(false);
        $this->setPhoto11(false);
        $this->setPhoto12(false);

        $this->setNews1(false);
        $this->setNews2(false);
        $this->setNews3(false);
        $this->setNews4(false);
        $this->setNews5(false);
        $this->setNews6(false);
        $this->setNews7(false);
        $this->setNews8(false);
        $this->setNews9(false);
        $this->setNews10(false);
        $this->setNews11(false);
        $this->setNews12(false);

        $this->setResult1(false);
        $this->setResult2(false);
        $this->setResult3(false);
        $this->setResult4(false);
        $this->setResult5(false);
        $this->setResult6(false);
        $this->setResult7(false);
        $this->setResult8(false);
        $this->setResult9(false);
        $this->setResult10(false);
        $this->setResult11(false);
        $this->setResult12(false);

        $this->calculateEndYearDate();

        return $this;
    }

    /**
     * Set child
     *
     * @param \AppBundle\Entity\Child $child
     *
     * @return FollowUp
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
