<?php
namespace App\Exceptions;

use Exception;
use Illuminate\Support\MessageBag;

class InvalidModelException extends Exception
{
    /**
     * @var MessageBag
     */
    private $errors;

    function __construct(MessageBag $errors)
    {
        $this->errors = $errors;
    }

    public function getErrors()
    {
        return $this->errors;
    }
}
 