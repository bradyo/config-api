<?php
namespace Api\Common;

class Hash
{
    private $value;

    public function __construct()
    {
        $s = base_convert(openssl_random_pseudo_bytes(512), 16, 36);
        $this->value = strtoupper(substr($s, 0, 10));
    }

    public function __toString()
    {
        return $this->value;
    }
}