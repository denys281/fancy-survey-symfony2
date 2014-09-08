<?php

namespace Megogo\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use JMS\Serializer\Annotation\XmlRoot;

/**
 * User
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Megogo\CoreBundle\Entity\UserRepository")
 */
class User
{
    use  ORMBehaviors\Timestampable\Timestampable;

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
     * @Assert\NotNull()
     * @ORM\Column(name="first_name", type="string", length=255)
     */
    private $firstName;

    /**
     * @var string
     *
     * @Assert\NotNull()
     * @ORM\Column(name="last_name", type="string", length=255)
     */
    private $lastName;

    /**
     * @var string
     *
     * @Assert\NotNull()
     * @Assert\Email()
     *
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="birthday", type="date")
     */
    private $birthday;

    /**
     * @var float
     *
     * @Assert\NotNull()
     * @ORM\Column(name="shoe_size", type="float")
     */
    private $shoeSize;

    /**
     * @var string
     * @Assert\NotNull()
     *
     * @ORM\Column(name="user_session_id", type="string")
     */
    private $userSessionId;

    /**
     * @var string
     *
     * @Assert\Ip()
     * @ORM\Column(name="ip", type="string")
     */
    private $ip;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_finish_survey", type="boolean")
     */
    private $isFinishSurvey = false;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_on_report", type="boolean")
     */
    private $isOnReport = false;

    /**
     * @ORM\OneToMany(targetEntity="Megogo\CoreBundle\Entity\Answer", mappedBy="user",  cascade={"remove"})
     *
     */
    private $answer;



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
     * Set firstName
     *
     * @param string $firstName
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

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
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

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
     * Set email
     *
     * @param string $email
     * @return User
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
     * Set birthday
     *
     * @param \DateTime $birthday
     * @return User
     */
    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;

        return $this;
    }

    /**
     * Get birthday
     *
     * @return \DateTime 
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * Set shoeSize
     *
     * @param float $shoeSize
     * @return User
     */
    public function setShoeSize($shoeSize)
    {
        $this->shoeSize = $shoeSize;

        return $this;
    }

    /**
     * Get shoeSize
     *
     * @return float 
     */
    public function getShoeSize()
    {
        return $this->shoeSize;
    }

    /**
     * Set userSessionId
     *
     * @param string $userSessionId
     * @return User
     */
    public function setUserSessionId($userSessionId)
    {
        $this->userSessionId = $userSessionId;

        return $this;
    }

    /**
     * Get userSessionId
     *
     * @return string 
     */
    public function getUserSessionId()
    {
        return $this->userSessionId;
    }

    /**
     * Set ip
     *
     * @param string $ip
     * @return User
     */
    public function setIp($ip)
    {
        $this->ip = $ip;

        return $this;
    }

    /**
     * Get ip
     *
     * @return string 
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * Set isFinishSurvey
     *
     * @param boolean $isFinishSurvey
     * @return User
     */
    public function setIsFinishSurvey($isFinishSurvey)
    {
        $this->isFinishSurvey = $isFinishSurvey;

        return $this;
    }

    /**
     * Get isFinishSurvey
     *
     * @return boolean 
     */
    public function getIsFinishSurvey()
    {
        return $this->isFinishSurvey;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->answer = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add answer
     *
     * @param \Megogo\CoreBundle\Entity\Answer $answer
     * @return User
     */
    public function addAnswer(\Megogo\CoreBundle\Entity\Answer $answer)
    {
        $this->answer[] = $answer;

        return $this;
    }

    /**
     * Remove answer
     *
     * @param \Megogo\CoreBundle\Entity\Answer $answer
     */
    public function removeAnswer(\Megogo\CoreBundle\Entity\Answer $answer)
    {
        $this->answer->removeElement($answer);
    }

    /**
     * Get answer
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAnswer()
    {
        return $this->answer;
    }

    /**
     * Set isOnReport
     *
     * @param boolean $isOnReport
     * @return User
     */
    public function setIsOnReport($isOnReport)
    {
        $this->isOnReport = $isOnReport;

        return $this;
    }

    /**
     * Get isOnReport
     *
     * @return boolean 
     */
    public function getIsOnReport()
    {
        return $this->isOnReport;
    }

}
