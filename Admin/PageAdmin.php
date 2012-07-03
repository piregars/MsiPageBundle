<?php

namespace Msi\Bundle\PageBundle\Admin;

use Msi\Bundle\AdminBundle\Admin\Admin;
use Msi\Bundle\PageBundle\Form\Type\PageTranslationType;

class PageAdmin extends Admin
{
    public function buildTable($builder)
    {
        $builder
            ->add('id')
            ->add('enabled', 'logical')
            ->add('title')
            ->add('slug')
            ->add('updatedAt', 'date')
            ->add('', 'action')
        ;
    }

    public function buildForm($builder)
    {
        $builder
            ->add('template')
            ->add('layout')
            ->add('css', 'textarea')
            ->add('js', 'textarea')
            ->add('translations', 'collection', array('attr' => array('class' => 'lead bold'), 'type' => new PageTranslationType(), 'options' => array(
                'attr' => array('class' => 'lead bold'),
            )));
        ;
    }
}
