<?php

namespace LdapRecord\Laravel\Events\Auth;

use LdapRecord\Laravel\Events\Loggable;
use LdapRecord\Laravel\Events\LoggableEvent;

class Bound extends Event implements LoggableEvent
{
    use Loggable;

    /**
     * @inheritdoc
     */
    public function getLogMessage()
    {
        return "User [{$this->object->getName()}] has successfully passed LDAP authentication.";
    }
}
