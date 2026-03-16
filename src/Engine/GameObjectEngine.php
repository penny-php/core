<?php

namespace PennyPHP\Core\Engine;

use PennyPHP\Core\AbstractGameObjectPrototype;
use PennyPHP\Core\Entity\GameObject;
use PennyPHP\Core\Exception\GameObjectNotFound;
use PennyPHP\Core\GameObjectInterface;
use PennyPHP\Core\GameObjectPrototypeInterface;
use PennyPHP\Core\InMemoryGameObjectInterface;
use PennyPHP\Core\Repository\GameObjectRepository;
use Symfony\Component\DependencyInjection\Attribute\AutowireIterator;

readonly class GameObjectEngine
{
    private array $gameObjectPrototypes;
    private array $inMemoryGameObjects;

    /**
     * @param iterable<GameObjectPrototypeInterface> $gameObjectPrototypeIterator
     * @param iterable<InMemoryGameObjectInterface> $inMemoryGameObjectIterator
     */
    public function __construct(
        #[AutowireIterator('game.object.prototype')]
        iterable             $gameObjectPrototypeIterator,
        #[AutowireIterator('game.object.in_memory')]
        iterable             $inMemoryGameObjectIterator,
        private GameObjectRepository $gameObjectRepository,
    )
    {
        $gameObjectPrototypes = [];
        foreach ($gameObjectPrototypeIterator as $gameObjectPrototype) {
            $gameObjectPrototypes[$gameObjectPrototype::getType()] = $gameObjectPrototype;
        }
        $this->gameObjectPrototypes = $gameObjectPrototypes;

        $inMemoryGameObjects = [];
        foreach ($inMemoryGameObjectIterator as $gameObject) {
            $inMemoryGameObjects[$gameObject->getId()] = $gameObject;
        }
        $this->inMemoryGameObjects = $inMemoryGameObjects;
    }

    public function get(string $id): GameObjectInterface
    {
        return $this->inMemoryGameObjects[$id]
            ?? $this->gameObjectRepository->find($id)
            ?? throw new GameObjectNotFound('Game object id "'. $id .'" not found')
        ;
    }

    public function getPrototype(string $type): GameObjectPrototypeInterface
    {
        return $this->gameObjectPrototypes[$type] ?? throw new GameObjectNotFound('Game object prototype for class "'.$type.'" not found');

    }

    public function make(string $type): GameObject
    {
        if (is_subclass_of($type, AbstractGameObjectPrototype::class)) {
            $type = $type::getType();
        }

        $prototype = $this->getPrototype($type);
        return $prototype->make();
    }
}