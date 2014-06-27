<?php
namespace Dopamine\MdashBundle\Tests\Twig;

use Dopamine\MdashBundle\Twig\MdashExtension;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;

class MdashExtensionTest extends \PHPUnit_Framework_TestCase
{
    const TYPOGRAPHED = 'Typographed!';

    public function testApplyDefaultTypograph()
    {
        $typographStub = $this->createTypographStub();
        $containerStub = $this->createContainerStub($typographStub, 'default');

        $mdashExtension = new MdashExtension($containerStub);

        $result = $mdashExtension->applyTypograph('stub_text');

        $this->assertEquals($result, self::TYPOGRAPHED);
    }

    public function testApplyNamedTypograph()
    {
        $typographStub = $this->createTypographStub();
        $containerStub = $this->createContainerStub($typographStub, 'title');

        $mdashExtension = new MdashExtension($containerStub);

        $result = $mdashExtension->applyTypograph('stub_text', 'title');

        $this->assertEquals($result, self::TYPOGRAPHED);
    }

    /**
     * @expectedException \Twig_Error_Runtime
     */
    public function testApplyNotExistsTypograph()
    {
        $serviceNotFoundException = new ServiceNotFoundException('dopamine_mdash.typograph.title');

        $containerStub = $this->getMock('Symfony\Component\DependencyInjection\Container');
        $containerStub->expects($this->any())
            ->method('get')
            ->willThrowException($serviceNotFoundException);

        $mdashExtension = new MdashExtension($containerStub);


        $mdashExtension->applyTypograph('stub_text', 'title');
    }

    protected function createTypographStub()
    {
        $typographStub = $this->getMock('EMTypograph');
        $typographStub->expects($this->once())
            ->method('set_text');
        $typographStub->expects($this->once())
            ->method('apply')
            ->willReturn(self::TYPOGRAPHED);
        return $typographStub;
    }

    protected function createContainerStub($typographStub, $configName)
    {
        $containerStub = $this->getMock('Symfony\Component\DependencyInjection\Container');
        $containerStub->expects($this->once())
            ->method('get')
            ->with('dopamine_mdash.typograph.' . $configName)
            ->willReturn($typographStub);
        return $containerStub;
    }
}
