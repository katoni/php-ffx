<?php

namespace FFX\Codecs;

class Text extends Sequence
{
    public function unpack($v, $t)
    {
        return implode('', parent::unpack($v, $t));
    }
}
