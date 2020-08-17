<?php

namespace Katoni\FFX\Codecs;

use InvalidArgumentException;
use Katoni\FFX\FFX;

class Sequence extends Codec
{
    protected string $alphabet;

    protected $pack_map;

    protected int $length;

    public function __construct(string $ffx, string $alphabet, int $length)
    {
        $this->alphabet = $alphabet;
        $this->pack_map = array_flip(str_split($alphabet));
        $this->length = $length;

        parent::__construct($ffx, strlen($alphabet));
    }

    public function pack($v)
    {
        if (strlen($v) !== $this->length) {
            throw new InvalidArgumentException(sprintf('Sequence length must be %s', $this->length));
        }

        $result = [];

        foreach (str_split($v) as $c) {
            if (!array_key_exists($c, $this->pack_map)) {
                throw new InvalidArgumentException(sprintf('Non-alphabet character: %s', $c));
            }

            $result[] = $this->pack_map[$c];
        }

        return $result;
    }

    public function unpack($v, $t)
    {
        $result = [];

        foreach ($v as $i) {
            $result[] = $this->alphabet[$i];
        }

        return $result;
    }
}
