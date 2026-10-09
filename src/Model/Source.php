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

namespace Pdir\ConvertToBundle\Model;

use Contao\CoreBundle\Monolog\ContaoContext;
use Contao\Model;
use Contao\System;
use Pdir\ConvertToBundle\Source\SourceInterface;

class Source extends Model
{
    /**
     * Name of the current table.
     *
     * @var string
     */
    protected static $strTable = 'tl_ct_source';

    /**
     * Source instance.
     */
    protected SourceInterface $objSource;

    /**
     * Get source instance.
     */
    public function getSource(): ?SourceInterface
    {
        $logger = System::getContainer()->get('monolog.logger.contao');

        $context = new ContaoContext(
            __METHOD__,
            ContaoContext::ERROR,
        );

        // We only need to build the source once, Model is cached by registry and Source does not change between messages
        if (!$this->objSource) {
            $strClass = $GLOBALS['CONVERT_TO']['SOURCE_TYPE'][$this->type];

            if (!class_exists($strClass)) {
                $logger->error(sprintf('Could not find source class "%s".', $strClass), ['convert-to-bundle' => $context]);

                return null;
            }

            try {
                $objSource = new $strClass($this);

                if (!$objSource instanceof SourceInterface) {
                    $logger->error('The source class "%s" must be an instance of SourceInterface.', ['convert-to-bundle' => $context]);

                    return null;
                }
                $this->objSource = $objSource;
            } catch (\Exception $e) {
                $logger->error(sprintf('There was a general error building the source: "%s".', $e->getMessage()), ['convert-to-bundle' => $context]);

                return null;
            }
        }

        return $this->objSource;
    }

    /**
     * Find sources by interval.
     *
     * @param string $interval
     * @param array  $options
     *
     * @return array<Source>|null
     */
    public static function findSourceByInterval($interval, $options = [])
    {
        $t = static::$strTable;
        $columns = ["$t.cronEnable=?", "$t.cronInterval=?"];
        $values = [1, $interval];

        return static::findBy($columns, $values, $options);
    }
}
