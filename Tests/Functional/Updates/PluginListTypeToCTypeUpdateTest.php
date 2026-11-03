<?php

declare(strict_types=1);

namespace Pegasus\GoogleForJobs\Tests\Functional\Updates;

use Pegasus\GoogleForJobs\Updates\PluginListTypeToCTypeUpdate;
use PHPUnit\Framework\Attributes\Test;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

final class PluginListTypeToCTypeUpdateTest extends FunctionalTestCase
{
    protected array $coreExtensionsToLoad = [
        'install',
    ];

    protected array $testExtensionsToLoad = [
        'pegasus/google-for-jobs',
        __DIR__ . '/../Fixtures/Extensions/legacy_schema',
    ];

    protected function setUp(): void
    {
        parent::setUp();
        $this->importCSVDataSet(__DIR__ . '/Fixtures/PluginListType.csv');
    }

    #[Test]
    public function updateIsNecessaryForLegacyPlugins(): void
    {
        self::assertTrue($this->get(PluginListTypeToCTypeUpdate::class)->updateNecessary());
    }

    #[Test]
    public function pluginsAreMigratedWithoutLosingSettings(): void
    {
        $subject = $this->get(PluginListTypeToCTypeUpdate::class);

        self::assertTrue($subject->executeUpdate());
        self::assertFalse($subject->updateNecessary());

        $rows = $this->get(ConnectionPool::class)->getConnectionForTable('tt_content')
            ->select(['uid', 'CType', 'list_type', 'pi_flexform'], 'tt_content', [], [], ['uid' => 'ASC'])
            ->fetchAllAssociative();

        self::assertSame('googleforjobs_job', $rows[0]['CType']);
        self::assertSame('', $rows[0]['list_type']);
        self::assertStringContainsString('<value index="vDEF">show</value>', $rows[0]['pi_flexform']);
        self::assertSame('list', $rows[1]['CType'], 'Plugins of other extensions must stay untouched');
        self::assertSame('other_plugin', $rows[1]['list_type']);
        self::assertSame('text', $rows[2]['CType']);
    }

    #[Test]
    public function backendGroupPermissionsAreMigrated(): void
    {
        $this->get(PluginListTypeToCTypeUpdate::class)->executeUpdate();

        $permissions = $this->get(ConnectionPool::class)->getConnectionForTable('be_groups')
            ->select(['explicit_allowdeny'], 'be_groups', ['uid' => 1])
            ->fetchOne();

        self::assertStringContainsString('tt_content:CType:googleforjobs_job', $permissions);
        self::assertStringNotContainsString('list_type:googleforjobs_job', $permissions);
    }
}
