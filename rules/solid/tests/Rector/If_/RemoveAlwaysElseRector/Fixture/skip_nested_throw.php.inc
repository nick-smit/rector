<?php

namespace Rector\SOLID\Tests\Rector\If_\RemoveAlwaysElse\Fixture;

use Throwable;

class SkipNestedThrow
{
    public function run($value)
    {
        if ($value) {
            if ($value !== 5) {
                throw new \InvalidStateException;
            }
        } else {
            return 10;
        }
    }

    public function run2($value)
    {
        if ($value) {
            try {
                if ($value !== 5) {
                    throw new \InvalidStateException;
                }
            } catch (Throwable $throwable) {
            }
        } else {
            return 10;
        }
    }
}
