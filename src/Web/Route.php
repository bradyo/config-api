<?php
namespace Api\Web;

class Route extends \Commando\Web\Route
{
    public function __construct($method, $path, $value)
    {
        parent::__construct(null, $method, $path, $value);
    }

}