<?php

namespace PennyPHP\Core;

use PennyPHP\Core\Entity\GameComponent;
use Stringable;

interface GameObjectInterface extends Stringable
{
    public function getId(): string;

    /** @return GameComponent[] */
    public function getComponents(): array;

    public function setComponent(GameComponent $component);

    /**
     * @template T of GameComponent
     * @param class-string<T> $componentClass
     */
    public function removeComponent(string $componentClass): void;

    public function hasComponent(string $componentClass): bool;

    /**
     * @template T of GameComponent
     * @param class-string<T> $componentClass
     * @return T|null
     */
    public function getComponent(string $componentClass): ?GameComponent;

    public function __toString(): string;
}