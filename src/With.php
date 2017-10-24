<?php

namespace Ahc\With;

/**
 * With provides object like fluent interface for scalars and non objects.
 *
 * @author Jitendra Adhikari <jiten.adhikary@gmail.com>
 */
class With
{
    private $thing;
    private $stack = [];

    /**
     * The constructor.
     *
     * @param mixed $thing Any thing (but non-objects preferred).
     */
    public function __construct($thing)
    {
        $this->stack[] = $this->thing = $thing;
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
        if (substr($method, -1) === '_') {
            $method   = substr($method, 0, -1);
            $things[] = $this->thing;
        } else {
            array_unshift($things, $this->thing);
        }

        $this->stack[] = $this->thing = $method(...$things);

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
        array_unshift($things, $this->thing);

        $this->stack[] = $this->thing = $method(...$things);

        return $this;
    }

    /**
     * Get the intermediate value(s).
     *
     * @param int|null $pos The 0-indexed position of a value (optional, returns all value when omitted).
     *
     * @return mixed The value at given position when specified, all values as array otherwise.
     */
    public function stack(int $pos = null)
    {
        return null === $pos ? $this->stack : $this->stack[$pos];
    }
}
