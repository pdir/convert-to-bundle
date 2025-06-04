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

use Contao\FilesModel;
use Contao\System;

class TaskManager
{
    protected $task;

    protected $data;

    protected $api;

    private $debugMode = 0;

    public function __construct($task)
    {
        $this->task = $task;

        // set debug mode from task
        $this->debugMode = $this->task->cronDebug;
    }

    public function setApi($api): void
    {
        $this->api = $api;
    }

    public function setData($data): void
    {
        $this->data = $data;
    }

    public function setDebugMode($mode): void
    {
        $this->debugMode = $mode;
    }

    public function loadData(): void
    {
        // load data from local file
        if ('file' === $this->task->type) {
            $file = FilesModel::findByUuid($this->task->file);
            $this->data = file_get_contents(System::getContainer()->getParameter('kernel.project_dir').'/'.$file->path);
        }

        if ('filePath' === $this->task->type) {
            $file = FilesModel::findByPath($this->task->filePath);
            $this->data = file_get_contents(System::getContainer()->getParameter('kernel.project_dir').'/'.$file->path);
        }

        if ('xml' === $this->task->fileType) {
            $this->data = simplexml_load_string($this->data);
        }
    }

    public function loadConvertToModel()
    {
        return new $GLOBALS['CONVERT_TO']['SOURCE_MODEL'][$this->task->model]();
    }

    public function convert(): void
    {
        $this->loadData();

        if (null === $this->data) {
            return;
        }

        if (isset($GLOBALS['TL_HOOKS']['convertToStart'])) {
            foreach ($GLOBALS['TL_HOOKS']['convertToStart'] as $callback) {
                $this->import($callback[0]);
                $this->$callback[0]->$callback[1]($this);
            }
        }

        $convertToModel = $this->loadConvertToModel();
        $convertToModel->setDebugMode($this->debugMode);

        if (null !== $this->data) {
            $convertToModel->setData($this->data);
        }

        if (null !== $this->api) {
            $convertToModel->setApi($this->api);
        }

        $convertToModel->convert();
    }
}
