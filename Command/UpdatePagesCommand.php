<?php

namespace Msi\Bundle\PageBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class UpdatePagesCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('msi:page:update')
            ->setDescription('create/update pages from routes')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->getContainer()->get('msi_admin.translatable_listener')->setSkipPostLoad(true);

        $this->update($output);

        $output->writeln("<comment>Done!</comment>");
    }

    protected function update($output)
    {
        $pageManager = $this->getContainer()->get('msi_page.page_manager');

        foreach ($this->getContainer()->get('router')->getRouteCollection()->all() as $name => $route) {
            if (!$this->getContainer()->get('msi_page.decorate_strategy')->isRouteDecorable($name)) {
                continue;
            }

            if ($this->getContainer()->get('doctrine')->getRepository('MsiPageBundle:Page')->findOneBy(array('route' => $name))) {
                continue;
            }

            $page = $pageManager->create();
            $page
                ->setEnabled(true)
                ->setRoute($name)
                ->setTemplate('MsiMainBundle::layout.html.twig')
            ;
            $page->createTranslations('Msi\Bundle\PageBundle\Entity\PageTranslation', $this->getContainer()->getParameter('msi_admin.app_locales'));
            foreach ($page->getTranslations() as $trans) {
                $trans->setTitle($name);
            }
            $pageManager->save($page);
            $output->writeln("<info>CREATE</info> ".$name);
        }
    }
}
