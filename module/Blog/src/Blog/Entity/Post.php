<?php
namespace Blog\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;

/**
 * @Gedmo\Tree(type="nested")
 *  
 * @ORM\Table(name="posts")
 *
 *  use repository for handy tree functions
 * @ORM\Entity(repositoryClass="Blog\Entity\Repository\NestedTreeFlat")
 * @ORM\HasLifecycleCallbacks
 */
class Post implements \GbiliUserModule\IsOwnedByInterface
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Translated", cascade={"persist"})
     */
    private $translated;

    /**
     * @ORM\Column(name="slug", type="string", length=64)
     */
    private $slug;

    /**
     * @var string
     * @Gedmo\Slug(fields={"slug"}, unique=true, unique_base="locale")
     * @ORM\Column(name="uniqueslug", type="string", length=64)
     */
    private $uniqueslug;

    /**
     * @var string
     * @ORM\Column(name="locale", type="string", length=64)
     */
    private $locale;

    /**
     * @ORM\ManyToOne(targetEntity="PostData")
     */
    private $data;

    /**
     * @ORM\ManyToOne(targetEntity="Category")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $category;

    /**
     * @ORM\Column(name="category_slug", type="string", length=64)
     */
    private $categoryslug;

    /**
     * @ORM\ManyToOne(targetEntity="\GbiliUserModule\Entity\UserInterface")
     */
    private $user;

    /**
     * @Gedmo\TreeLeft
     * @ORM\Column(name="lft", type="integer")
     */
    private $lft;

    /**
     * @Gedmo\TreeLevel
     * @ORM\Column(name="lvl", type="integer")
     */
    private $lvl;

    /**
     * @Gedmo\TreeRight
     * @ORM\Column(name="rgt", type="integer")
     */
    private $rgt;

    /**
     * @Gedmo\TreeRoot
     * @ORM\Column(name="root", type="integer", nullable=true)
     */
    private $root;

    /**
     * @Gedmo\TreeParent
     * @ORM\ManyToOne(targetEntity="Post", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity="Post", mappedBy="parent")
     * @ORM\OrderBy({"lft" = "ASC"})
     */
    private $children;

    public function __construct()
    {
        $this->children = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function hasId()
    {
        return null !== $this->id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function isOwnedBy(\GbiliUserModule\Entity\UserInterface $user)
    {
        return $this->user->getUser() === $user;
    }

    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    public function getSlug()
    {
        return $this->slug;
    }

    public function setUniqueslug($uniqueslug)
    {
        $this->uniqueslug = $uniqueslug;
    }

    public function getUniqueslug()
    {
        return $this->uniqueslug;
    }

    public function setData(PostData $postData=null)
    {
        $this->data = $postData;
        return $this;
    }

    public function getData()
    {
        if (null === $this->data) {
            return new PostData();
        }
        return $this->data;
    }

    /**
     * Proxy for post data
     */
    public function __call($method, $params)
    {
        if (!method_exists($this->getData(), $method)) {
            throw new \Exception('Call to undefined method: ' . $method);
        }
        return ((!empty($params))? $this->getData()->$method(current($params)) : $this->getData()->$method());
    }

    public function setCategoryslug($slug)
    {
        $this->categoryslug = $slug;
    }

    public function getCategoryslug()
    {
        return $this->categoryslug;
    }

    public function setCategory($category)
    {
        $this->category = $category;
        return $this;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function setParent(Post $parent = null)
    {
        $this->parent = $parent;    
    }

    public function hasParent()
    {
        return null !== $this->parent;
    }

    public function getParent()
    {
        return $this->parent;   
    }

    public function unsetParent()
    {
        if (!$this->hasParent()) {
            return;
        }
        $this->parent->getChildren()->removeElement($this);
        $this->parent = null;
    }

    public function setRoot(Post $root = null)
    {
        return $this->root;
    }

    public function getRoot()
    {
        return $this->root;
    }

    public function getChildren()
    {
        return $this->children;
    }

    public function hasChildren()
    {
        return !$this->children->isEmpty();
    }

    public function addChild(Post $child)
    {
        $this->reuseLocales($this, $child);
        $child->setParent($this);
        $this->children->add($child);
    }

    public function addChildren(\Doctrine\Common\Collections\Collection $children)
    {
        foreach ($children as $child) {
            $this->addChild($child);
        }
    }

    public function removeChild(Post $child)
    {
        $child->setParent(null);
        $this->children->removeElement($child);
    }

    public function removeChildren(\Doctrine\Common\Collections\Collection $children)
    {
        foreach ($children as $child) {
            $this->removeChild($child);
        }
    }

    public function removeAllChildren()
    {
        foreach ($this->children as $child) {
            $this->removeChild($child);
        }
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

    public function reuseLocales($one, $other)
    {
        if (!$one->hasLocale() && !$other->hasLocale()) {
            return;
        }
        if ($one->hasLocale() && $other->hasLocale()) {
            if ($one->getLocale() !== $other->getLocale()) {
                throw new \Exception('Post locale and post data locale cannot be different');
            }
            return;
        }
        if ($one->hasLocale()) {
            $other->setLocale($one->getLocale());
        } else {
            $one->setLocale($other->getLocale());
        }
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

    /**
     * @ORM\PreRemove
     */
    public function untideDependencies()
    {
        $this->unsetParent();
        $this->removeAllChildren();
    }
}
