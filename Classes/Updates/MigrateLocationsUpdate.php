<?php

declare(strict_types=1);

namespace Pegasus\GoogleForJobs\Updates;

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Install\Updates\UpgradeWizardInterface;

/***
 *
 * This file is part of the "Google for Jobs" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2019 Michael Kunst <kunst@pega-sus.de>, PEGASUS Werbeagentur GmbH
 *
 ***/

class MigrateLocationsUpdate implements UpgradeWizardInterface
{
    /**
     * Return the identifier for this wizard
     * This should be the same string as used in the ext_localconf class registration
     *
     * @return string
     */
    public function getIdentifier(): string
    {
        return 'migrateLocationsUpdate';
    }

    /**
     * Return the speaking name of this wizard
     *
     * @return string
     */
    public function getTitle(): string
    {
        return 'Google For Jobs: migrate locations into seperate table';
    }

    /**
     * Return the description for this wizard
     *
     * @return string
     */
    public function getDescription(): string
    {
        return 'This wizard migrates the job location data from the job records to a dedicated table. This is nessecary, because job locations are now separate objects';
    }

    /**
     * Execute the update
     *
     * Called when a wizard reports that an update is necessary
     *
     * @return bool
     */
    public function executeUpdate(): bool
    {
        $migrationSuccessful = $this->migrateLocationsIntoLocationTable();

        return $migrationSuccessful;
    }

    /**
     * Is an update necessary?
     *
     * Is used to determine whether a wizard needs to be run.
     * Check if data for migration exists.
     *
     * @return bool
     */
    public function updateNecessary(): bool
    {
        $updateNecessary = false;

        /** @var ConnectionPool $connectionPool */
        $connectionPool = GeneralUtility::makeInstance(ConnectionPool::class);
        $connection = $connectionPool->getConnectionByName('Default');
        
        // check if location table exists
        if ($connection->getSchemaManager()->tablesExist('tx_googleforjobs_domain_model_joblocation')) {
            $connection = $connectionPool->getConnectionForTable('tx_googleforjobs_domain_model_joblocation');
            $query = $connection->createQueryBuilder();
            $query = $query->select('*')->from('tx_googleforjobs_domain_model_joblocation');
            $result = $query->execute();

            //check if joblocation table is empty
            if ($result->fetch() === false) {
                $connection = $connectionPool->getConnectionForTable('tx_googleforjobs_domain_model_job');
                $query = $connection->createQueryBuilder();
                $query = $query->select('*')->from('tx_googleforjobs_domain_model_job');
                $result = $query->execute();

                // check if job records exist
                if ($result->fetch()) {
                    $updateNecessary = true;
                }
            }
        }
        return $updateNecessary;
    }

    /**
     * Returns an array of class names of prerequisite classes
     *
     * This way a wizard can define dependencies like "database up-to-date" or
     * "reference index updated"
     *
     * @return string[]
     */
    public function getPrerequisites(): array
    {
        return [];
    }

    /**
     * Reads all jobs, then extracts location data and writes them into the
     * location table and sets relation between jobs and locations.
     *
     * @return bool
     */
    protected function migrateLocationsIntoLocationTable(): bool
    {
        /** @var ConnectionPool $connectionPool */
        $connectionPool = GeneralUtility::makeInstance(ConnectionPool::class);
        $connectionJoblocations = $connectionPool->getConnectionForTable('tx_googleforjobs_domain_model_joblocation');
        $connectionJoblocationsMM = $connectionPool->getConnectionForTable('tx_googleforjobs_domain_model_job_joblocation_mm');

        $jobs =  $this->getJobData();

        foreach ($jobs as $job) {
            // get location data for database insertion
            $identifiers = [
                'street_address' => $job['job_location_street_address'],
                'city' => $job['job_location_city'],
                'postal_code' => $job['job_location_postal_code'],
                'region' => $job['job_location_region'],
                'country' => $job['job_location_country']
            ];
            $joblocation = $identifiers;
            $joblocation['pid'] = $job['pid'];
            
            // check if location doesn't already exist and write it into location table
            $locationExists = false;
            $locationExists = $connectionJoblocations->select(['uid'], 'tx_googleforjobs_domain_model_joblocation', $identifiers)->fetchAll();
            if (!$locationExists) {
                $connectionJoblocations->insert('tx_googleforjobs_domain_model_joblocation', $joblocation);
            }

            // set mn relation
            $locationUid = $connectionJoblocations->select(['uid'], 'tx_googleforjobs_domain_model_joblocation', $identifiers)->fetch();
            $connectionJoblocationsMM->insert(
                'tx_googleforjobs_domain_model_job_joblocation_mm',
                ['uid_local' => $locationUid['uid'], 'uid_foreign' => $job['uid'],
                'sorting_foreign' => 1]
            );
        }
            
        return true;
    }

    /**
     * Connects to jobs table and returns all jobs (incl. hidden, deleted)
     * as array.
     *
     * @return array Returns all jobs (incl. hidden, deleted)
     * as array.
     */
    protected function getJobData(): array
    {
        /** @var ConnectionPool $connectionPool */
        $connectionPool = GeneralUtility::makeInstance(ConnectionPool::class);
        $connectionJobs = $connectionPool->getConnectionForTable('tx_googleforjobs_domain_model_job');

        $queryBuilder = $connectionJobs->createQueryBuilder();
        $queryBuilder->getRestrictions()->removeAll();
        
        $jobs =  $queryBuilder->select('*')
            ->from('tx_googleforjobs_domain_model_job')
            ->orderBy('uid')
            ->execute()
            ->fetchAll();
        
        return $jobs;
    }
}
