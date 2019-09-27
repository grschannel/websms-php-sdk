<?php

namespace Websms\Exceptions;

use Exception;

class CouldNotSendNotification extends Exception
{
    /**
     * Thrown when there is credential error
     *
     * @return static
     */
    public static function credentialError()
    {
        return new static('Username or Password is incurrect.');
    }

    /**
     * Thrown when there is credit error
     *
     * @return static
     */
    public static function creditError()
    {
        return new static('Your Credit is not enough.');
    }
}
