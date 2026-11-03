<?php

declare(strict_types=1);

use Pegasus\GoogleForJobs\Controller\JobController;
use TYPO3\CMS\Core\Information\Typo3Version;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

defined('TYPO3') or die();

ExtensionUtility::configurePlugin(
    'GoogleForJobs',
    'Job',
    [
        JobController::class => 'index, list, show, listSelected',
    ],
    [],
    ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT,
);

// Content elements of version 2.x ("Insert plugin" with list_type) keep rendering on
// TYPO3 13 until the upgrade wizard has migrated them. TYPO3 14 does not support them.
if ((new Typo3Version())->getMajorVersion() < 14) {
    ExtensionManagementUtility::addTypoScript(
        'google_for_jobs',
        'setup',
        'tt_content.list.20.googleforjobs_job =< tt_content.googleforjobs_job.20',
        'defaultContentRendering',
    );
}
