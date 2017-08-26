<?php

namespace Ahc\With\Test;

use Ahc\With\With;
use function Ahc\with;

/** @coversDefaultClass \Ahc\With\With */
class WithTest extends \PHPUnit_Framework_TestCase
{
    public function testWith()
    {
        $with = (new With($thing = ['a' => 1, 'b' => 2, 'c' => 3]))
            ->array_values()
            ->array_map_(function ($value) { return $value * 2; })
            ->json_encode()
            ->base64_encode()
            ->via(function ($value) { return trim($value, '=/'); })
            ->via([new Util, 'process']);

        $without = (new Util)->process(
            trim(
                base64_encode(
                    json_encode(
                        array_map(
                            function ($value) { return $value * 2; },
                            array_values($thing)
                        )
                    )
                ),
                '=/'
            )
        );

        $this->assertSame($without, $with(), 'with and without should be same');
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
