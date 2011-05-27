<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sensio\Bundle\GeneratorBundle\Tests\Manipulator;

use Sensio\Bundle\GeneratorBundle\Manipulator\Manipulator;

class ManipulatorTest extends \PHPUnit_Framework_TestCase
{
    public function testParseArray()
    {
        $manipulator = new Manipulator();
        $manipulator->setCode(token_get_all("<?php array(1, 'a', __DIR__.'foo');"));
        $manipulator->next();
        $token = $manipulator->next();

        $this->assertEquals(array(1, 'a', __DIR__.'foo'), $manipulator->parseArray($token));
    }
}
