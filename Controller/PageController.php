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
     * @Route("/{_locale}/page/{slug}.html")
     */
    public function showAction()
    {
        $slug = $this->container->get('request')->attributes->get('slug');
        $page = $this->container->get('msi_page_page_admin')->getModelManager()->findBy(array('a.enabled' => true, 't.locale' => $this->container->get('session')->getLocale(), 't.slug' => $slug), array('a.translations' => 't'))->getQuery()->getSingleResult();

        $page->setLocale($this->container->get('session')->getLocale());

        return $this->container->get('templating')->renderResponse($page->getTemplate(), array('page' => $page));
    }
}
