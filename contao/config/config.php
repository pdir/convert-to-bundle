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

use Contao\ArrayUtil;

ArrayUtil::arrayInsert($GLOBALS['BE_MOD'], 1, ['convert_to' => []]);

$GLOBALS['BE_MOD']['pdir']['ct_source'] = [
    'tables' => ['tl_ct_source'],
];

/*
 * Cron jobs
 */
$GLOBALS['TL_CRON']['minutely'][] = ['Pdir\ConvertToBundle\Frontend\Cron', 'minutely'];
$GLOBALS['TL_CRON']['hourly'][] = ['Pdir\ConvertToBundle\Frontend\Cron', 'hourly'];
$GLOBALS['TL_CRON']['daily'][] = ['Pdir\ConvertToBundle\Frontend\Cron', 'daily'];
$GLOBALS['TL_CRON']['weekly'][] = ['Pdir\ConvertToBundle\Frontend\Cron', 'weekly'];
$GLOBALS['TL_CRON']['monthly'][] = ['Pdir\ConvertToBundle\Frontend\Cron', 'monthly'];

/*
 * Models
 */
$GLOBALS['TL_MODELS']['tl_ct_source'] = 'Pdir\ConvertToBundle\Model\Source';

/*
 * Task manager
 */
//$GLOBALS['CONVERT_TO']['TASK_MANAGER'] = new \Pdir\ConvertToBundle\Task\TaskManager();

/*
 * Sources models
 */
/*
$GLOBALS['CONVERT_TO']['SOURCE_MODEL'] = array_merge(
    (array) $GLOBALS['CONVERT_TO']['SOURCE_MODEL'],
    [
        'example'    => 'Pdir\ConvertToBundle\ConvertTo\ExampleImport',
    ]
);*/

/*
 * Sources types
 */

$GLOBALS['CONVERT_TO'] = $GLOBALS['CONVERT_TO'] ?? [];

if (true !== array_key_exists('SOURCE_TYPE', $GLOBALS['CONVERT_TO'])) {
    ArrayUtil::arrayInsert($GLOBALS['CONVERT_TO'], 1, ['SOURCE_TYPE' => []]);
}

$GLOBALS['CONVERT_TO']['SOURCE_TYPE'] = array_merge(
    (array) $GLOBALS['CONVERT_TO']['SOURCE_TYPE'], [
        'file' => 'Pdir\ConvertToBundle\Source\File',
    ]
);
