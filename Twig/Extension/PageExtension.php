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
        // fetch the decorator page

        $route = $this->container->get('request')->attributes->get('_route');

        if ($this->routeIsValid($route)) {
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

    protected function routeIsValid($route)
    {
        if (!$this->checkWhitelist($route)) {
            return false;
        }

        if (!$this->checkWhitelistPattern($route)) {
            return false;
        }

        if (!$this->checkBlacklist($route)) {
            return false;
        }

        if (!$this->checkBlacklistPattern($route)) {
            return false;
        }

        return true;
    }

    protected function checkWhitelist($name)
    {
        $whitelist = $this->container->getParameter('msi_page.route_whitelist');
        if (empty($whitelist) || in_array($name, $whitelist)) {
            return true;
        }

        return false;
    }

    protected function checkWhitelistPattern($name)
    {
        $whitelistPattern = $this->container->getParameter('msi_page.route_whitelist_pattern');

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
        $blacklist = $this->container->getParameter('msi_page.route_blacklist');
        if (empty($blacklist) || !in_array($name, $blacklist)) {
            return true;
        }

        return false;
    }

    protected function checkBlacklistPattern($name)
    {
        $blacklistPattern = $this->container->getParameter('msi_page.route_blacklist_pattern');

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
