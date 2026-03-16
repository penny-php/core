<?php

namespace PennyPHP\Core\Doctrine\Type;

use PennyPHP\Core\GameObjectInterface;
use PennyPHP\Core\GameObjectTrait;
use Symfony\Component\DependencyInjection\Attribute\When;

#[When(env: 'never')]
class GameObjectPlaceholder implements GameObjectInterface
{
    use GameObjectTrait {
        GameObjectTrait::__construct as parentConstruct;
    }

    public function __construct(string $id)
    {
        $this->parentConstruct($id, []);
    }
}