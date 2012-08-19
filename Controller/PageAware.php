<?php

namespace Msi\Bundle\PageBundle\Controller;

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\Response;

class PageAware extends ContainerAware
{
    public function renderResponse($view, array $parameters = array(), Response $response = null)
    {
        $page = $this->container->get('msi_page.page_manager')->findByRoute($this->container->get('request')->attributes->get('_route'));
        if (!$page) {
            $page = $this->container->get('msi_page.page_manager')->findOneOrCreate();
        }
        $parameters['page'] = $page;

        return $this->container->get('templating')->renderResponse($view, $parameters, $response);
    }
}
