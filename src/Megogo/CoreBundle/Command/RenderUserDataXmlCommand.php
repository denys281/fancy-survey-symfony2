<?php

namespace Megogo\CoreBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Filesystem\Filesystem;

class RenderUserDataXmlCommand extends Command
{

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('render:userData:xml')
            ->setDescription('Render user data xml file.')
            ->addArgument(
                'email',
                InputArgument::OPTIONAL,
                'Mail time, when command generate report'
            );
    }

    /**
     * {@inheritdoc}
     *
     * @throws \InvalidArgumentException When the target directory does not exist or symlink cannot be used
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $container = $this->getApplication()->getKernel()->getContainer();

        $pidFilePath = __DIR__ . '/xml.lock.pid';

        //Check if command not run
        $fs = new Filesystem();

        $fileExist = $fs->exists($pidFilePath);

        try {
            if ($fileExist) {
                $output->writeln("<error>Command already run at this moment. Please, try later</error>");
            } else {
                $fs->touch($pidFilePath);
                $output->writeln("<info>Create report</info>");
                $file = $container->get('megogo_core.xml_report')->createLog();
                $output->writeln("<info>Success</info>");
                $fs->remove($pidFilePath);
            }
        } catch (\Exception $e) {
            $msg = $e->getMessage();
            $output->writeln("<error>$msg</error>");
            $fs->remove($pidFilePath);
        }

        $email = $input->getArgument('email');

        if ($email){
            $time = new \DateTime();
            $output->writeln("<info>Send email</info>");
            $container->get('megogo_core.mailer_wrap')->sendEmailAfterXmlReportCreated($email, $time->format('H:i:s \O\n Y-m-d'));
        }
    }

}
