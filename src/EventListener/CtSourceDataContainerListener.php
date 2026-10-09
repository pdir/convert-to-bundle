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

namespace Pdir\ConvertToBundle\EventListener;

use Contao\DataContainer;
use Pdir\ConvertToBundle\Model\Source;
use Pdir\ConvertToBundle\Source\SourceInterface;

class CtSourceDataContainerListener
{
    /**
     * Gets the back end list label.
     *
     * @param array  $row
     * @param string $label
     */
    public function executeLabelCallback($row, $label, DataContainer $dc, array $args): string
    {
        $model = Source::findByPk($row['id']);
        $source = $model->getSource();

        if ($source instanceof SourceInterface) {
            return $source->getLabel($row, $label, $dc, $args);
        }

        return $label;
    }

    /**
     * Gets the cron job explanation.
     */
    public function sourceCronjobExplanation(DataContainer $dc): string
    {
        return sprintf(
            '<div style="color: #4b85ba;
            background: #eff5fa;
            padding: 1em;
            line-height: 1.2em;">%s</div>',
            str_replace('{source_id}', $dc->id, $GLOBALS['TL_LANG']['tl_ct_source']['sourceCronjobExplanation'])
        );
    }
}
