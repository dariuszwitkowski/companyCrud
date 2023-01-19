<?php

namespace App\Shared\Exception;

use JetBrains\PhpStorm\Pure;
use Symfony\Component\HttpFoundation\Response;

class EntityAlreadyExistsException extends \Exception
{
    #[Pure] public function __construct(string $name)
    {
        parent::__construct("${name} already exists");
    }
}