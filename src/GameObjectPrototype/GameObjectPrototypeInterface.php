<?php

namespace PennyPHP\Core\GameObjectPrototype;

use PennyPHP\Core\GameObject\Entity\GameObject;
use PennyPHP\Core\GameObject\GameObjectInterface;

interface GameObjectPrototypeInterface extends GameObjectInterface
{
    public function make(): GameObject;

    public static function getType(): string;
}