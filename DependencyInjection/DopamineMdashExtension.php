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

        $typographOptions = $this->preProcessConfigs($config['configs']);

        $this->configureTypographServices($typographOptions, $container);
    }

    protected function preProcessConfigs($configs)
    {
        if (!isset($configs['default'])) {
            $configs['default'] = array();
        }

        $typographOptions = array();
        foreach ($configs as $configName => $options) {
            $typographOptions[$configName] = array();

            foreach ($options as $option => $value) {
                if (!empty($value)) {
                    $typographOptions[$configName][Configuration::configOptionNameToMdash($option)] = $value;
                }
            }
        }

        return $typographOptions;
    }

    private function configureTypographServices($typographOptions, ContainerBuilder $container)
    {
        foreach ($typographOptions as $configName => $options) {
            $baseDefinition = new DefinitionDecorator('dopamine_mdash.prototype.typograph');

            if (!empty($options)) {
                $baseDefinition->addMethodCall('setup', array($options));
            }

            $serviceName = "dopamine_mdash.typograph." . $configName;
            $container->setDefinition($serviceName, $baseDefinition);
        }
    }
}
