<?php

namespace AclBundle\Entity;


use Symfony\Component\Validator\Constraints as Assert;
use FOS\UserBundle\Model\User as BaseUser;
use FOS\MessageBundle\Model\ParticipantInterface;
use Doctrine\ORM\Mapping as ORM;


/**
 * User
 *
 * @ORM\Table(name="ab_user")
 * @ORM\Entity(repositoryClass="AclBundle\Repository\UserRepository")
 */
class User extends BaseUser implements ParticipantInterface
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="cin", type="string", length=255, unique=true)
     */
    private $cin;

    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", length=255)
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=255)
     */
    private $lastname;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="birthdate", type="date")
     */
    private $birthdate;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=255)
     */
    private $phone;

    /**
     * @ORM\OneToOne(targetEntity="AclBundle\Entity\image", cascade={"remove", "persist"})
     */
    private $photo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateSubscribe", type="date", length=255)
     */
    private $dateInscription;



    public function __construct()
    {
        parent::__construct();
        $this->dateInscription = new \DateTime('NOW');
        $this->setRoles(array('ROLE_MEMBER'));
        $this->photo= new image();
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
     * Set cin
     *
     * @param string $cin
     *
     * @return User
     */
    public function setCin($cin)
    {
        $this->cin = $cin;

        return $this;
    }

    /**
     * Get cin
     *
     * @return string
     */
    public function getCin()
    {
        return $this->cin;
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     *
     * @return User
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     *
     * @return User
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set birthdate
     *
     * @param \DateTime $birthdate
     *
     * @return User
     */
    public function setBirthdate($birthdate)
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    /**
     * Get birthdate
     *
     * @return \DateTime
     */
    public function getBirthdate()
    {
        return $this->birthdate;
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
     * @return \DateTime
     */
    public function getDateInscription()
    {
        return $this->dateInscription;
    }

    /**
     * @param \DateTime $dateInscription
     */
    public function setDateInscription($dateInscription)
    {
        $this->dateInscription = $dateInscription;
    }

    /**
     * @return \AclBundle\Entity\image
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * @param \AclBundle\Entity\image $photo
     * @return User
     */
    public function setPhoto(image $photo=null)
    {
        $this->photo = $photo;
    }

    public function getAvatar() {
        return $this->photo->getWebPath();
    }

    public function fullName()
    {
        return $this->lastname." ".$this->firstname;
    }

    /*public function birthday_day()
    {
        $message = 'It\'s your birthday !';
        if ($this->birthdate == new \DateTime('NOW'))
            return $message;
        dump($message);
        die;
        else {
        return false;
    }
    }*/


}
