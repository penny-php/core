<?php

namespace PennyPHP\Core\Event;

use PennyPHP\Core\GameObjectInterface;

readonly class GameObjectNewEvent
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