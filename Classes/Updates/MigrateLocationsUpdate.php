<?php

declare(strict_types=1);

namespace Pegasus\GoogleForJobs\Updates;

use Pegasus\GoogleForJobs\Compatibility\UpgradeWizardInterface;
use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;

/*
 * This file is part of the "Google for Jobs" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

/**
 * Moves the address data stored directly in job records (version 1.x)
 * into job location records and relates them to the jobs.
 *
 * The class name is kept from version 2.x, so installations that already
 * executed this wizard keep it marked as done.
 */
final class MigrateLocationsUpdate implements UpgradeWizardInterface
{
    public const IDENTIFIER = 'migrateLocationsUpdate';

    private const JOB_TABLE = 'tx_googleforjobs_domain_model_job';
    private const LOCATION_TABLE = 'tx_googleforjobs_domain_model_joblocation';
    private const RELATION_TABLE = 'tx_googleforjobs_domain_model_job_joblocation_mm';

    /**
     * Address columns of version 1.x mapped to the columns of the location table.
     */
    private const LEGACY_COLUMNS = [
        'job_location_street_address' => 'street_address',
        'job_location_city' => 'city',
        'job_location_postal_code' => 'postal_code',
        'job_location_region' => 'region',
        'job_location_country' => 'country',
    ];

    public function __construct(
        private readonly ConnectionPool $connectionPool,
    ) {}

    public function getTitle(): string
    {
        return 'Google for Jobs: Migrate job locations of version 1.x';
    }

    public function getDescription(): string
    {
        return 'Moves the address data stored in job records of version 1.x into separate job location records. '
            . 'Run this wizard before removing unused database columns.';
    }

    public function getPrerequisites(): array
    {
        return [];
    }

    public function updateNecessary(): bool
    {
        if (!$this->legacyColumnsExist()) {
            return false;
        }
        return $this->countRows(self::LOCATION_TABLE) === 0 && $this->getJobsWithLegacyAddress() !== [];
    }

    public function executeUpdate(): bool
    {
        $locationConnection = $this->connectionPool->getConnectionForTable(self::LOCATION_TABLE);
        $relationConnection = $this->connectionPool->getConnectionForTable(self::RELATION_TABLE);
        $jobConnection = $this->connectionPool->getConnectionForTable(self::JOB_TABLE);
        $locationUsage = [];

        foreach ($this->getJobsWithLegacyAddress() as $job) {
            $address = [];
            foreach (self::LEGACY_COLUMNS as $legacyColumn => $column) {
                $address[$column] = (string)($job[$legacyColumn] ?? '');
            }

            $locationUid = $locationConnection->select(['uid'], self::LOCATION_TABLE, $address + ['pid' => (int)$job['pid']])
                ->fetchOne();
            if ($locationUid === false) {
                $locationConnection->insert(self::LOCATION_TABLE, $address + [
                    'pid' => (int)$job['pid'],
                    'tstamp' => time(),
                    'crdate' => time(),
                ]);
                $locationUid = (int)$locationConnection->lastInsertId();
            }
            $locationUid = (int)$locationUid;
            $locationUsage[$locationUid] = ($locationUsage[$locationUid] ?? 0) + 1;

            // The job record is the opposite side of the relation: uid_local is the location.
            $relationConnection->insert(self::RELATION_TABLE, [
                'uid_local' => $locationUid,
                'uid_foreign' => (int)$job['uid'],
                'sorting' => $locationUsage[$locationUid],
                'sorting_foreign' => 1,
            ]);
            $jobConnection->update(self::JOB_TABLE, ['job_locations' => 1], ['uid' => (int)$job['uid']]);
        }

        foreach ($locationUsage as $locationUid => $usage) {
            $locationConnection->update(self::LOCATION_TABLE, ['jobs' => $usage], ['uid' => $locationUid]);
        }

        return true;
    }

    private function legacyColumnsExist(): bool
    {
        $connection = $this->connectionPool->getConnectionForTable(self::JOB_TABLE);
        $schemaManager = $connection->createSchemaManager();
        if (!$schemaManager->tablesExist([self::JOB_TABLE, self::LOCATION_TABLE, self::RELATION_TABLE])) {
            return false;
        }
        $columns = array_change_key_case($schemaManager->listTableColumns(self::JOB_TABLE), CASE_LOWER);
        foreach (array_keys(self::LEGACY_COLUMNS) as $legacyColumn) {
            if (!isset($columns[$legacyColumn])) {
                return false;
            }
        }
        return true;
    }

    /**
     * All jobs including hidden and deleted ones, so a later restore keeps its location.
     *
     * @return list<array<string, mixed>>
     */
    private function getJobsWithLegacyAddress(): array
    {
        $queryBuilder = $this->connectionPool->getQueryBuilderForTable(self::JOB_TABLE);
        $queryBuilder->getRestrictions()->removeAll();
        $hasAddress = [];
        foreach (array_keys(self::LEGACY_COLUMNS) as $legacyColumn) {
            $hasAddress[] = $queryBuilder->expr()->neq($legacyColumn, $queryBuilder->createNamedParameter('', Connection::PARAM_STR));
        }

        return $queryBuilder
            ->select('uid', 'pid', ...array_keys(self::LEGACY_COLUMNS))
            ->from(self::JOB_TABLE)
            ->where($queryBuilder->expr()->or(...$hasAddress))
            ->orderBy('uid')
            ->executeQuery()
            ->fetchAllAssociative();
    }

    private function countRows(string $table): int
    {
        $queryBuilder = $this->connectionPool->getQueryBuilderForTable($table);
        $queryBuilder->getRestrictions()->removeAll();
        return (int)$queryBuilder->count('uid')->from($table)->executeQuery()->fetchOne();
    }
}
