<?php

declare(strict_types=1);

namespace Pegasus\GoogleForJobs\Tests\Functional\Frontend;

use PHPUnit\Framework\Attributes\Test;
use TYPO3\TestingFramework\Core\Functional\Framework\Frontend\InternalRequest;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

final class JobPluginTest extends FunctionalTestCase
{
    protected array $testExtensionsToLoad = [
        'pegasus/google-for-jobs',
    ];

    protected array $configurationToUseInTestInstance = [
        'SYS' => [
            'encryptionKey' => '4408d27a916d51e624b69af3554f516dbab61037a9f7b9fd6f81b4d3bedeccb6',
        ],
        'FE' => [
            'cacheHash' => [
                'enforceValidation' => false,
            ],
        ],
    ];

    protected function setUp(): void
    {
        parent::setUp();
        $this->importCSVDataSet(__DIR__ . '/Fixtures/Pages.csv');
        $this->setUpFrontendRootPage(1, [
            'constants' => [
                'EXT:google_for_jobs/Configuration/TypoScript/constants.typoscript',
            ],
            'setup' => [
                'EXT:google_for_jobs/Configuration/TypoScript/setup.typoscript',
                'EXT:google_for_jobs/Tests/Functional/Frontend/Fixtures/Frontend.typoscript',
            ],
        ]);
        $this->writeSiteConfiguration();
    }

    private function writeSiteConfiguration(): void
    {
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
                navigationTitle: English
                flag: us
            routeEnhancers:
              JobsPlugin:
                type: Extbase
                extension: GoogleForJobs
                plugin: Job
                routes:
                  -
                    routePath: '/{job_title}'
                    _controller: 'Job::show'
                    _arguments:
                      job_title: job
                defaultController: 'Job::show'
                aspects:
                  job_title:
                    type: PersistedAliasMapper
                    tableName: tx_googleforjobs_domain_model_job
                    routeFieldName: path_segment
            YAML);
    }

    #[Test]
    public function listLinksToDetailPageWithoutAdditionalParameters(): void
    {
        $response = $this->executeFrontendSubRequest(new InternalRequest('https://example.com/'));
        $body = (string)$response->getBody();

        self::assertSame(200, $response->getStatusCode());
        self::assertStringContainsString('href="/job/software-engineer"', $body);
        self::assertStringNotContainsString('Expired Job', $body);
        self::assertStringNotContainsString('tx_googleforjobs_job%5Baction%5D', $body);
        self::assertStringNotContainsString('application/ld+json', $body);
    }

    #[Test]
    public function detailPageRendersJobAndStructuredData(): void
    {
        $response = $this->executeFrontendSubRequest(new InternalRequest('https://example.com/job/software-engineer'));
        $body = (string)$response->getBody();

        self::assertSame(200, $response->getStatusCode());
        self::assertStringContainsString('Software Engineer', $body);
        self::assertStringContainsString('Berlin', $body);
        self::assertMatchesRegularExpression('#<head>.*<script type="application/ld\+json">.*</script>.*</head>#s', $body);

        preg_match('#<script type="application/ld\+json">(.*?)</script>#s', $body, $matches);
        $data = json_decode($matches[1], true, 512, JSON_THROW_ON_ERROR);
        self::assertSame('JobPosting', $data['@type']);
        self::assertSame('<p>Build things &amp; ship them.</p><ul><li>PHP</li></ul>', $data['description']);
        self::assertSame('https://example.com/', $data['hiringOrganization']['sameAs']);
        self::assertSame('https://www.example.com/logo.png', $data['hiringOrganization']['logo']);
        self::assertSame(['FULL_TIME', 'PART_TIME'], $data['employmentType']);
        self::assertSame('Berlin', $data['jobLocation']['address']['addressLocality']);
        self::assertEquals(['@type' => 'QuantitativeValue', 'value' => 55000, 'unitText' => 'YEAR'], $data['baseSalary']['value']);
    }

    #[Test]
    public function expiredJobKeepsDetailPageAndSignalsExpiryToGoogle(): void
    {
        $response = $this->executeFrontendSubRequest(new InternalRequest('https://example.com/job/expired-job'));
        $body = (string)$response->getBody();

        self::assertSame(200, $response->getStatusCode());
        self::assertStringContainsString('"validThrough":"2020-06-30T23:59:59', $body);
        self::assertStringNotContainsString('"baseSalary"', $body);
    }

    #[Test]
    public function unknownJobResultsInPageNotFound(): void
    {
        $response = $this->executeFrontendSubRequest(new InternalRequest('https://example.com/job?tx_googleforjobs_job%5Bjob%5D=999&tx_googleforjobs_job%5Baction%5D=show&tx_googleforjobs_job%5Bcontroller%5D=Job'));

        self::assertSame(404, $response->getStatusCode());
    }

    #[Test]
    public function detailPageWithoutJobResultsInPageNotFound(): void
    {
        $response = $this->executeFrontendSubRequest(new InternalRequest('https://example.com/job'));

        self::assertSame(404, $response->getStatusCode());
    }
}
