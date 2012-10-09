<?php

namespace Msi\Bundle\PageBundle\Entity;

use Msi\Bundle\AdminBundle\Entity\BaseManager;

class PageManager extends BaseManager
{
    public function findByRoute($route)
    {
        $page = $this->getFindByQueryBuilder(array('t.published' => true, 'a.route' => $route), array('a.translations' => 't', 'a.blocks' => 'b'), array('b.position' => 'ASC'))->getQuery()->getResult();

        if (!isset($page[0])) {
            $page = null;
        } else {
            $page = $page[0];
        }

        return $page;
    }
}
