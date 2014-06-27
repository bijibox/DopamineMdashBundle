<?php

namespace Dopamine\MdashBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\NodeBuilder;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('dopamine_mdash');

        $configPrototype = $rootNode
            ->children()
                ->arrayNode('configs')
                    ->prototype('array')
                        ->children();

        $this->buildConfigPrototype($configPrototype);

        return $treeBuilder;
    }

    private function buildConfigPrototype(NodeBuilder $configPrototype)
    {
        $typographOptions = $this->getTypographOptions();

        foreach ($typographOptions['all'] as $optionName => $optionData) {
            $configPrototype
                ->scalarNode(self::mdashOptionNameToConfig($optionName))
                ->info(
                    $optionData['description'] .
                    (empty($optionData['disabled']) ? '' : ' *по умолчанию отключено')
                )
                ->defaultNull()
                ->treatTrueLike('on')
                ->treatFalseLike('off')
                ->validate()
                    ->ifNotInArray([null, 'on', 'off'])
                        ->thenInvalid('"on" (true), "off" (false) or null for default is allowed')
                    ->end()
                ->end();
        }
    }

    private function getTypographOptions()
    {
        $typograph = new \EMTypograph();
        return $typograph->get_options_list();
    }

    public static function mdashOptionNameToConfig($optionName)
    {
        return str_replace('.', '__', $optionName);
    }

    public static function configOptionNameToMdash($optionName)
    {
        return str_replace('__', '.', $optionName);
    }
}
