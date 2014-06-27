<?php
namespace Dopamine\MdashBundle\Twig;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;

class MdashExtension extends \Twig_Extension
{
    /**
     * @var \Symfony\Component\DependencyInjection\ContainerInterface
     */
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('mdash', array($this, 'applyTypograph'), array(
                'is_safe' => array('html')
            )),
        );
    }

    /**
     * @param $text
     * @param string $config
     * @return string
     */
    public function applyTypograph($text, $config = 'default')
    {
        $typograph = $this->getTypograph($config);

        $typograph->set_text($text);

        return $typograph->apply();
    }

    /**
     * @param string $config
     * @throws \Twig_Error_Runtime
     * @return \EMTypograph
     */
    private function getTypograph($config)
    {
        try {
            return $this->container->get('dopamine_mdash.typograph.' . $config);
        } catch (ServiceNotFoundException $e) {
            throw new \Twig_Error_Runtime("Mdash typograph with config '$config' not found.");
        }
    }

    public function getName()
    {
        return 'mdash_extension';
    }
}