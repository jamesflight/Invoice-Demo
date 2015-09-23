<?php
namespace App\Exceptions;

use Illuminate\Support\MessageBag;

class InvalidModelException extends \Exception
{
    /**
     * @var MessageBag
     */
    private $errors;

    public function __construct(MessageBag $errors)
    {
        $this->errors = $errors;
    }

    public function getErrors()
    {
        return $this->errors;
    }
}
 