<?php

namespace PennyPHP\Core\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use PennyPHP\Core\Entity\GameObject;

/**
 * @extends ServiceEntityRepository<GameObject>
 */
class GameObjectRepository extends ServiceEntityRepository
{
    use SaveEntityTrait;
    use RemoveEntityTrait;
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GameObject::class);
    }
}
