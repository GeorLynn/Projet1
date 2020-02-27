<?php

namespace CommentQuizBundle\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Question
 *
 * @ORM\Table(name="question")
 * @ORM\Entity(repositoryClass="CommentQuizBundle\Repository\QuestionRepository")
 */
class Question
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
     * @Assert\Length(
     *     min=1,
     *     max=50,
     *     minMessage="The number field must contain at least one number",
     *     maxMessage="The number field must contain maximum 50 numbers"
     * )
     */
    private $enonce;
    /**
     * @ORM\Column(type="string")
     */
    private $rep1;
    /**
     * @ORM\Column(type="string")
     */
    private $rep2;
    /**
     * @ORM\Column(type="string")
     */
    private $rep3;

    /**
     * @return mixed
     */
    public function getRep3()
    {
        return $this->rep3;
    }

    /**
     * @param mixed $rep3
     */
    public function setRep3($rep3)
    {
        $this->rep3 = $rep3;
    }

    /**
     * @ORM\Column(type="string")
     */
    private $correct;






    public function __construct()
    {
        $this->reponse = new ArrayCollection();
    }


    /**
     * @return mixed
     */
    public function getRep1()
    {
        return $this->rep1;
    }

    /**
     * @param mixed $rep1
     */
    public function setRep1($rep1)
    {
        $this->rep1 = $rep1;
    }

    /**
     * @return mixed
     */
    public function getRep2()
    {
        return $this->rep2;
    }

    /**
     * @param mixed $rep2
     */
    public function setRep2($rep2)
    {
        $this->rep2 = $rep2;
    }

    /**
     * @return mixed
     */
    public function getCorrect()
    {
        return $this->correct;
    }

    /**
     * @param mixed $correct
     */
    public function setCorrect($correct)
    {
        $this->correct = $correct;
    }

    /**
     * @ORM\Column(type="string")
     */
    private $sujet;

    /**
     * @return mixed
     */
    public function getSujet()
    {
        return $this->sujet;
    }

    /**
     * @param mixed $sujet
     */
    public function setSujet($sujet)
    {
        $this->sujet = $sujet;
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
     * @return mixed
     */
    public function getEnonce()
    {
        return $this->enonce;
    }

    /**
     * @param mixed $enonce
     */
    public function setEnonce($enonce)
    {
        $this->enonce = $enonce;
    }





}

