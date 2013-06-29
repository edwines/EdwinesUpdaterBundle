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

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('edwines_updater');

        $rootNode
            ->children()
                ->scalarNode('repo_path')->defaultValue(false)->end()
                ->scalarNode('executable_path')->defaultValue('/usr/bin/git')->end()
                ->scalarNode('provider')->defaultValue('Edwines\UpdaterBundle\Provider\GitHub')->end()
            ->end();

        return $treeBuilder;
    }
}
