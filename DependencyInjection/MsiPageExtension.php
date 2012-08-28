<?php

namespace Msi\Bundle\PageBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class MsiPageExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        $this->registerConfiguration($config, $container);
    }

    private function registerConfiguration($config, ContainerBuilder $container)
    {
        $container->setParameter('msi_page.template_choices', $config['templates']);
        $container->setParameter('msi_page.route_whitelist', $config['route_whitelist']);
        $container->setParameter('msi_page.route_whitelist_patterns', $config['route_whitelist_patterns']);
        $container->setParameter('msi_page.route_blacklist', $config['route_blacklist']);
        $container->setParameter('msi_page.route_blacklist_patterns', $config['route_blacklist_patterns']);
    }
}
