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

        try {
            if ($slug) {
                $page = $this->container->get('msi_page_page_admin')->getModelManager()->findBy(array('a.enabled' => true, 't.slug' => $slug), array('a.blocks' => 'b'), array('b.position' => 'ASC'))->getQuery()->getOneOrNullResult();
            } else {
                $page = $this->container->get('msi_page_page_admin')->getModelManager()->findBy(array('a.enabled' => true, 'a.home' => true), array('a.blocks' => 'b'), array('b.position' => 'ASC'))->getQuery()->getOneOrNullResult();
            }
        } catch (NonUniqueResultException $e) {

        }

        if (!$page) {
            throw new NotFoundHttpException();
        }

        return $this->container->get('templating')->renderResponse($page->getTemplate(), array('page' => $page));
    }
}
