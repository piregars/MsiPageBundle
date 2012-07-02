<?php

namespace Msi\Bundle\PageBundle\Admin;

use Msi\Bundle\AdminBundle\Admin\Admin;
use Msi\Bundle\PageBundle\Form\Type\PageTranslationType;

class PageAdmin extends Admin
{
    // public function configure()
    // {
    //     $this->setLocales(array('fr', 'en'));
    // }

    public function configureTable($builder)
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
