<?php

namespace PennyPHP\Core\Engine;

use App\Repository\Data\PlayerCharacterRepository;
use PennyPHP\Core\GameObjectInterface;
use PennyPHP\Core\Repository\GameObjectRepository;

readonly class TokenEngine
{
    public function __construct(
        private GameObjectRepository      $gameObjectRepository,
        private PlayerCharacterRepository $playerCharacterRepository,
    ) {
    }

    public function exchange(string $token): GameObjectInterface
    {
        if($gameObject = $this->gameObjectRepository->find($token)) {
            return $gameObject;
        }

        return $this->playerCharacterRepository->find($token);
    }
}