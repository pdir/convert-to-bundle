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

namespace Pdir\ConvertToBundle\Task;

use Contao\File;

class TaskManager
{
    protected $task;

    protected $data;

    protected $api;

    public function __construct($task)
    {
        $this->task = $task;
    }

    public function setApi($api)
    {
        $this->api = $api;
    }

    public function setData($data)
    {
        $this->data = $data;
    }

    public function loadData()
    {
        // load data from local file
        if ('file' === $this->task->type) {
            $objFile = \FilesModel::findByUuid($this->task->file);
            $this->data = file_get_contents(TL_ROOT.'/'.$objFile->path);
        }

        if ('xml' === $this->task->fileType) {
            $this->data = simplexml_load_string($this->data);
        }
    }

    public function loadConvertToModel()
    {
        return new $GLOBALS['CONVERT_TO']['SOURCE_MODEL'][$this->task->model]();
    }

    public function convert()
    {
        $sourceFile = \FilesModel::findByPath($this->task->filePath);

        if ($sourceFile) {
            $this->loadData();

            if (isset($GLOBALS['TL_HOOKS']['convertToStart'])) {
                foreach ($GLOBALS['TL_HOOKS']['convertToStart'] as $callback) {
                    $this->import($callback[0]);
                    $this->$callback[0]->$callback[1]($this);
                }
            }
        }

        if(null === $this->data)
        {
            return;
        }

        $convertToModel = $this->loadConvertToModel();
        $convertToModel->setDebugMode($this->task->cronDebug);

        if(null !== $this->data)
        {
            $convertToModel->setData($this->data);
        }

        if(null !== $this->api)
        {
            $convertToModel->setApi($this->api);
        }

        $convertToModel->convert();
    }
}
