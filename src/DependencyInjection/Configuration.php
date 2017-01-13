<?php

namespace SamJ\JWTBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
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
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('samj_jwt');

        $this->addKeysSection($rootNode);

        return $treeBuilder;
    }

    /**
     * Adds the configuration for the "keys" key.
     */
    private function addKeysSection(ArrayNodeDefinition $rootNode)
    {
        $rootNode
            ->cannotBeEmpty()
            ->isRequired()
            ->fixXmlConfig('key')
            ->children()
            ->arrayNode('keys')
                ->isRequired()
                ->cannotBeEmpty()
                ->prototype('scalar')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
        ;
    }
}
