<?php

namespace Composer\Installers\Test;

use Composer\Installers\EancmsInstaller;
use Composer\Package\Package;
use Composer\Composer;

class EancmsInstallerTest extends TestCase
{
    /**
     * @var EancmsInstaller
     */
    private $installer;

    public function setUp(): void
    {
        $this->installer = new EancmsInstaller(
            new Package('NyanCat', '4.2', '4.2'),
            $this->getComposer(),
            $this->getMockIO()
        );
    }

    /**
     * @dataProvider packageNameInflectionProvider
     */
    public function testInflectPackageVars(string $type, string $name, string $expected): void
    {
        $this->assertEquals(
            array('name' => $expected, 'type' => $type),
            $this->installer->inflectPackageVars(array('name' => $name, 'type' => $type))
        );
    }

    public function packageNameInflectionProvider(): array
    {
        return array(
            // Should keep module name StudlyCase
            array(
                'eancms-module',
                'user-profile',
                'UserProfile'
            ),
            array(
                'eancms-module',
                'eancms-module',
                'Eancms'
            ),
            array(
                'eancms-module',
                'blog',
                'Blog'
            ),
            // tests that exactly one '-module' is cut off
            array(
                'eancms-module',
                'some-module-module',
                'SomeModule',
            ),
        );
    }
}
