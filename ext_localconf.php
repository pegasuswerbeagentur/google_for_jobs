<?php

declare(strict_types=1);

use Pegasus\GoogleForJobs\Controller\JobController;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

defined('TYPO3') or die();

ExtensionUtility::configurePlugin(
    'GoogleForJobs',
    'Job',
    [
        JobController::class => 'index, list, show, listSelected, noJobFound',
    ],
    [],
    ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT,
);
