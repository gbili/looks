<?php
namespace Dogtore\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Holds association of a dog and its relted medias.
 * Should be distinguished from the dog media, which
 * is the dog's profile media.
 * @ORM\Entity
 * @ORM\Table(name="dog_media")
 */
class DogMedia
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     *
     * One dog has one user, One user has Many dogs
     * Owner
     *
     * @ORM\ManyToOne(targetEntity="\Dogtore\Entity\Dog")
     */
    private $dog;

    /**
     * Unidirectional - OWNING 
     *
     * One dog has One profilemedia - One porfilemedia has One Dog
     *
     * @ORM\ManyToOne(targetEntity="\GbiliMediaEntityModule\Entity\MediaInterface")
     */
    private $media;

    public function __construct($dog=null, $media=null)
    {
        if ($dog instanceof Dog) {
            $this->setDog($dog);
        }
        if ($media instanceof \GbiliMediaEntityModule\Entity\MediaInterface) {
            $this->setMedia($media);
        }
    }

    public function getId()
    {
        return $this->id;
    }

    public function setDog(\Dogtore\Entity\Dog $dog)
    {
        $this->dog = $dog;
        return $this;
    }

    public function getDog()
    {
        return $this->dog;
    }

    public function hasDog()
    {
        return null !== $this->dog;
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
     * Proxy media
     */
    public function __call($method, $params)
    {
        if (!$this->hasMedia()) {
            throw new \Exception('No media');
        }
        if (!method_exists($this->media, $method)) {
            throw new \Exception('No such method on media');
        }
        return call_user_func_array(array($this->media, $method), $params);
    }
}
