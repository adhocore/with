## adhocore/with

[![Latest Version](https://img.shields.io/github/release/adhocore/with.svg?style=flat-square)](https://github.com/adhocore/with/releases)
[![Travis Build](https://img.shields.io/travis/adhocore/with/master.svg?style=flat-square)](https://travis-ci.org/adhocore/with?branch=master)
[![Scrutinizer CI](https://img.shields.io/scrutinizer/g/adhocore/with.svg?style=flat-square)](https://scrutinizer-ci.com/g/adhocore/with/?branch=master)
[![Codecov branch](https://img.shields.io/codecov/c/github/adhocore/with/master.svg?style=flat-square)](https://codecov.io/gh/adhocore/with)
[![StyleCI](https://styleci.io/repos/101482325/shield)](https://styleci.io/repos/101482325)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)


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

$val  = ['a' => 10, 'b' => 12, 'c' => 13];
$with = with($val) // OR (new With($val))
    ->array_values()
    // _ at the end means the current value is appended to the supplied arguments (default is prepend).
    ->array_map_(function ($v) { return $v + 2; })
    ->array_sum()
;

// Get the final result
echo $with(); // 41

// Get all the intermediate values all the way from original input to final result!
list($original, $array_values, $array_map, $array_sum) = $with->stack();

// Just the value of third operation
$array_map = $with->stack(3-1);

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
