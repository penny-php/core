<?php

namespace PennyPHP\Core;

use PennyPHP\Core\Entity\GameComponent;
use PennyPHP\Core\Entity\GameObject;
use PennyPHP\Core\Exception\InvalidGameComponentException;
use ReflectionClass;
use Symfony\Contracts\Cache\CacheInterface;

abstract class AbstractGameObjectPrototype implements GameObjectPrototypeInterface
{

    public function __construct(
        private readonly CacheInterface $gameObjectCache
    )
    {
    }

    /**
     * @throws InvalidGameComponentException
     */
    public function make(): GameObject
    {
        return new GameObject($this->getType(), $this->getGameComponentFromAttributes());
    }

    private function getGameComponentFromAttributes(): array
    {
        return $this->gameObjectCache->get(str_replace("\\", "_", $this::class) . '_components', function () {
            $components = [];
            $reflection = new ReflectionClass($this);
            foreach ($reflection->getAttributes() as $attribute) {
                $name = $attribute->getName();
                if (is_subclass_of($name, GameComponent::class)) {

                    /** @var GameComponent $component */
                    $component = $attribute->newInstance();
                    $components[$name::getComponentName()] = $component;
                }
            }
            return $components;
        });
    }

    public static function getType(): string
    {
        $explodedClass = explode("\\", static::class);
        return array_pop($explodedClass);
    }

    public function getComponents(): array
    {
        return $this->getGameComponentFromAttributes();
    }

    /**
     * @template T of GameComponent
     * @param class-string<T> $componentClass
     * @return GameComponent|null
     */
    public function getComponent(string $componentClass): ?GameComponent
    {
        if ($component = $this->getComponents()[$componentClass::getComponentName()] ?? null) {
            return $component;
        }

        foreach ($this->getComponents() as $component) {
            if ($component::getComponentName() === $componentClass::getComponentName()) {
                return $component;
            }
        }

        return null;
    }
}