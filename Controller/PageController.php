<?php

namespace Msi\Bundle\PageBundle\Controller;

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PageController extends ContainerAware
{
    public function showAction()
    {
        $slug = $this->container->get('request')->attributes->get('slug');
        $criteria = array('a.enabled' => true);
        $join = array('a.blocks' => 'b');

        if ($slug) {
            $criteria['t.slug'] = $slug;
            $join['a.translations'] = 't';
        } else {
            $criteria['a.home'] = true;
        }
        $qb = $this->container->get('msi_page_page_admin')->getObjectManager()->findBy($criteria, $join, array('b.position' => 'ASC'));

        $qb->andWhere($qb->expr()->isNull('a.route'));

        $page = $qb->getQuery()->getResult();

        if (!isset($page[0])) {
            throw new NotFoundHttpException();
        }

        $page = $page[0];

        return $this->container->get('templating')->renderResponse($page->getTemplate(), array('page' => $page));
    }
}
