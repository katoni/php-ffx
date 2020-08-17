<?php

namespace Katoni\FFX\Tests;

use Katoni\FFX\Codecs\Integer;
use Katoni\FFX\Codecs\Text;
use PHPUnit\Framework\TestCase;

class Test extends TestCase
{
    public function testTextEncryption()
    {
        $ffx = new Text('secret', 'abc', 3);

        $this->expectErrorMessage('Non-alphabet character: x');

        $ffx->encrypt('abx');

        $this->assertEquals('aba', $ffx->encrypt('cba'));
        $this->assertEquals('ccc', $ffx->decrypt($ffx->encrypt('ccc')));
    }

    public function testIntegerEncryption()
    {
        $ffx = new Integer('secret', 2);

        $array = [];

        for ($i = 0; $i < 100; $i++) {
            $encrypted = $ffx->encrypt($i);

            $this->assertEquals($i, $ffx->decrypt($encrypted));

            $array[] = $encrypted;
        }

        $this->assertEquals(100, count(array_unique($array)));
    }

    /*public function testBigIntegerEncryption()
    {
        $ffx = new Integer('secret', 20);

        // TODO Support big numbers

        $this->assertEquals(1, $ffx->decrypt($ffx->encrypt(1)));
    }*/
}
