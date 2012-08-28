<?php

namespace Msi\Bundle\PageBundle\Twig\Extension;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
        $route = $this->container->get('request')->attributes->get('_route');

        if ($this->container->get('msi_page.decorate_strategy')->isRouteDecorable($route)) {
            $page = $this->pageManager->findByRoute($route);
        } else {
            $page = $this->pageManager->findOneOrCreate();
        }

        if (!$page) {
            throw new NotFoundHttpException('"'.$route.'" is supposed to be decorated, but no page was found. Maybe you should run app/console msi:page:update or manually create the page.');
        }

        return array('page' => $page);
    }

    public function getName()
    {
        return 'msi_page';
    }
}
