<?php

defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function()
    {

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            'Pegasus.GoogleForJobs',
            'Job',
            'Jobs (Google for Jobs)'
        );

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('google_for_jobs', 'Configuration/TypoScript', 'Google for Jobs');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_googleforjobs_domain_model_job', 'EXT:google_for_jobs/Resources/Private/Language/locallang_csh_tx_googleforjobs_domain_model_job.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_googleforjobs_domain_model_job');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_googleforjobs_domain_model_joblocation', 'EXT:google_for_jobs/Resources/Private/Language/locallang_csh_tx_googleforjobs_domain_model_joblocation.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_googleforjobs_domain_model_joblocation');

    }
);
