<?php

namespace Msi\Bundle\PageBundle\Twig\Extension;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\DependencyInjection\ContainerInterface;

class PageExtension extends \Twig_Extension
{
    private $container;
    private $pageManager;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->pageManager = $this->container->get('msi_page.page_manager');
    }

    public function getGlobals()
    {
        $route = $this->container->get('request')->attributes->get('_route');

        // if ($this->container->get('msi_page.decorate_strategy')->isRouteDecorable($route)) {
        //     $page = $this->pageManager->findByRoute($route);
        // } else {
        //     $page = $this->pageManager->findOneOrCreate();
        // }

        // if (!$page) {
        //     throw new NotFoundHttpException('Route "'.$route.'" is decorable but no page was found. Try to run app/console msi:page:update or manually create the page.');
        // }

        $page = $this->pageManager->findByRoute($route);
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
