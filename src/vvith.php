<?php

namespace Ahc;

/**
 * With function.
 *
 * @param mixed $thing
 *
 * @return With\With
 */
function with($thing)
{
    return new With\With($thing);
}
