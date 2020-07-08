<?php

namespace FFX\Codecs;

class Integer extends Text
{
    public function __construct($ffx, $length)
    {
        parent::__construct($ffx, '0123456789', $length);
    }

    public function pack($v)
    {
        return parent::pack(str_pad($v, $this->length, 0, STR_PAD_LEFT));
    }

    public function unpack($v, $t)
    {
        return (int) parent::unpack($v, $t);
    }
}
