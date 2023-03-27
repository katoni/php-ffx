<?php

namespace Katoni\FFX;

class FFX
{
    protected $key;

    protected $rounds;

    protected $digest_size = 20;

    public function __construct(string $key, int $rounds = 10, string $algo = 'sha1')
    {
        $this->key = $key;
        $this->rounds = $rounds;
    }

    protected function add($radix, $a, \Generator $b): array
    {
        return array_map(function ($a) use ($b, $radix) {
            $value = gmp_strval(gmp_mod(gmp_add($a, $b->current()), $radix));

            $b->next();

            return $value;
        }, $a);
    }

    protected function sub($radix, $a, $b)
    {
        return array_map(function ($a) use ($b, $radix) {
            $value = gmp_strval(gmp_mod(gmp_sub($a, $b->current()), $radix));

            $b->next();

            return $value;
        }, $a);
    }

    protected function round($radix, $i, $s): \Generator
    {
        $key = pack(sprintf('I%sI', count($s)), $i, ...$s);

        $chars_per_hash = (int) ($this->digest_size * log(256, $radix));
        $i = 0;

        while (true) {
            $h = hash_hmac('sha1', $key . pack('I', $i), $this->key);
            $d = gmp_init($h, 16);

            foreach (range(0, $chars_per_hash) as $item) {
                [$d, $r] = divmod($d, $radix);

                yield $r;
            }

            $key = hex2bin($h);
            $i++;
        }
    }

    protected function split($v): array
    {
        $s = (int) (count($v) / 2);

        return [
            array_slice($v, 0, $s),
            array_slice($v, $s),
        ];
    }

    public function encrypt($radix, $v): array
    {
        list ($a, $b) = $this->split($v);

        for ($i = 0; $i < $this->rounds; $i++) {
            $c = $this->add($radix, $a, $this->round($radix, $i, $b));
            list ($a, $b) = [$b, $c];
        }

        return array_merge($a, $b);
    }

    public function decrypt($radix, $v)
    {
        list($a, $b) = $this->split($v);

        for ($i = $this->rounds - 1; $i >= 0; $i--) {
            $c = $b;
            $b = $a;
            $a = $this->sub($radix, $c, $this->round($radix, $i, $b));
        }

        return array_merge($a, $b);
    }
}

function divmod($a, $b)
{
    $remainder = gmp_mod($a, $b);
    $quotient = gmp_div(gmp_sub($a, $remainder), $b);

    return [$quotient, $remainder];
}
