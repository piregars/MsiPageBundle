<?php

namespace Msi\Bundle\PageBundle\Controller;

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Doctrine\ORM\NonUniqueResultException;

class PageController extends ContainerAware
{
    public function showAction()
    {
        $slug = $this->container->get('request')->attributes->get('slug');
        $criteria = array('a.enabled' => true);

        if ($slug) {
            $criteria['t.slug'] = $slug;
        } else {
            $criteria['a.home'] = true;
        }
        $page = $this->container->get('msi_page_page_admin')->getObjectManager()->findBy($criteria, array('a.blocks' => 'b'), array('b.position' => 'ASC'))->getQuery()->getResult();

        if (!isset($page[0])) {
            throw new NotFoundHttpException();
        }

        $page = $page[0];

        return $this->container->get('templating')->renderResponse($page->getTemplate(), array('page' => $page));
    }
}
