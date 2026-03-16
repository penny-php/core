<?php

namespace PennyPHP\Core\Entity;

use Doctrine\ORM\Mapping as ORM;
use PennyPHP\Core\Exception\InvalidGameComponentException;
use PennyPHP\Core\GameObjectInterface;
use PennyPHP\Core\GameObjectPrototypeInterface;
use PennyPHP\Core\GameObjectTrait;
use PennyPHP\Core\Repository\GameObjectRepository;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: GameObjectRepository::class)]
#[ORM\Table(name: "core_game_object")]
class GameObject implements GameObjectInterface
{
    use GameObjectTrait {
        GameObjectTrait::__construct as _gameObjectConstruct;
    }

    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'NONE')]
    #[ORM\Column(type: 'guid')]
    protected string $id;

    #[ORM\Column(name: 'type', type: 'string')]
    private string $prototype;

    /**
     * @param GameComponent[] $components
     * @throws InvalidGameComponentException
     */
    public function __construct(GameObjectPrototypeInterface|string $prototype, array $components)
    {
        if ($prototype instanceof GameObjectPrototypeInterface) {
            $prototype = $prototype->getType();
        }
        $this->prototype = $prototype;
        self::_gameObjectConstruct(Uuid::v7(), $components);
    }

    public function getPrototype(): string
    {
        return $this->prototype;
    }

    public function isInstanceOf(GameObject|GameObjectPrototypeInterface|string $object): bool
    {
        if (is_subclass_of($object, GameObjectPrototypeInterface::class)) {
            $type = $object::getType();
        } elseif (is_string($object)) {
            $type = $object;
        } else {
            $type = $object->getPrototype();
        }

        return $this->getPrototype() === $type;
    }

    public function clone(): GameObject
    {
        return new $this($this->getPrototype(), $this->cloneComponents());
    }

    /** @returnGameComponent[] */
    private function cloneComponents(): array
    {
        return array_map(function (GameComponent $component) {
            return clone $component;
        }, $this->components);
    }
}
