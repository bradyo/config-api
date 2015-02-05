<?php
namespace Api\Common;

use DateTime;

class Date
{
    private $value;

    public function __construct($value = 'now')
    {
        $this->value = (new DateTime($value))->format('Y-m-d');
    }

    public function __toString()
    {
        return $this->value;
    }
}