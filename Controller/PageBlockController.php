<?php

namespace Msi\Bundle\PageBundle\Controller;

use Msi\Bundle\AdminBundle\Controller\CrudController as BaseController;

class PageBlockController extends BaseController
{
    protected function configureJoins(&$joins)
    {
        $joins['a.pages'] = 'pcfrfrb';
    }
}
