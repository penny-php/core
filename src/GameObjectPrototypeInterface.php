<?php

namespace PennyPHP\Core;

use PennyPHP\Core\Entity\GameObject;

interface GameObjectPrototypeInterface
{
    public function make(): GameObject;

    public static function getType(): string;
    public function getComponents();
}