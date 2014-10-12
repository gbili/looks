<?php
namespace Blog\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="post_datas")
 */
class PostData
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @ORM\Column(name="locale", type="string", length=64)
     */
    private $locale;

    /**
     * @ORM\Column(name="title", type="string", length=64)
     */
    private $title;

    /**
     * @ORM\ManyToOne(targetEntity="Translated", cascade={"persist"})
     */
    private $translated;

    /**
     * @ORM\ManyToOne(targetEntity="\GbiliMediaEntityModule\Entity\MediaInterface")
     */
    private $media;

    /**
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=false)
     */
    private $date;

    public function getId()
    {
        return $this->id;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function getContent()
    {
        return $this->content;
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
    public function setDate(\DateTime $time)
    {
        $this->date = $time;
    }

    /**
    * Get Created Date
    *
    * @return \DateTime
    */
    public function getDate()
    {
        return $this->date;
    }

    public function setTranslated(Translated $translated = null)
    {
        $this->translated = $translated;    
    }

    public function getTranslated()
    {
        return $this->translated;
    }

    public function hasTranslated()
    {
        return null !== $this->translated;
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
