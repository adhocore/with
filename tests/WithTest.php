<?php

/*
 * This file is part of the WITH package.
 *
 * (c) Jitendra Adhikari <jiten.adhikary@gmail.com>
 *     <https://github.com/adhocore>
 *
 * Licensed under MIT license.
 */

namespace Ahc\With\Test;

use function Ahc\with;
use Ahc\With\With;
use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \Ahc\With\With */
class WithTest extends TestCase
{
    public function testWith()
    {
        $with = (new With($thing = ['a' => 1, 'b' => 2, 'c' => 3]))
            ->array_values()
            ->array_map_(function ($value) {
                return $value * 2;
            })
            ->json_encode()
            ->base64_encode()
            ->via(function ($value) {
                return trim($value, '=/');
            })
            ->via([new Util, 'process']);

        $without = (new Util)->process(
            trim(
                base64_encode(
                    json_encode(
                        array_map(
                            function ($value) {
                                return $value * 2;
                            },
                            array_values($thing)
                        )
                    )
                ),
                '=/'
            )
        );

        $this->assertSame($without, $with(), 'with and without should be same');
    }

    public function test_vvith()
    {
        $this->assertInstanceOf(With::class, with([1]));
    }
}

class Util
{
    public function process($value)
    {
        // Some complex logic here

        return 'processed: ' . $value;
    }
}
