<?php

namespace PennyPHP\Core\Doctrine\Listener;

use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Events;
use Doctrine\ORM\Query\Expr\Join;
use PennyPHP\Core\Entity\GameComponent;
use PennyPHP\Core\Entity\GameObject;

#[AsEntityListener(event: Events::postLoad, method: 'postLoadGameObject', entity: GameObject::class)]
#[AsEntityListener(event: Events::prePersist, method: 'prePersistGameObject', entity: GameObject::class)]
#[AsEntityListener(event: Events::preUpdate, method: 'preUpdateGameObject', entity: GameObject::class)]
#[AsEntityListener(event: Events::preRemove, method: 'preRemoveGameObject', entity: GameObject::class)]
readonly class GameObjectComponentListener
{
    private array $componentClasses;
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
        $components = [];
        foreach ($this->entityManager->getMetadataFactory()->getAllMetadata() as $metadata) {
            if ($metadata->getReflectionClass()->isSubclassOf(GameComponent::class)) {
                $components[] = $metadata->getReflectionClass()->getName();
            }
        }
        $this->componentClasses = $components;
    }

    public function postLoadGameObject(GameObject $object): void
    {
        foreach ($this->getComponents($object) as $component) {
            $object->setComponent($component);
        }
    }

    public function prePersistGameObject(GameObject $object): void
    {
        foreach ($object->getComponents() as $component) {
            $this->entityManager->persist($component);
        }
    }

    public function preUpdateGameObject(GameObject $object): void
    {
        foreach ($object->getComponents() as $component) {
            $this->entityManager->persist($component);
        }
    }

    public function preRemoveGameObject(GameObject $object): void
    {
        foreach ($this->getComponents($object) as $component) {
            $this->entityManager->remove($component);
        }
    }

    private function getComponents(GameObject $gameObject): array
    {
        $qb = $this->entityManager->createQueryBuilder()
            ->select('gameObject')
            ->from(GameObject::class, 'gameObject')
            ->where('gameObject = :gameObject')
            ->setParameter('gameObject', $gameObject)
        ;
        foreach ($this->componentClasses as $componentClass) {
            $alias = str_replace("\\", "", $componentClass);
            $qb
                ->addSelect($alias)
                ->leftJoin($componentClass, $alias, Join::ON ,"gameObject.id = $alias.gameObject")
            ;
        }
        $result = $qb->getQuery()->getResult();

        $components = [];
        foreach ($result as $component) {
            if ($component instanceof GameComponent) {
                $components[] = $component;

            }
        }
        return $components;
    }
}