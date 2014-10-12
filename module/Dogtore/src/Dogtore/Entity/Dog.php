<?php
namespace Dogtore\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="dogs")
 * @ORM\Entity(repositoryClass="Dogtore\Entity\Repository\Dog")
 */
class Dog
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @ORM\Column(name="locale", type="string", length=6)
     */
    private $locale;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=64, nullable=false, unique=false)
     */
    private $name;

    /**
     * Bidirectional - OWNING
     *
     * One dog has one user, One user has Many dogs
     * Owner
     *
     * @ORM\ManyToOne(targetEntity="\GbiliUserModule\Entity\UserInterface")
     */
    private $user;

    /**
     * @var string
     *
     * @ORM\Column(name="breed", type="string", length=64, nullable=true, unique=false)
     */
    private $breed;

    /**
     * #FFDD33 -> FFDD33
     * Hex color without #
     * @var string
     *
     * @ORM\Column(name="color", type="string", length=6, nullable=true, unique=false)
     */
    private $color;

    /**
     * m    | f
     * Male | Female
     * @var string
     *
     * @ORM\Column(name="gender", type="string", length=1, nullable=true, unique=false)
     */
    private $gender;

    /**
     * @var float 
     *
     * @ORM\Column(name="weightkg", type="float", length=64, nullable=true, unique=false)
     */
    private $weightkg;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="birthdate", type="datetime", nullable=true)
     */
    private $birthdate;

    /**
     * The media that should be displayed in the dog's profile
     *
     * One dog has One media - One media can have many Dog
     *
     * @ORM\ManyToOne(targetEntity="\GbiliMediaEntityModule\Entity\MediaInterface")
     */
    private $media;

    /**
     * Tell us why you chose this dog. Is it because of the breed?
     * On the contrary, is it because of a crazy story? Tell us more.
     *
     * @ORM\Column(name="whythisdog", type="text", nullable=true)
     */
    private $whythisdog;

    /**
     *
     */
    public function __construct()
    {
    }

    public function getId()
    {
        return $this->id;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setUser(\GbiliUserModule\Entity\UserInterface $user)
    {
        $this->user = $user;
        return $this;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function hasUser()
    {
        return null !== $this->user;
    }

    public function setWhythisdog($whythisdog = null)
    {
        $this->whythisdog = $whythisdog;
        return $this;
    }

    public function getWhythisdog()
    {
        return $this->whythisdog;
    }

    public function setBreed($breed = null)
    {
        $this->breed = $breed;
        return $this;
    }

    public function getBreed()
    {
        return $this->breed;
    }

    public function setColor($color = null)
    {
        $this->color = $color;
        return $this;
    }

    public function getColor()
    {
        return $this->color;
    }

    public function setGender($gender = null)
    {
        $this->gender = $gender;
        return $this;
    }

    public function getGender()
    {
        return $this->gender;
    }

    public function setWeightkg($weightkg = null)
    {
        $this->weightkg = $weightkg;
        return $this;
    }

    public function getWeightkg()
    {
        return $this->weightkg;
    }

    public function getMedia()
    {
        return $this->media;
    }

    public function hasMedia()
    {
        return null !== $this->media;
    }

    public function setMedia(\GbiliMediaEntityModule\Entity\MediaInterface $media = null)
    {
        $this->media = $media;
        return $this;
    }

    /**
     * @ORM\PrePersist
     */
    public function setBirthdate(\DateTime $time)
    {
        $this->birthdate = $time;
    }

    /**
     * Get Created Date
     * @return \DateTime
     */
    public function getBirthdate()
    {
        return $this->birthdate;
    }

    public function setLocale($locale)
    {
        $this->locale = $locale;
    }

    public function hasLocale()
    {
        return null !== $this->locale;
    }

    public function getLocale()
    {
        return $this->locale;
    }
}
