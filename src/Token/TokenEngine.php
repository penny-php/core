<?php

namespace PennyPHP\Core\Token;

use App\Repository\Data\PlayerCharacterRepository;
use PennyPHP\Core\GameObject\GameObjectInterface;
use PennyPHP\Core\GameObject\Repository\GameObjectRepository;

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