<?php

namespace Msi\Bundle\PageBundle\Admin;

use Msi\Bundle\AdminBundle\Admin\Admin;

class PageAdmin extends Admin
{
    public function configure()
    {
        $this->setSearchFields(array('title'));
    }

    public function configureDataTable($builder)
    {
        $builder
            ->add('', 'action')
        ;
    }

    public function configureForm($builder)
    {
        $builder
            ->add('title')
        ;
    }
}
