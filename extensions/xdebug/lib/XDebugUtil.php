<?php

/*
 * This file is part of the PHPBench package
 *
 * (c) Daniel Leech <daniel@dantleech.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 */

namespace PhpBench\Extensions\XDebug;

use PhpBench\Model\Iteration;

class XDebugUtil
{
    public static function filenameFromIteration(Iteration $iteration, $extension = ''): string
    {
        $name = sprintf(
            '%s%s%s',
            $iteration->getVariant()->getSubject()->getBenchmark()->getClass(),
            $iteration->getVariant()->getSubject()->getName(),
            $iteration->getVariant()->getParameterSet()->getName()
        );


        return md5($name) . $extension;
    }
}
