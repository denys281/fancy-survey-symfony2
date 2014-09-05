<?php

namespace Megogo\CoreBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\Finder\Finder;

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
        ;
    }

    /**
     * {@inheritdoc}
     *
     * @throws \InvalidArgumentException When the target directory does not exist or symlink cannot be used
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $output->writeln("<info>Render xml file</info>");

        $container = $this->getApplication()->getKernel()->getContainer();
        //Get confirmed order, with no payment transfer
        $user = $container->get('megogo_core.database')->getUserForXml();

        $serializer = $container->get('jms_serializer');
        $xml = $serializer->serialize($user, 'xml');
//        $data = $serializer->deserialize($inputStr, $typeName, $format);


        print($xml);
        die();

        $output->writeln("<info>Transfer point</info>");
        $this->transerPointFor($order);
        $output->writeln("<info>Done</info>");

    }



    private function transerPointFor($order)
    {
        $currentDate = new \DateTime(date('Y-m-d H:i:s'));
        $dayParameter = $this->getApplication()->getKernel()->getContainer()->get('settings')->get('payment_days');
        $em = $this->getApplication()->getKernel()->getContainer()->get('doctrine')->getEntityManager();

        foreach ($order as $orderItem) {
            $paymentDate = $orderItem->getCreatedAt()->add(new \DateInterval('P'.$dayParameter.'D'));

            if ($paymentDate <= $currentDate) {
                // $orderItem->getSeller()->setPoint($orderItem->getSeller()->getPoint() + $orderItem->getPoint());
                $orderItem->setIsPointTransferedToSeller(true);
                $em->persist($orderItem);
                
                $this->getApplication()->getKernel()->getContainer()->get('webmil_frontend_user_resource.actions')->addingPointsForSales($orderItem->getSeller()->getId(), $orderItem->getPoint());

                $this->getApplication()->getKernel()->getContainer()->get('event_dispatcher')->dispatch(WebmilCoreEvents::USER_TRANSFER_POINT_COMPLETED, new GenericEvent($orderItem->getSeller()));
            }
        }

        try {
            $em->flush();
        } catch (\Exception $e) {
            $message = $e->getMessage();
            $output->writeln("<error>$message</error>");
        }
    }
}
