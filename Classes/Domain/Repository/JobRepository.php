<?php

declare(strict_types=1);

namespace Pegasus\GoogleForJobs\Domain\Repository;

use Pegasus\GoogleForJobs\Domain\Model\Job;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

/*
 * This file is part of the "Google for Jobs" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

/**
 * @extends Repository<Job>
 */
class JobRepository extends Repository
{
    /**
     * Order options of the plugin mapped to the property used for ordering.
     */
    private const ORDER_FIELDS = [
        'uid' => 'uid',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'date_posted' => 'datePosted',
        'title' => 'title',
    ];

    /**
     * @param list<int> $categoryUids
     * @return QueryResultInterface<int, Job>
     */
    public function findForList(
        array $categoryUids = [],
        string $categoryConjunction = '',
        bool $hideExpired = true,
        string $orderBy = '',
        string $orderDirection = '',
        ?\DateTimeInterface $now = null,
    ): QueryResultInterface {
        $query = $this->createQuery();
        $constraints = [];

        $categoryConstraint = $this->createCategoryConstraint($query, $categoryUids, $categoryConjunction);
        if ($categoryConstraint !== null) {
            $constraints[] = $categoryConstraint;
        }

        if ($hideExpired) {
            $today = \DateTime::createFromInterface($now ?? new \DateTimeImmutable())->setTime(0, 0);
            $constraints[] = $query->logicalOr(
                $query->equals('validThrough', null),
                $query->greaterThanOrEqual('validThrough', $today),
            );
        }

        if ($constraints !== []) {
            $query->matching($query->logicalAnd(...$constraints));
        }

        $query->setOrderings([
            self::ORDER_FIELDS[$orderBy] ?? 'uid' => strtolower($orderDirection) === 'desc'
                ? QueryInterface::ORDER_DESCENDING
                : QueryInterface::ORDER_ASCENDING,
        ]);

        return $query->execute();
    }

    /**
     * @param list<int> $uids
     * @return list<Job>
     */
    public function findByUids(array $uids): array
    {
        $jobs = [];
        foreach ($uids as $uid) {
            $job = $this->findByUid($uid);
            if ($job instanceof Job) {
                $jobs[] = $job;
            }
        }
        return $jobs;
    }

    /**
     * @param QueryInterface<Job> $query
     * @param list<int> $categoryUids
     */
    private function createCategoryConstraint(QueryInterface $query, array $categoryUids, string $categoryConjunction): ?object
    {
        $categoryConjunction = strtolower($categoryConjunction);
        if ($categoryUids === [] || $categoryConjunction === '') {
            return null;
        }

        $categoryConstraints = [];
        foreach ($categoryUids as $categoryUid) {
            $categoryConstraints[] = $query->contains('categories', $categoryUid);
        }

        return match ($categoryConjunction) {
            'or' => $query->logicalOr(...$categoryConstraints),
            'notor' => $query->logicalNot($query->logicalOr(...$categoryConstraints)),
            'notand' => $query->logicalNot($query->logicalAnd(...$categoryConstraints)),
            default => $query->logicalAnd(...$categoryConstraints),
        };
    }
}
