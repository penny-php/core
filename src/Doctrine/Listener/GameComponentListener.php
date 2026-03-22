<?php

namespace PennyPHP\Core\Doctrine\Listener;

use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;
use PennyPHP\Core\Entity\GameComponent;
use PennyPHP\Core\Event\GameObjectUpdateEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;


#[AsEntityListener(event: Events::postPersist, entity: GameComponent::class)]
#[AsEntityListener(event: Events::postUpdate, entity: GameComponent::class)]
#[AsEntityListener(event: Events::postRemove, entity: GameComponent::class)]
readonly class GameComponentListener
{

    public function __construct(
        private EventDispatcherInterface $eventDispatcher,
    )
    {
    }

    public function __invoke(GameComponent $component): void
    {
        $this->eventDispatcher->dispatch(new GameObjectUpdateEvent($component->getGameObject()));
    }
}