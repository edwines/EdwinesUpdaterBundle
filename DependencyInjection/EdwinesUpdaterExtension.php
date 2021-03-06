<?php

/**
 * This file is part of the EdwinesUpdaterBundle package.
 *
 * (c) Edwin Ibarra <edwines@feniaz.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Edwines\UpdaterBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class EdwinesUpdaterExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        if (!isset($config['repo_path'])) {
            throw new \InvalidArgumentException("The configuration node 'repo_path' is not set for EdwinesUpdaterBundle");
        }

        if (false == class_exists($config['provider'])) {
            throw new \InvalidArgumentException(sprintf("The provider class {%s} does not exists (EdwinesUpdaterBundle)", $config['provider']));
        }

        $providerInterface = 'Edwines\UpdaterBundle\Provider\ProviderInterface';

        if (!in_array($providerInterface, class_implements($config['provider']))) {
            throw new \InvalidArgumentException(sprintf("The provider class {%s} need to implements %s (EdwinesUpdaterBundle)", $config['provider'], $providerInterface));
        }

        $repoPath = $config['repo_path'] ?: $container->getParameter('kernel.root_dir').'/../';

        $container->setParameter('ed_updater.repo_path', $repoPath);
        $container->setParameter('ed_updater.executable_path', $config['executable_path']);
        $container->setParameter('ed_updater.provider.class', $config['provider']);
    }
}
