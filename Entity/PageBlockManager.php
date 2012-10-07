<?php

namespace Msi\Bundle\PageBundle\Entity;

use Msi\Bundle\AdminBundle\Entity\BaseManager;
use Doctrine\ORM\QueryBuilder;
use Msi\Bundle\AdminBundle\Admin\Admin;

class PageBlockManager extends BaseManager
{
    protected function configureAdminListQuery(QueryBuilder $qb, Admin $admin)
    {
        if (!$admin->getContainer()->get('security.context')->isGranted('ROLE_SUPER_ADMIN')) {
            $qb->andWhere('a.isSuperAdmin = false');
        }
    }
}
