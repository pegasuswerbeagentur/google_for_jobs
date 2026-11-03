<?php

declare(strict_types=1);

namespace Pegasus\GoogleForJobs\PageTitle;

use TYPO3\CMS\Core\PageTitle\AbstractPageTitleProvider;

/*
 * This file is part of the "Google for Jobs" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

/**
 * Uses the job title as page title on the detail page.
 */
class JobPageTitleProvider extends AbstractPageTitleProvider
{
    public function setTitle(string $title): void
    {
        $this->title = trim($title);
    }
}
