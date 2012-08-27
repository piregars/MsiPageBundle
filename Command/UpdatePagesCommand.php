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
            if (!$this->checkWhitelist($name)) {
                continue;
            }

            if (!$this->checkWhitelistPattern($name)) {
                continue;
            }

            if (!$this->checkBlacklist($name)) {
                continue;
            }

            if (!$this->checkBlacklistPattern($name)) {
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

    protected function checkWhitelist($name)
    {
        $whitelist = $this->getContainer()->getParameter('msi_page.route_whitelist');
        if (empty($whitelist) || in_array($name, $whitelist)) {
            return true;
        }

        return false;
    }

    protected function checkWhitelistPattern($name)
    {
        $whitelistPattern = $this->getContainer()->getParameter('msi_page.route_whitelist_pattern');

        if (empty($whitelistPattern)) {
            return true;
        }

        foreach ($whitelistPattern as $pattern) {
            if (!preg_match($pattern, $name)) {
                return false;
            }
        }

        return true;
    }

    protected function checkBlacklist($name)
    {
        $blacklist = $this->getContainer()->getParameter('msi_page.route_blacklist');
        if (empty($blacklist) || !in_array($name, $blacklist)) {
            return true;
        }

        return false;
    }

    protected function checkBlacklistPattern($name)
    {
        $blacklistPattern = $this->getContainer()->getParameter('msi_page.route_blacklist_pattern');

        if (empty($blacklistPattern)) {
            return true;
        }

        foreach ($blacklistPattern as $pattern) {
            if (preg_match($pattern, $name)) {
                return false;
            }
        }

        return true;
    }
}
