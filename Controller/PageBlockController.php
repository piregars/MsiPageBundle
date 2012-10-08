<?php

namespace Msi\Bundle\PageBundle\Controller;

use Symfony\Component\DependencyInjection\ContainerAware;
use Msi\Bundle\AdminBundle\Controller\AdminController as BaseController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

class PageBlockController extends BaseController
{
    public function newAction()
    {
        $this->check('create');

        if ($this->processForm()) {
            return new RedirectResponse($this->admin->genUrl('edit', array('id' => $this->admin->getObject()->getId())));
        }

        return $this->render('MsiAdminBundle:Admin:new.html.twig', array('form' => $this->admin->getForm()->createView()));
    }
}
