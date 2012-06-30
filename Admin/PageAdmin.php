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
            ->add('enabled', 'bool')
            ->add('title')
            ->add('slug')
            ->add('createdAt', 'date')
            ->add('', 'action')
        ;
    }

    public function configureForm($builder)
    {
        $builder
            ->add('title')
            ->add('layout')
            ->add('metaKeywords', 'textarea')
            ->add('metaDescription', 'textarea')
        ;
    }
}
