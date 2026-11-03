<?php

declare(strict_types=1);

namespace Pegasus\GoogleForJobs\Tests\Functional\Configuration;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use TYPO3\CMS\Backend\Form\FormDataCompiler;
use TYPO3\CMS\Backend\Form\FormDataGroup\TcaDatabaseRecord;
use TYPO3\CMS\Core\Core\SystemEnvironmentBuilder;
use TYPO3\CMS\Core\Http\ServerRequest;
use TYPO3\CMS\Core\Localization\LanguageServiceFactory;
use TYPO3\CMS\Core\Messaging\FlashMessageService;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

final class BackendFormTest extends FunctionalTestCase
{
    protected array $testExtensionsToLoad = [
        'pegasus/google-for-jobs',
    ];

    protected function setUp(): void
    {
        parent::setUp();
        $this->importCSVDataSet(__DIR__ . '/Fixtures/BackendForm.csv');
        $backendUser = $this->setUpBackendUser(1);
        $GLOBALS['LANG'] = $this->get(LanguageServiceFactory::class)->createFromUserPreferences($backendUser);
    }

    public static function recordDataProvider(): \Generator
    {
        yield 'job' => ['tx_googleforjobs_domain_model_job', 'job_locations', ['Hauptstraße 1', 'Beispielweg 5']];
        yield 'job location' => ['tx_googleforjobs_domain_model_joblocation', 'jobs', ['Software Engineer']];
    }

    /**
     * @param list<string> $expectedLabels
     */
    #[Test]
    #[DataProvider('recordDataProvider')]
    public function existingRecordCanBeOpenedInBackendForm(string $table, string $relationField, array $expectedLabels): void
    {
        $request = (new ServerRequest('https://example.com/typo3/'))
            ->withAttribute('applicationType', SystemEnvironmentBuilder::REQUESTTYPE_BE);

        $result = $this->get(FormDataCompiler::class)->compile([
            'request' => $request,
            'tableName' => $table,
            'vanillaUid' => 1,
            'command' => 'edit',
        ], $this->get(TcaDatabaseRecord::class));

        $messages = $this->get(FlashMessageService::class)->getMessageQueueByIdentifier()->getAllMessagesAndFlush();
        self::assertSame([], array_map(static fn($message): string => $message->getMessage(), $messages));

        $labels = array_column($result['processedTca']['columns'][$relationField]['config']['items'], 'label');
        foreach ($expectedLabels as $expectedLabel) {
            self::assertStringContainsString($expectedLabel, implode('|', $labels));
        }
    }
}
