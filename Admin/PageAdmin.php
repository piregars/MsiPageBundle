<?php

namespace Msi\Bundle\PageBundle\Admin;

use Msi\Bundle\AdminBundle\Admin\Admin;
use Msi\Bundle\PageBundle\Form\Type\PageTranslationType;

class PageAdmin extends Admin
{
    public function configure()
    {
        $this->likeFields = array('title');
    }

    public function buildIndexTable($builder)
    {
        $builder
            ->add('id')
            ->add('enabled', 'boolean')
            ->add('title')
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
            ->add('translations', 'collection', array('label' => ' ', 'type' => new PageTranslationType(), 'options' => array(
                'label' => ' ',
            )));
        ;
    }
}
