<?php

namespace PennyPHP\Core;

use PennyPHP\Core\Entity\GameComponent;
use PennyPHP\Core\Exception\InvalidGameComponentException;
use ReflectionClass;

trait GameObjectTrait
{
    /** @varGameComponent[] */
    protected array $components;

    /**
     * @throws InvalidGameComponentException
     */
    public function __construct(
        protected string $id,
        array $components = [],
    )
    {
        foreach ($components as $component) {
            if (!$component instanceof GameComponent) {
                throw new InvalidGameComponentException(print_r($component, true) . " is not an instance of " . GameComponent::class);
            }
        }

        $components = array_merge($components, $this->getGameComponentFromAttributes());

        foreach ($components as $component) {
            $this->setComponent($component);
        }
    }

    public function getId(): string
    {
        return $this->id;
    }

    /** @returnGameComponent[] */
    public function getComponents(): array
    {
        return $this->components;
    }

    public function setComponent(GameComponent $component, ?string $componentId = null): self
    {
        $this->components[$componentId ?? $component::getComponentName()] = $component;
        $component->setGameObject($this);
        return $this;
    }

    /**
     * @template T of GameComponent
     * @param class-string<T> $componentClass
     */
    public function removeComponent(string $componentClass): void
    {
        unset($this->components[$componentClass::getComponentName()]);
    }

    /**
     * @template T of GameComponent
     * @param class-string<T> $componentClass
     */
    public function hasComponent(string $componentClass): bool
    {
        return $this->getComponent($componentClass) !== null;
    }

    /**
     * @template T of GameComponent
     * @param class-string<T> $componentClass
     * @return T|null
     */
    public function getComponent(string $componentClass): ?GameComponent
    {
        if ($component = $this->components[$componentClass::getComponentName()] ?? null) {
            return $component;
        }

        foreach ($this->components as $component) {
            if ($component::getComponentName() === $componentClass::getComponentName()) {
                return $component;
            }
        }

        return null;
    }

    public  function __toString(): string
    {
        return $this::class . '::' . $this->getId();
    }

    private function getGameComponentFromAttributes(): array
    {
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
    }
}