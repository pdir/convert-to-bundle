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

namespace Pdir\ConvertToBundle\Model;

class Source extends \Model
{
    /**
     * Name of the current table.
     *
     * @var string
     */
    protected static $strTable = 'tl_ct_source';

    /**
     * Source instance.
     *
     * @var SourceInterface
     */
    protected $objSource;

    /**
     * Get source instance.
     *
     * @return SourceInterface|null
     */
    public function getSource()
    {
        // We only need to build the source once, Model is cached by registry and Source does not change between messages
        if (null === $this->objSource) {
            $strClass = $GLOBALS['CONVERT_TO']['SOURCE_TYPE'][$this->type];
            if (!class_exists($strClass)) {
                \System::log(sprintf('Could not find source class "%s".', $strClass), __METHOD__, TL_ERROR);

                return null;
            }
            try {
                $objSource = new $strClass($this);
                if (!$objSource instanceof SourceInterface) {
                    \System::log(sprintf('The source class "%s" must be an instance of SourceInterface.', $strClass), __METHOD__, TL_ERROR);

                    return null;
                }
                $this->objSource = $objSource;
            } catch (\Exception $e) {
                \System::log(sprintf('There was a general error building the source: "%s".', $e->getMessage()), __METHOD__, TL_ERROR);

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
     * @return Source[]|null
     */
    public static function findSourceByInterval($interval, $options = [])
    {
        $t = static::$strTable;
        $columns = ["$t.cronEnable=?", "$t.cronInterval=?"];
        $values = [1, $interval];

        return static::findBy($columns, $values, $options);
    }
}
