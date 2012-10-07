<?php

namespace Msi\Bundle\PageBundle\Entity;

use Msi\Bundle\AdminBundle\Entity\BaseManager;
use Doctrine\ORM\QueryBuilder;
use Msi\Bundle\AdminBundle\Admin\Admin;

class PageBlockManager extends BaseManager
{
    protected function configureAdminListQuery(QueryBuilder $qb, Admin $admin)
    {
        $qb->andWhere('a.isSuperAdmin = true');
    }
}
