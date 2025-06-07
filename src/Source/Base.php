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

use Contao\DataContainer;
use Pdir\ConvertToBundle\Model\Source;

abstract class Base extends \Controller
{
    /**
     * The source model.
     */
    protected Source $objModel;

    /**
     * Set model.
     */
    public function __construct(Source $objModel)
    {
        $this->objModel = $objModel;
    }

    /**
     * Gets the source model.
     */
    public function getModel(): Source
    {
        return $this->objModel;
    }

    /**
     * Gets the back end list label.
     */
    public function getLabel(array $row, string $label, DataContainer $dc, array $args): string
    {
        $targetModel = Source::findByPk($row['id']);

        if (null === $targetModel) {
            return $label;
        }

        $label .= sprintf(
            '<div style="color:#ccc;margin:5px 0 0 10px;">&#8627; %s</div>',
            $targetModel->title
        );

        return $label;
    }
}
