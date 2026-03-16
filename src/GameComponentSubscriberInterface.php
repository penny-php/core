<?php

namespace PennyPHP\Core;

interface GameComponentSubscriberInterface
{
    public function getSubscribedComponents(): array;
}