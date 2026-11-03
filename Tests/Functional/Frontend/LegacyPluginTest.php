<?php

declare(strict_types=1);

namespace Pegasus\GoogleForJobs\Tests\Functional\Frontend;

use PHPUnit\Framework\Attributes\Test;
use TYPO3\CMS\Core\Information\Typo3Version;
use TYPO3\TestingFramework\Core\Functional\Framework\Frontend\InternalRequest;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

final class LegacyPluginTest extends FunctionalTestCase
{
    protected array $coreExtensionsToLoad = [
        'fluid_styled_content',
    ];

    protected array $testExtensionsToLoad = [
        'pegasus/google-for-jobs',
    ];

    protected function setUp(): void
    {
        parent::setUp();
        if ((new Typo3Version())->getMajorVersion() >= 14) {
            self::markTestSkipped('TYPO3 14 does not support "Insert plugin" content elements anymore.');
        }
        $this->importCSVDataSet(__DIR__ . '/Fixtures/LegacyPlugin.csv');
        $path = $this->instancePath . '/typo3conf/sites/main';
        @mkdir($path, 0o777, true);
        file_put_contents($path . '/config.yaml', <<<'YAML'
            rootPageId: 1
            base: 'https://example.com/'
            languages:
              -
                title: English
                enabled: true
                languageId: 0
                base: /
                locale: en_US.UTF-8
            YAML);
    }

    #[Test]
    public function pluginOfVersionTwoIsRenderedUntilItIsMigrated(): void
    {
        $response = $this->executeFrontendSubRequest(new InternalRequest('https://example.com/'));
        $body = (string)$response->getBody();

        self::assertSame(200, $response->getStatusCode());
        self::assertStringContainsString('Software Engineer', $body);
    }
}
