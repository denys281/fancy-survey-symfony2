<?php

namespace Megogo\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Answer
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Megogo\CoreBundle\Entity\AnswerRepository")
 */
class Answer
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="ice_cream", type="string", length=255)
     */
    private $iceCream;

    /**
     * @var string
     *
     * @ORM\Column(name="superhero", type="string", length=255)
     */
    private $superhero;

    /**
     * @var string
     *
     * @ORM\Column(name="movie_star", type="string", length=255)
     */
    private $movieStar;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="world_end", type="date")
     */
    private $worldEnd;

    /**
     * @var string
     *
     * @ORM\Column(name="super_bowl", type="string", length=255)
     */
    private $superBowl;


    /**
     * @ORM\ManyToOne(targetEntity="Megogo\CoreBundle\Entity\User", inversedBy="answer")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=true, onDelete="CASCADE")
     */
    private $user;



    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set iceCream
     *
     * @param string $iceCream
     * @return Answer
     */
    public function setIceCream($iceCream)
    {
        $this->iceCream = $iceCream;

        return $this;
    }

    /**
     * Get iceCream
     *
     * @return string 
     */
    public function getIceCream()
    {
        return $this->iceCream;
    }

    /**
     * Set superhero
     *
     * @param string $superhero
     * @return Answer
     */
    public function setSuperhero($superhero)
    {
        $this->superhero = $superhero;

        return $this;
    }

    /**
     * Get superhero
     *
     * @return string 
     */
    public function getSuperhero()
    {
        return $this->superhero;
    }

    /**
     * Set movieStar
     *
     * @param string $movieStar
     * @return Answer
     */
    public function setMovieStar($movieStar)
    {
        $this->movieStar = $movieStar;

        return $this;
    }

    /**
     * Get movieStar
     *
     * @return string 
     */
    public function getMovieStar()
    {
        return $this->movieStar;
    }

    /**
     * Set worldEnd
     *
     * @param \DateTime $worldEnd
     * @return Answer
     */
    public function setWorldEnd($worldEnd)
    {
        $this->worldEnd = $worldEnd;

        return $this;
    }

    /**
     * Get worldEnd
     *
     * @return \DateTime 
     */
    public function getWorldEnd()
    {
        return $this->worldEnd;
    }

    /**
     * Set superBowl
     *
     * @param string $superBowl
     * @return Answer
     */
    public function setSuperBowl($superBowl)
    {
        $this->superBowl = $superBowl;

        return $this;
    }

    /**
     * Get superBowl
     *
     * @return string 
     */
    public function getSuperBowl()
    {
        return $this->superBowl;
    }

    /**
     * Set user
     *
     * @param \Megogo\CoreBundle\Entity\User $user
     * @return Answer
     */
    public function setUser(\Megogo\CoreBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Megogo\CoreBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }
}
