<?php

namespace App\Shared\Exception;

use JetBrains\PhpStorm\Pure;
use Symfony\Component\HttpFoundation\Response;

class EntityDoesNotExistException extends \Exception
{
    #[Pure] public function __construct(string $name, int $id)
    {
        parent::__construct("${name} id: ${id} does not exist");
    }
}