<?php

namespace Msi\Bundle\PageBundle\Admin;

use Msi\Bundle\AdminBundle\Admin\Admin;

class BlockAdmin extends Admin
{
    public function configure()
    {
        $this->setSearchFields(array('type'));
    }

    public function configureDataTable($builder)
    {
        $builder
            ->add('enabled', 'bool')
            ->add('type')
            ->add('createdAt', 'date')
            ->add('', 'action')
        ;
    }

    public function configureForm($builder)
    {
        $builder
            ->add('type')
        ;
    }
}
