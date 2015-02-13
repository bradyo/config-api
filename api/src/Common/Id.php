<?php
namespace Api\Common;

class Id
{
    private $value;

    public function __construct()
    {
        $this->value = substr(md5(uniqid('uuid', true)), 0, 10);
    }

    public function __toString()
    {
        return $this->value;
    }
}