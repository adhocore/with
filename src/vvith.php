<?php

/*
 * This file is part of the WITH package.
 *
 * (c) Jitendra Adhikari <jiten.adhikary@gmail.com>
 *     <https://github.com/adhocore>
 *
 * Licensed under MIT license.
 */

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
