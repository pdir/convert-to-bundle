<?php

declare(strict_types=1);

/*
 * Contao Convert To bundle for Contao Open Source CMS
 *
 * Copyright (c) 2025 pdir / digital agentur // pdir GmbH
 *
 * @package    convert-to-bundle
 * @link       https://pdir.de/docs/de/contao/extensions/convert-to/
 * @license    MIT
 * @author     Mathias Arzberger <develop@pdir.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pdir\ConvertToBundle\Source;

class File extends Base implements SourceInterface
{
    /**
     * get file to run source task.
     *
     * @param Task $objSource
     * @param   array
     * @param   string
     *
     * @return bool
     */
    public function run(Source $objSource)
    {
    }
}
