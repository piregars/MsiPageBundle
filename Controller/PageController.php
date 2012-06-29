<?php

namespace Msi\Bundle\PageBundle\Controller;

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class PageController extends ContainerAware
{
    /**
     * @Route("/page/{slug}.html")
     * @Template()
     */
    public function showAction()
    {
        $slug = $this->container->get('request')->attributes->get('slug');
        $page = $this->container->get('msi_page_page_admin')->getModelManager()->findBy(array('a.slug' => $slug))->getQuery()->getSingleResult();

        return array('page' => $page);
    }
}
