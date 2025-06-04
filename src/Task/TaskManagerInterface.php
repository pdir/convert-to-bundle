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

namespace Pdir\ConvertToBundle\Task;

interface TaskManagerInterface
{
    public function loadData($task);

    public function loadConvertToModel($task);

    public function setApi($api);

    public function setData($data);
}
