<?php
/**
 * Created by PhpStorm.
 * User: mathewsdivala
 * Date: 2019-03-11
 * Time: 14:36
 */

namespace App\Models\User;


use Throwable;

class UsernameConflictException extends \Exception
{

    public function __construct(string $message = "", int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->message = "an account with the username already exists";
    }
}