<?php

namespace Dopamine\MdashBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\DefinitionDecorator;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class DopamineMdashExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.xml');

        if (!isset($config['configs']['default'])) {
            $config['configs']['default'] = array();
        }

        $this->configureTypographServices($config['configs'], $container);
    }

    private function configureTypographServices($configs, ContainerBuilder $container)
    {
        foreach ($configs as $configName => $configOptions) {
            $baseDefinition = new DefinitionDecorator('dopamine_mdash.prototype.typograph');

            $serviceOptions = array();
            foreach ($configOptions as $optionName => $optionValue) {
                if (!empty($optionValue)) {
                    $serviceOptions[ Configuration::configOptionNameToMdash($optionName) ] = $optionValue;
                }
            }
            $baseDefinition->addMethodCall('setup', $serviceOptions);

            $serviceName = "dopamine_mdash.typograph." . $configName;
            $container->setDefinition($serviceName, $baseDefinition);
        }
    }
}
