## adhocore/with [![build status](https://travis-ci.org/adhocore/with.svg?branch=master)](https://travis-ci.org/adhocore/with)

- Objectify scalars and non objects
- Fluent method chaining instead of nested function calls
- For PHP7

## Installation
```bash
composer require adhocore/with
```

## Usage
```php
use function Ahc\with;
// OR
use Ahc\With\With;

$val = ['a' => 10, 'b' => 12, 'c' => 13];
$fun = with($val) // OR (new With($val))
    ->array_values()
    // _ at the end means the current value is appended to the supplied arguments (default is prepend).
    ->array_map_(function ($v) { return $v + 2; })
    ->array_sum()
;

echo $fun(); // gives 41!

// Passing value through closures or class methods:
with($value)->via(function ($val) { return $val; });
with($value)->via([new SomeClass, 'method']);
```

## Why

**TL;DR**: Provides more intuitiveness, comprehensibility and less cognitive overhead than nested function calls.

Did you ever had to pass a scalar/non-object through many layers of functions? Then you might have probably ended up with having to call the first the function which had to be called at the last logically. For example if you want to sum the keys of an array after adding 2 to them?

```php
// Without:
array_sum(array_map(function ($a) { return $a + 2; }, array_keys($array)));

// With:
with($array)->array_keys()->array_map_(function ($a) { return $a + 2; })->array_sum();
```
