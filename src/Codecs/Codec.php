<?php

namespace FFX\Codecs;

use FFX\FFX;

abstract class Codec
{
    protected $ffx;

    protected $radix;

    public function __construct($ffx, $radix)
    {
        $this->ffx = new FFX($ffx);
        $this->radix = $radix;
    }

    public function encrypt($v)
    {
        return $this->unpack($this->ffx->encrypt($this->radix, $this->pack($v)), type($v));
    }

    public function decrypt($v)
    {
        return $this->unpack($this->ffx->decrypt($this->radix, $this->pack($v)), type($v));
    }

    public abstract function pack($v);

    public abstract function unpack($v, $t);
}

function type($v)
{
    return $v;
}
