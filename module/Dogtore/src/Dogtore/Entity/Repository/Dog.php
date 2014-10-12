<?php
namespace Dogtore\Entity\Repository;

class Dog extends \Doctrine\ORM\EntityRepository
{
    public function existsUserDogName(\GbiliUserModule\Entity\UserInterface $user, $dogname)
    {
        $userDogsWithName = $this->findBy(array('user' => $user, 'name' => $dogname));
        $exists = !empty($userDogsWithName);
        return $exists;
    }
}
