<?php

declare(strict_types=1);

namespace Pegasus\GoogleForJobs\Tests\Functional\Updates;

use Pegasus\GoogleForJobs\Updates\MigrateLocationsUpdate;
use PHPUnit\Framework\Attributes\Test;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

final class MigrateLocationsUpdateTest extends FunctionalTestCase
{
    protected array $coreExtensionsToLoad = [
        'install',
    ];

    protected array $testExtensionsToLoad = [
        'pegasus/google-for-jobs',
        __DIR__ . '/../Fixtures/Extensions/legacy_schema',
    ];

    #[Test]
    public function updateIsNotNecessaryWithoutLegacyData(): void
    {
        self::assertFalse($this->get(MigrateLocationsUpdate::class)->updateNecessary());
    }

    #[Test]
    public function locationsOfVersionOneAreMigrated(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/LegacyLocations.csv');
        $subject = $this->get(MigrateLocationsUpdate::class);

        self::assertTrue($subject->updateNecessary());
        self::assertTrue($subject->executeUpdate());
        self::assertFalse($subject->updateNecessary());

        $connectionPool = $this->get(ConnectionPool::class);
        $locations = $connectionPool->getConnectionForTable('tx_googleforjobs_domain_model_joblocation')
            ->select(['uid', 'pid', 'street_address', 'city', 'postal_code', 'region', 'country', 'jobs'], 'tx_googleforjobs_domain_model_joblocation', [], [], ['uid' => 'ASC'])
            ->fetchAllAssociative();
        $relations = $connectionPool->getConnectionForTable('tx_googleforjobs_domain_model_job_joblocation_mm')
            ->select(['uid_local', 'uid_foreign'], 'tx_googleforjobs_domain_model_job_joblocation_mm', [], [], ['uid_foreign' => 'ASC'])
            ->fetchAllAssociative();
        $queryBuilder = $connectionPool->getQueryBuilderForTable('tx_googleforjobs_domain_model_job');
        $queryBuilder->getRestrictions()->removeAll();
        $counters = $queryBuilder->select('uid', 'job_locations')
            ->from('tx_googleforjobs_domain_model_job')
            ->orderBy('uid')
            ->executeQuery()
            ->fetchAllKeyValue();

        self::assertCount(2, $locations, 'Identical addresses on the same page share one location');
        self::assertSame(['Berlin', 'Hamburg'], array_column($locations, 'city'));
        self::assertSame([10, 20], array_map('intval', array_column($locations, 'pid')));
        self::assertSame([2, 1], array_map('intval', array_column($locations, 'jobs')));
        self::assertSame(
            [[1, 1], [1, 2], [2, 4]],
            array_map(static fn(array $row): array => [(int)$row['uid_local'], (int)$row['uid_foreign']], $relations),
        );
        self::assertSame([1 => 1, 2 => 1, 3 => 0, 4 => 1], array_map('intval', $counters));
    }
}
