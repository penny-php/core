<?php

namespace PennyPHP\Core\GameObject\Event;

use PennyPHP\Core\GameObject\GameObjectInterface;

readonly class GameObjectRemoveEvent
{
    public function __construct(
        private GameObjectInterface $gameObject,
    ){

    }

    public function getGameObject(): GameObjectInterface
    {
        return $this->gameObject;
    }
}