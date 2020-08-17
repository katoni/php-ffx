<?php

namespace Katoni\FFX\Codecs;

use Katoni\FFX\FFX;

abstract class Codec
{
    protected FFX $ffx;

    protected int $radix;

    public function __construct(string $ffx, int $radix)
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
