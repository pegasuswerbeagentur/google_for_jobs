<?php

$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['googleforjobs_job'] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    // plugin signature: <extension key without underscores> '_' <plugin name in lowercase>
    'googleforjobs_job',
    // Flexform configuration schema file
    'FILE:EXT:google_for_jobs/Configuration/FlexForms/flexform_job.xml'
);
