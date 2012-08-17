<?php

namespace Msi\Bundle\PageBundle\Controller;

use Msi\Bundle\AdminBundle\Controller\AdminController;

class PageBlockController extends AdminController
{
    protected function configureJoins(&$joins)
    {
        $joins['a.pages'] = 'pcfrfrb';
    }
}
