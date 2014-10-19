<?php
namespace Blog\HydratorStrategy;

use Zend\Stdlib\Hydrator\Strategy\StrategyInterface;

class PostParentStrategy implements StrategyInterface
{
    public function extract($value)
    {
        if (is_numeric($value) || $value === null) {
            return $value;
        }

        return $value->getId();
    }

    public function hydrate($value)
    {
        return ($value === '')? null : (integer) $value;
    }
}


