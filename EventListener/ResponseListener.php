<?php

namespace Msi\Bundle\PageBundle\EventListener;

use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;

class ResponseListener
{
    protected $templating;
    protected $pagePool;

    public function __construct(EngineInterface $templating, $pagePool)
    {
        $this->templating = $templating;
        $this->pagePool = $pagePool;
    }

    public function onKernelResponse(FilterResponseEvent $event)
    {
        $response = $event->getResponse();
        $page = $this->pagePool->getPage();

        if (null === $page) return;

        $this->templating->renderResponse($page->getTemplate(), array('page' => $page, 'content' => $response->getContent()), $response);
    }
}
