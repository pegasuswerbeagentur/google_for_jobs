<?php

declare(strict_types=1);

namespace Pegasus\GoogleForJobs\Tests\Functional\Configuration;

use PHPUnit\Framework\Attributes\Test;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

final class ConfigurationTest extends FunctionalTestCase
{
    protected array $testExtensionsToLoad = [
        'pegasus/google-for-jobs',
    ];

    #[Test]
    public function pluginIsRegisteredAsContentElement(): void
    {
        $contentTypes = array_column($GLOBALS['TCA']['tt_content']['columns']['CType']['config']['items'], 'value');

        self::assertContains('googleforjobs_job', $contentTypes);
        self::assertArrayHasKey('googleforjobs_job', $GLOBALS['TCA']['tt_content']['types']);
        $showItem = $GLOBALS['TCA']['tt_content']['types']['googleforjobs_job']['showitem'];
        self::assertMatchesRegularExpression('/pi_flexform,\\s*pages,\\s*recursive/', $showItem);
    }

    #[Test]
    public function flexFormIsAssignedToPlugin(): void
    {
        $dataStructure = $GLOBALS['TCA']['tt_content']['types']['googleforjobs_job']['columnsOverrides']['pi_flexform']['config']['ds']
            ?? $GLOBALS['TCA']['tt_content']['columns']['pi_flexform']['config']['ds']['*,googleforjobs_job']
            ?? '';

        self::assertSame('FILE:EXT:google_for_jobs/Configuration/FlexForms/flexform_job.xml', $dataStructure);

        $xml = (string)file_get_contents(GeneralUtility::getFileAbsFileName(substr($dataStructure, 5)));
        self::assertStringContainsString('<settings.job.renderType>', $xml);
    }

    #[Test]
    public function jobTablesMayBeStoredOnStandardPages(): void
    {
        self::assertTrue($GLOBALS['TCA']['tx_googleforjobs_domain_model_job']['ctrl']['security']['ignorePageTypeRestriction']);
        self::assertTrue($GLOBALS['TCA']['tx_googleforjobs_domain_model_joblocation']['ctrl']['security']['ignorePageTypeRestriction']);
    }

    #[Test]
    public function systemColumnsAreAvailableForJobTables(): void
    {
        foreach (['tx_googleforjobs_domain_model_job', 'tx_googleforjobs_domain_model_joblocation'] as $table) {
            foreach (['sys_language_uid', 'l10n_parent', 'hidden', 'starttime', 'endtime'] as $column) {
                self::assertArrayHasKey($column, $GLOBALS['TCA'][$table]['columns'], $table . '.' . $column);
            }
        }
    }
}
