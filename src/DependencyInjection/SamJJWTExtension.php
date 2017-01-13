<?php

namespace SamJ\JWTBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\DefinitionDecorator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

class SamJJWTExtension extends Extension
{
    const PROTOTYPE_SERVICE_NAME = 'samj_jwt.manager.prototype';

    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        foreach ($config['keys'] as $name => $jwtKey) {
            $definition = new DefinitionDecorator(self::PROTOTYPE_SERVICE_NAME);
            $definition->replaceArgument(0, $jwtKey);
            $container->setDefinition(sprintf('samj_jwt.manager.%s', $name), $definition);
        }
    }
}
