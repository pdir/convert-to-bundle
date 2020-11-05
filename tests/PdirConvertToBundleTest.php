<?php

/*
 * Contao Convert To bundle for Contao Open Source CMS
 *
 * Copyright (c) 2020 pdir / digital agentur // pdir GmbH
 *
 * @package    convert-to-bundle
 * @link       https://pdir.de/docs/de/contao/extensions/convert-to/
 * @license    MIT
 * @author     Mathias Arzberger <develop@pdir.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pdir\ConvertToBundle\Tests;

use PHPUnit\Framework\TestCase;

class PdirConvertToBundleTest extends TestCase
{
    public function testCanBeInstantiated()
    {
        $bundle = new PdirCovertToBundle();

        $this->assertInstanceOf('Pdir\ConvertToBundle\PdirConvertToBundle', $bundle);
    }
}
