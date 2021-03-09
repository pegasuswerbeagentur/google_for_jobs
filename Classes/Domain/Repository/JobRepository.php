<?php

declare(strict_types=1);

namespace Pegasus\GoogleForJobs\Domain\Repository;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;

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
/**
 * The repository for Jobs
 */
class JobRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    /**
     * Returns a list of jobs by categories and their conjunction
     *
     * @param string $categories A comma seperated string of category Id's
     * @param string $categoryConjunction The logical conjunction for the categories
     * @param string|null $categories A comma seperated string of category Id's
     * @param string|null $categoryConjunction The logical conjunction for the categories
     * @return QueryResultInterface
     */
    public function findByCategories(?string $categories, ?string $categorieConjunction): QueryResultInterface
    {
        $query = $this->createQuery();

        if ($categories === null) {
            return $query->execute();
        }

        $categoryConstraints = [];
        $categorieConjunction = $categorieConjunction ?? '';
        $categories = GeneralUtility::intExplode(',', $categories, true);

        foreach ($categories as $category) {
            $categoryConstraints[] = $query->contains('categories', $category);
        }

        if ($categoryConstraints && $categorieConjunction) {
            switch (strtolower($categorieConjunction)) {
                case 'or':
                    $query->matching($query->logicalOr($categoryConstraints));
                    break;
                case 'notor':
                    $query->matching($query->logicalNot($query->logicalOr($categoryConstraints)));
                    break;
                case 'notand':
                    $query->matching($query->logicalNot($query->logicalAnd($categoryConstraints)));
                    break;
                case 'and':
                default:
                    $query->matching($query->logicalAnd($categoryConstraints));
            }
        }

        $result = $query->execute();

        return $result;
    }
}
