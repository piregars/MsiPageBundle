<?php

namespace Msi\Bundle\PageBundle\Admin;

use Msi\Bundle\AdminBundle\Admin\Admin;

class BlockAdmin extends Admin
{
    public function configure()
    {
        $this->setSearchFields(array('type'));
    }

    public function configureTable($builder)
    {
        $builder
            ->add('enabled', 'bool')
            ->add('setting.name', 'text', array('label' => 'name'))
            ->add('type')
            ->add('updatedAt', 'date')
            ->add('id')
            ->add('', 'action')
        ;
    }

    public function configureForm($builder)
    {
        $builder
            ->add('type', 'choice', array(
                'choices' => array(
                    'msi_block.text.block.type' => 'Text',
                    'msi_block.action.block.type' => 'Action',
                    'msi_block.template.block.type' => 'Template',
                ),
            ))
        ;

        if ($this->getObject()->getType()) {
            $type = $this->getContainer()->get($this->getObject()->getType());
            $type->buildForm($builder);
        }
    }
}
