<?php
namespace Api\Common;

use DateTime;

class Time
{
    private $value;

    public function __construct($value = 'now')
    {
        $this->value = (new DateTime($value))->format(DateTime::ISO8601);
    }

    public function __toString()
    {
        return $this->value;
    }
}