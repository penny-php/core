<?php

namespace PennyPHP\Core\Entity;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\MappedSuperclass;
use Doctrine\ORM\Mapping\OneToOne;
use PennyPHP\Core\GameComponentInterface;
use PennyPHP\Core\GameObjectInterface;
use Symfony\Component\Uid\Uuid;

#[MappedSuperclass]
abstract class GameComponent implements GameComponentInterface
{
    #[Id]
    #[Column(type: 'guid', nullable: false)]
    protected readonly string $id;

    public function __construct(
        #[OneToOne(targetEntity: GameObject::class)]
        #[JoinColumn(onDelete: "CASCADE")]
        protected ?GameObjectInterface $gameObject = null
    )
    {
        $this->id = Uuid::v7();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getGameObject(): ?GameObjectInterface
    {
        return $this->gameObject;
    }

    public function setGameObject(GameObjectInterface $gameObject): void
    {
        $this->gameObject = $gameObject;
    }

    public static function getComponentName(): string
    {
        return static::class;
    }
}