<?php

namespace PennyPHP\Core\Exception;

use Exception;
use JetBrains\PhpStorm\Pure;
use PennyPHP\Core\GameObjectInterface;
use Throwable;

class GameComponentRequiredException extends Exception
{
    #[Pure]
    public function __construct(string $class, GameObjectInterface $gameObject, ?Throwable $previous = null)
    {
        parent::__construct(sprintf("%s required for object %s", $class, $gameObject->getId()), 0, $previous);
    }
}