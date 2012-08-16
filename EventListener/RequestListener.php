<?php

namespace Msi\Bundle\PageBundle\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\HttpKernel;

class RequestListener
{
    protected $pageManager;
    protected $pagePool;

    public function __construct($pageManager, $pagePool)
    {
        $this->pageManager = $pageManager;
        $this->pagePool = $pagePool;
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();

        if ($request->isXmlHttpRequest()) return;
        if (HttpKernel::MASTER_REQUEST != $event->getRequestType()) return;

        $page = $this->pageManager->findByRoute($request->attributes->get('_route'));
        $this->pagePool->setPage($page);
    }
}
