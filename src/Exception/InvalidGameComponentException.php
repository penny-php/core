<?php

namespace PennyPHP\Core\Exception;

use Exception;

class InvalidGameComponentException extends Exception
{
    public $message = 'The provided component is not a valid GameComponent instance.';
}