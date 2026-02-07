<?php

namespace PennyPHP\Core\GameObject\Doctrine\Listener;

use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;
use PennyPHP\Core\GameObject\Entity\GameObject;
use PennyPHP\Core\GameObject\Event\GameObjectNewEvent;
use PennyPHP\Core\GameObject\Event\GameObjectRemoveEvent;
use PennyPHP\Core\GameObject\Event\GameObjectUpdateEvent;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

#[AsEntityListener(event: Events::postPersist, entity: GameObject::class)]
#[AsEntityListener(event: Events::postUpdate, entity: GameObject::class)]
#[AsEntityListener(event: Events::postRemove, entity: GameObject::class)]
readonly class GameObjectListener
{
    public function __construct(
        private EventDispatcherInterface $eventDispatcher,
    )
    {
    }

    public function postPersist(GameObject $gameObject): void
    {
        $this->eventDispatcher->dispatch(new GameObjectNewEvent($gameObject));
    }

    public function postUpdate(GameObject $gameObject): void
    {
        $this->eventDispatcher->dispatch(new GameObjectUpdateEvent($gameObject));
    }

    public function postRemove(GameObject $gameObject): void
    {
        $this->eventDispatcher->dispatch(new GameObjectRemoveEvent($gameObject));
    }
}