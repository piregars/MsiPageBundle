<?php

namespace Msi\Bundle\PageBundle\Admin;

use Msi\Bundle\AdminBundle\Admin\Admin;
use Msi\Bundle\PageBundle\Form\Type\PageTranslationType;

class PageAdmin extends Admin
{
    public function configure()
    {
        $this->setSearchFields(array('title'));
    }

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
            ->add('template', 'choice', array('choices' => $this->container->getParameter('msi_page.template_choices')))
            ->add('home', 'checkbox')
            ->add('css', 'textarea')
            ->add('js', 'textarea')
            ->add('translations', 'collection', array('attr' => array('class' => 'lead bold'), 'type' => new PageTranslationType(), 'options' => array(
                'label' => ' ',
            )));
        ;
    }
}
