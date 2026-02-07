<?php

namespace PennyPHP\Core\GameComponent;

interface GameComponentSubscriberInterface
{
    public function getSubscribedComponents(): array;
}