<?php
namespace Blog\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="translated")
 *  use repository for handy tree functions
 * @ORM\Entity
 */
class Translated
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue
     */
    private $id;

    public function getId()
    {
        return $this->id;
    }
}
