<?php

namespace FFX\Codecs;

class Sequence extends Codec
{
    protected $alphabet;

    protected $pack_map;

    protected $length;

    public function __construct($ffx, $alphabet, $length)
    {
        $this->alphabet = $alphabet;
        $this->pack_map = array_flip(str_split($alphabet)); // {c: i for i, c in enumerate(alphabet)}
        $this->length = $length;

        parent::__construct($ffx, strlen($alphabet));
    }

    public function pack($v)
    {
        if (strlen($v) !== $this->length) {
            throw new \InvalidArgumentException(sprintf('Sequence length must be %s', $this->length));
        }

        try {
            $result = [];

            foreach (str_split($v) as $c) {
                $result[] = $this->pack_map[$c];
            }

            return $result; // [self.pack_map[c] for c in v]
        } catch (\Exception $e) {

        }
    }

    public function unpack($v, $t)
    {
        $result = [];

        foreach ($v as $i) {
            $result[] = $this->alphabet[$i];
        }

        return $result;

        // return t($this->alphabet[$i] for i in v)
    }
}
