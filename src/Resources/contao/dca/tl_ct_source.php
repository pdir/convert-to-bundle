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

use Contao\Database;

$strTable = 'tl_ct_source';

/*
 * Table tl_ct_source
 */
$GLOBALS['TL_DCA'][$strTable] = [
    // Config
    'config' => [
        'dataContainer' => 'Table',
        'enableVersioning' => true,
        'sql' => [
            'keys' => [
                'id' => 'primary',
                'cronInterval' => 'index',
            ],
        ],
    ],
    // List
    'list' => [
        'sorting' => [
            'mode' => 1,
            'fields' => ['type', 'title'],
            'flag' => 1,
            'panelLayout' => 'filter;search,limit',
        ],
        'label' => [
            'fields' => ['title'],
            // 'label_callback' => ['pdir_convert_to.listener.ct_source_data_container', 'executeLabelCallback']
        ],
        'global_operations' => [
            'all' => [
                'label' => &$GLOBALS['TL_LANG']['MSC']['all'],
                'href' => 'act=select',
                'class' => 'header_edit_all',
                'attributes' => 'onclick="Backend.getScrollOffset()" accesskey="e"',
            ],
        ],
        'operations' => [
            'edit' => [
                'label' => &$GLOBALS['TL_LANG'][$strTable]['edit'],
                'href' => 'act=edit',
                'icon' => 'edit.gif',
            ],
            'copy' => [
                'label' => &$GLOBALS['TL_LANG'][$strTable]['copy'],
                'href' => 'act=copy',
                'icon' => 'copy.gif',
            ],
            'delete' => [
                'label' => &$GLOBALS['TL_LANG'][$strTable]['delete'],
                'href' => 'act=delete',
                'icon' => 'delete.gif',
                'attributes' => 'onclick="if(!confirm(\''.($GLOBALS['TL_LANG']['MSC']['deleteConfirm']?? '').'\'))return false;Backend.getScrollOffset()"',
            ],
            'show' => [
                'label' => &$GLOBALS['TL_LANG'][$strTable]['show'],
                'href' => 'act=show',
                'icon' => 'show.gif',
            ],
        ],
    ],
    // Palettes
    'palettes' => [
        '__selector__' => ['type', 'cronEnable', 'fileConnection'],
        'default' => '{title_legend},title,type,model',
        'file' => '{title_legend},title,type,model;{source_legend},fileType,fileConnection;{cronjob_legend},cronExplanation,cronEnable',
    ],
    // Subpalettes
    'subpalettes' => [
        'cronEnable' => 'cronInterval,cronDebug',
        'fileConnection_local' => 'file',
        'fileConnection_ftp' => 'fileHost,filePort,fileUsername,filePassword,filePath',
    ],
    // Fields
    'fields' => [
        'id' => [
            'sql' => 'int(10) unsigned NOT NULL auto_increment',
        ],
        'tstamp' => [
            'sql' => "int(10) unsigned NOT NULL default '0'",
        ],
        'title' => [
            'label' => &$GLOBALS['TL_LANG'][$strTable]['title'],
            'exclude' => true,
            'search' => true,
            'inputType' => 'text',
            'eval' => ['mandatory' => true, 'maxlength' => 255, 'tl_class' => 'w50'],
            'sql' => "varchar(255) NOT NULL default ''",
        ],
        'type' => [
            'label' => &$GLOBALS['TL_LANG'][$strTable]['type'],
            'exclude' => true,
            'filter' => true,
            'inputType' => 'select',
            'options' => \array_keys($GLOBALS['CONVERT_TO']['SOURCE_TYPE']),
            'reference' => &$GLOBALS['TL_LANG'][$strTable]['type'],
            'eval' => ['mandatory' => true, 'includeBlankOption' => true, 'submitOnChange' => true, 'tl_class' => 'w50'],
            'sql' => "varchar(32) NOT NULL default ''",
        ],
        'model' => [
            'label' => &$GLOBALS['TL_LANG'][$strTable]['model'],
            'exclude' => true,
            'filter' => true,
            'inputType' => 'select',
            'options' => \array_keys($GLOBALS['CONVERT_TO']['SOURCE_MODEL']?? []),
            'reference' => &$GLOBALS['TL_LANG'][$strTable]['model'],
            'eval' => ['mandatory' => true, 'includeBlankOption' => true, 'submitOnChange' => true, 'tl_class' => 'w50'],
            'sql' => "varchar(32) NOT NULL default ''",
        ],
        'targetSource' => [
            'label' => &$GLOBALS['TL_LANG'][$strTable]['targetSource'],
            'exclude' => true,
            'filter' => true,
            'inputType' => 'select',
            'options_callback' => function () {
                $options = [];
                $sources = Database::getInstance()->prepare('SELECT id,title FROM tl_ct_source WHERE type!=?')
                    ->execute('file');
                while ($sources->next()) {
                    $options[$sources->id] = $sources->title;
                }

                return $options;
            },
            'eval' => ['mandatory' => true, 'includeBlankOption' => true, 'tl_class' => 'w50'],
            'sql' => "int(10) NOT NULL default '0'",
        ],
        'cronExplanation' => [
            'exclude' => true,
            'input_field_callback' => ['pdir_convert_to.listener.ct_source_data_container', 'sourceCronjobExplanation'],
        ],
        'cronEnable' => [
            'label' => &$GLOBALS['TL_LANG'][$strTable]['cronEnable'],
            'exclude' => true,
            'inputType' => 'checkbox',
            'eval' => ['submitOnChange' => true],
            'sql' => "char(1) NOT NULL default ''",
        ],
        'cronInterval' => [
            'label' => &$GLOBALS['TL_LANG'][$strTable]['cronInterval'],
            'exclude' => true,
            'inputType' => 'select',
            'options' => ['minutely', 'hourly', 'daily', 'weekly', 'monthly'],
            'reference' => &$GLOBALS['TL_LANG'][$strTable]['cronInterval'],
            'eval' => ['tl_class' => 'w50', 'includeBlankOption' => true, 'mandatory' => true],
            'sql' => "varchar(12) NOT NULL default ''",
        ],
        'cronDebug' => [
            'label' => &$GLOBALS['TL_LANG'][$strTable]['cronDebug'],
            'exclude' => true,
            'inputType' => 'checkbox',
            'eval' => ['tl_class' => 'w50', 'submitOnChange' => true],
            'sql' => "int(10) NOT NULL default '0'",
        ],
        'fileType' => [
            'label' => &$GLOBALS['TL_LANG'][$strTable]['fileType'],
            'exclude' => true,
            'filter' => true,
            'inputType' => 'select',
            'options' => ['csv', 'json', 'xml'],
            'reference' => &$GLOBALS['TL_LANG'][$strTable]['fileType'],
            'eval' => ['tl_class' => 'w50'],
            'sql' => "varchar(4) NOT NULL default ''",
        ],
        'fileConnection' => [
            'label' => &$GLOBALS['TL_LANG'][$strTable]['fileConnection'],
            'exclude' => true,
            'filter' => true,
            'inputType' => 'select',
            'options' => ['local', 'ftp'],
            'reference' => &$GLOBALS['TL_LANG'][$strTable]['fileConnection'],
            'eval' => ['includeBlankOption' => true, 'submitOnChange' => true, 'tl_class' => 'w50'],
            'sql' => "varchar(8) NOT NULL default ''",
        ],
        'fileHost' => [
            'label' => &$GLOBALS['TL_LANG'][$strTable]['fileHost'],
            'exclude' => true,
            'inputType' => 'text',
            'eval' => ['mandatory' => true, 'decodeEntities' => true, 'tl_class' => 'w50'],
            'sql' => "varchar(255) NOT NULL default ''",
        ],
        'filePort' => [
            'label' => &$GLOBALS['TL_LANG'][$strTable]['filePort'],
            'exclude' => true,
            'inputType' => 'text',
            'eval' => ['rgxp' => 'digit', 'tl_class' => 'w50'],
            'sql' => "varchar(5) NOT NULL default ''",
        ],
        'fileUsername' => [
            'label' => &$GLOBALS['TL_LANG'][$strTable]['fileUsername'],
            'exclude' => true,
            'inputType' => 'text',
            'eval' => ['mandatory' => true, 'decodeEntities' => true, 'tl_class' => 'w50'],
            'sql' => "varchar(255) NOT NULL default ''",
        ],
        'filePassword' => [
            'label' => &$GLOBALS['TL_LANG'][$strTable]['filePassword'],
            'exclude' => true,
            'inputType' => 'text',
            'eval' => ['mandatory' => true, 'decodeEntities' => true, 'hideInput' => true, 'tl_class' => 'w50'],
            'sql' => "varchar(255) NOT NULL default ''",
        ],
        'filePath' => [
            'label' => &$GLOBALS['TL_LANG'][$strTable]['filePath'],
            'exclude' => true,
            'inputType' => 'text',
            'eval' => ['decodeEntities' => true, 'trailingSlash' => false, 'tl_class' => 'clr long'],
            'sql' => "varchar(255) NOT NULL default ''",
        ],
        'file' => [
            'label' => &$GLOBALS['TL_LANG'][$strTable]['file'],
            'exclude' => true,
            'inputType' => 'fileTree',
            'eval' => ['fieldType' => 'radio', 'files' => true, 'filesOnly' => true, 'tl_class' => 'clr', 'extensions' => 'xml,json,csv'],
            'sql' => 'blob NULL',
        ],
    ],
];
