<?php

namespace App\Shared\Exception;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class InvalidFormException extends \Exception
{
    public function __construct(FormInterface $form)
    {
        parent::__construct($form->getErrors(true)->current()->getMessage());
    }
}