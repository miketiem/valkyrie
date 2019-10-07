<?php

namespace MikeTiEm\Valkyrie\Exceptions;

class HasRelationshipException extends \Exception
{
    protected $message = 'This transaction was apparently used in a later process and can not be deleted.';

    protected $code = 302;

    public function __construct()
    {
        parent::__construct($this->message, $this->code, null);
    }
}