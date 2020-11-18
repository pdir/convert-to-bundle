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

namespace Pdir\ConvertToBundle\EventListener;

use Contao\Backend;
use Contao\DataContainer;
use Pdir\ConvertToBundle\Model\Source;

class CtSourceDataContainerListener
{
    /**
     * Gets the back end list label.
     *
     * @param array  $row
     * @param string $label
     * @param array  $args
     *
     * @return string
     */
    public function executeLabelCallback($row, $label, DataContainer $dc, $args)
    {
        $model = Source::findByPk($row['id']);
        $source = $model->getSource();
        if ($source instanceof LabelCallbackInterface) {
            return $source->getLabel($row, $label, $dc, $args);
        }

        return $label;
    }

    /**
     * Gets the cron job explanation.
     *
     * @return string
     */
    public function sourceCronjobExplanation(DataContainer $dc)
    {
        return sprintf('<div style="color: #4b85ba;
            background: #eff5fa;
            padding: 1em;
            line-height: 1.2em;">%s</div>',
            str_replace('{source_id}', $dc->id, $GLOBALS['TL_LANG']['sourceCronjobExplanation'])
        );
    }
}
