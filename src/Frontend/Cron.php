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

namespace Pdir\ConvertToBundle\Frontend;

use Contao\CoreBundle\Monolog\ContaoContext;
use Contao\System;
use Pdir\ConvertToBundle\Model\Source;
use Pdir\ConvertToBundle\Task\TaskManager;
use Pdir\ConvertToBundle\Task\TaskManagerInterface;

class Cron
{
    public function minutely(): void
    {
        $this->runTasks('minutely');
    }

    public function hourly(): void
    {
        $this->runTasks('hourly');
    }

    public function daily(): void
    {
        $this->runTasks('daily');
    }

    public function weekly(): void
    {
        $this->runTasks('weekly');
    }

    public function monthly(): void
    {
        $this->runTasks('monthly');
    }

    /**
     * Triggers tasks for sources and run based on poor man cron jobs.
     *
     * @param string $interval
     */
    private function runTasks($interval): void
    {
        $logger = System::getContainer()->get('monolog.logger.contao');

        $context = new ContaoContext(
            __METHOD__,
            ContaoContext::ERROR,
        );

        $tasks = Source::findSourceByInterval($interval);

        if (null === $tasks) {
            return;
        }

        /** @var TaskManagerInterface $taskManager */
        foreach ($tasks as $task) {
            $taskManager = new TaskManager($task);
            $taskManager->convert();

            $logger->error(sprintf('Convert To task: "%s".', $task->title), ['convert-to-bundle' => $context]);
        }
    }
}
