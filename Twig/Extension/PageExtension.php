<?php

namespace Msi\Bundle\PageBundle\Twig\Extension;

class PageExtension extends \Twig_Extension
{
    private $container;
    private $pageManager;

    public function __construct($container)
    {
        $this->container = $container;
        $this->pageManager = $this->container->get('msi_page.page_manager');
    }

    public function getGlobals()
    {
        $page = $this->pageManager->findByRoute($this->container->get('request')->attributes->get('_route'));
        if (!$page) {
            $page = $this->pageManager->findOneOrCreate();
        }

        return array('page' => $page);
    }

    public function getName()
    {
        return 'msi_page';
    }
}
