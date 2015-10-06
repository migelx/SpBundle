<?php

namespace LightSaml\SpBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

class LightSamlSpExtension extends Extension
{
    /**
     * Loads a specific configuration.
     *
     * @param array            $config An array of configuration values
     * @param ContainerBuilder $container A ContainerBuilder instance
     *
     * @throws \InvalidArgumentException When provided tag is not defined in this extension
     *
     * @api
     */
    public function load(array $config, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $config);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('security.yml');
        $loader->load('services.yml');

        $this->configureSimpleUsernameMapper($config, $container);
    }

    private function configureSimpleUsernameMapper(array $config, ContainerBuilder $container)
    {
        $definition = $container->getDefinition('light_saml_sp.username_mapper.simple');
        $definition->replaceArgument(0, $config['username_mapper']);
    }
}
