<?php

declare(strict_types=1);

use TYPO3\CMS\Core\Information\Typo3Version;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

defined('TYPO3') or die();

(static function (): void {
    $flexForm = 'FILE:EXT:google_for_jobs/Configuration/FlexForms/flexform_job.xml';
    $flexFormInPluginRegistration = (new Typo3Version())->getMajorVersion() >= 14;

    $pluginArguments = [
        'GoogleForJobs',
        'Job',
        'LLL:EXT:google_for_jobs/Resources/Private/Language/locallang_db.xlf:tx_google_for_jobs_job.name',
        'google_for_jobs-plugin-job',
        'plugins',
        'LLL:EXT:google_for_jobs/Resources/Private/Language/locallang_db.xlf:tx_google_for_jobs_job.description',
    ];
    if ($flexFormInPluginRegistration) {
        $pluginArguments[] = $flexForm;
    }
    $contentType = ExtensionUtility::registerPlugin(...$pluginArguments);

    if (!$flexFormInPluginRegistration) {
        ExtensionManagementUtility::addPiFlexFormValue('*', $flexForm, $contentType);
        ExtensionManagementUtility::addToAllTCAtypes(
            'tt_content',
            '--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.plugin, pi_flexform',
            $contentType,
            'after:palette:headers',
        );
    }

    ExtensionManagementUtility::addToAllTCAtypes('tt_content', 'pages, recursive', $contentType, 'after:pi_flexform');
})();
