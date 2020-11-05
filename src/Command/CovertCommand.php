<?php

declare(strict_types=1);

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

namespace Pdir\ConvertToBundle\Command;

use Contao\CoreBundle\Framework\ContaoFramework;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Unzip zip file and import estate data from xml file.
 */
class CovertCommand extends Command
{
    protected static $defaultName = 'convert:run';
    protected $framework;
    private $io;
    private $rows = [];
    private $statusCode = 0;

    public function __construct(ContaoFramework $contaoFramework)
    {
        $this->framework = $contaoFramework;
        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    protected function configure(): void
    {
        $this->setDescription('Run cron tasks of ConvertToBundle.')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output): ?int
    {
        $this->framework->initialize();

        $this->io = new SymfonyStyle($input, $output);

        $strLog = (new Cron())->minutely();
        $this->io->text(sprintf('Run convert. (<info>%s</info>).', $strLog));

        $this->io->text(sprintf('Conver To Task complete (<info>%s</info>).', $strLog));

        return $this->statusCode;
    }
}
