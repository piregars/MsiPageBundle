<?php

namespace Msi\Bundle\PageBundle\Admin;

use Msi\Bundle\AdminBundle\Admin\Admin;

class PageBlockAdmin extends Admin
{
    public function configure()
    {
        $this->likeFields = array('type');
    }

    public function buildIndexTable($builder)
    {
        $builder
            ->add('id')
            ->add('enabled', 'boolean')
            ->add('setting.name', 'text', array('label' => 'position'))
            ->add('type')
            ->add('updatedAt', 'date')
            ->add('', 'action')
        ;
    }

    public function buildForm($builder)
    {
        $builder->add('name');

        $typeId = $this->getEntity()->getType();
        if ($typeId) {
            $blockType = $this->container->get($typeId);
            $blockType->buildForm($builder);
        } else {
            $builder
                ->add('type', 'choice', array(
                    'choices' => array(
                        'msi_block.block.text.type' => 'Text',
                        'msi_block.block.action.type' => 'Action',
                        'msi_block.block.template.type' => 'Template',
                    ),
                ))
            ;
        }
    }
}
