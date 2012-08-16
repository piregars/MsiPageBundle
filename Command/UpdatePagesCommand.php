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
            ->setDescription('updates pages from routes')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->update($output);

        $output->writeln("<info>done!</info>");
    }

    protected function update($output)
    {
        $pageManager = $this->getContainer()->get('msi_page.page_manager');

        foreach ($this->getContainer()->get('router')->getRouteCollection()->all() as $name => $route) {
            $page = $pageManager->findByRoute($name);

            if ($name !== 'msi_page_show' && !isset($page[0]) && !preg_match('@admin@', $name) && !preg_match('@^_@', $name)) {
                $page = $pageManager->create();
                $page
                    ->setEnabled(true)
                    ->setRoute($name)
                    ->setTemplate('ArmrsMainBundle::layout.html.twig')
                ;
                $page->createTranslations('Msi\Bundle\PageBundle\Entity\PageTranslation', $this->getContainer()->getParameter('msi_admin.locales'));
                $page->getTranslation()->setTitle($name);
                $pageManager->save($page);
                $output->writeln("<info>CREATE</info> ".$name);
            }
        }
    }
}
