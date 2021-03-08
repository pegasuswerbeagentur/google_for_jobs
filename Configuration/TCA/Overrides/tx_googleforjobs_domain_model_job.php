<?php

defined('TYPO3_MODE') or die();

declare(strict_types=1);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::makeCategorizable(
    'google_for_jobs',
    'tx_googleforjobs_domain_model_job'
);
