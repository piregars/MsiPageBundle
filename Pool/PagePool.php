<?php

namespace Msi\Bundle\PageBundle\Pool;

class PagePool
{
    private $page = null;

    public function getPage()
    {
        return $this->page;
    }

    public function setPage($page)
    {
        $this->page = $page;

        return $this;
    }
}
