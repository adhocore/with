<?php

/*
 * This file is part of the WITH package.
 *
 * (c) Jitendra Adhikari <jiten.adhikary@gmail.com>
 *     <https://github.com/adhocore>
 *
 * Licensed under MIT license.
 */

namespace Ahc\With;

/**
 * With provides object like fluent interface for scalars and non objects.
 *
 * @author Jitendra Adhikari <jiten.adhikary@gmail.com>
 */
class With
{
    private $thing;

    /**
     * The constructor.
     *
     * @param mixed $thing Any thing (but non-objects preferred).
     */
    public function __construct($thing)
    {
        $this->thing = $thing;
    }

    /**
     * The method call is delegated to the thing initially `with`ed.
     *
     * By default The initial thing will be first parameter to the method to be called.
     * You can change this behavior by suffixing underscore (_) to the method name.
     *
     * @param string $method
     * @param array  $things
     *
     * @return With
     */
    public function __call(string $method, array $things): With
    {
        if (\substr($method, -1) === '_') {
            $method   = \substr($method, 0, -1);
            $things[] = $this->thing;
        } else {
            \array_unshift($things, $this->thing);
        }

        $this->thing = $method(...$things);

        return $this;
    }

    /**
     * Call as a function to get the final value!
     *
     * @return mixed
     */
    public function __invoke()
    {
        return $this->thing;
    }

    /**
     * Pass the value via any callable and optionally extra arguments.
     *
     * @param callable $method
     * @param array    $things
     *
     * @return With
     */
    public function via(callable $method, array $things = []): With
    {
        \array_unshift($things, $this->thing);

        $this->thing = $method(...$things);

        return $this;
    }
}
