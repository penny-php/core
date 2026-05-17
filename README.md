# PennyPHP Core Bundle

The PennyPHP Core Bundle provides a robust implementation of the Entity-Component-System (ECS) pattern within a Symfony environment, designed for developing browser-based games.

## Features

- **Entity-Component-System (ECS):** A powerful architectural pattern for game development that promotes modularity, flexibility, and performance.
- **GameObject:** The fundamental building block of your game world, representing any interactive or visible element.
- **Components:** Data-only classes that define the properties and characteristics of a GameObject.
- **Services:** Logic-only classes that operate on GameObjects and their Components.
- **Doctrine Integration:** Seamless integration with Doctrine ORM for persisting GameObjects and their Components.
- **Dependency Injection:** Leverages Symfony's Dependency Injection Container for managing and injecting game-related services.

## Installation (with Symfony flex)
```
composer require penny-php/core
```

Then, enable the bundle by adding it to the `config/bundles.php` file:

```php
<?php

return [
    // ...
    PennyPHP\Core\CoreBundle::class => ['all' => true],
    // ...
];
```


## Usage

### GameObjects

A `GameObject` is a generic entity that can have various `Components` attached to it.

```php
<?php

namespace App\Entity\Data;

use PennyPHP\Core\Entity\GameObject;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Player extends GameObject
{
    // Your specific player properties and methods
}
```

### Components

Components are plain PHP objects that hold data. They are attached to `GameObjects` to define their characteristics.

```php
<?php

namespace App\GameElement\Character\Component;

use PennyPHP\Core\Component\AbstractComponent;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class CharacterComponent extends AbstractComponent
{
    #[ORM\Column(type: 'integer')]
    public int $health = 100;

    #[ORM\Column(type: 'integer')]
    public int $maxHealth = 100;

    #[ORM\Column(type: 'integer')]
    public int $attack = 10;

    #[ORM\Column(type: 'integer')]
    public int $defense = 10;
}
```
