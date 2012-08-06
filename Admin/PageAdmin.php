<?php

namespace Msi\Bundle\PageBundle\Admin;

use Msi\Bundle\AdminBundle\Admin\Admin;
use Msi\Bundle\PageBundle\Form\Type\PageTranslationType;

class PageAdmin extends Admin
{
    public function configure()
    {
        $this->searchFields = array('title');
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
            ->add('home', 'checkbox', array())
            ->add('css', 'textarea')
            ->add('js', 'textarea')
            ->add('translations', 'collection', array('label' => ' ', 'type' => new PageTranslationType(), 'options' => array(
                'label' => ' ',
            )))
            ->add('blocks', 'entity', array('multiple' => true, 'class' => 'MsiPageBundle:PageBlock', 'attr' => array('class' => 'chosenify')))
        ;
    }

    public function buildFilterForm($builder)
    {
        $builder->add('blocks', 'entity', array(
            'multiple' => true,
            'class' => 'MsiPageBundle:PageBlock',
            'attr' => array('data-placeholder' => '-- '.$this->container->get('translator')->transchoice('entity.PageBlock', 2).' --', 'class' => 'chosenify'),
            'label' => ' ',
        ));
    }

}
