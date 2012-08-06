<?php

namespace Msi\Bundle\PageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

use Msi\Bundle\BlockBundle\Entity\Block as BaseBlock;

/**
 * @ORM\Table(name="page_block")
 * @ORM\Entity
 */
class PageBlock extends BaseBlock
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToMany(targetEntity="Page", mappedBy="blocks", cascade={"persist"})
     */
    protected $pages;

    public function __construct()
    {
        parent::__construct();
        $this->pages = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getPages()
    {
        return $this->pages;
    }

    public function setPages($pages)
    {
        $this->pages = $pages;

        return $this;
    }

    public function __toString()
    {
        return 'Block '.$this->id;
    }
}
