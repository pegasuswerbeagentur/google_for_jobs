<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function()
    {

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'Pegasus.GoogleForJobs',
            'Job',
            [
                'Job' => 'index, list, show, listSelected, noJobFound'
            ],
            // non-cacheable actions
            [
                'Job' => ''
            ]
        );

    // wizards
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
        'mod {
            wizards.newContentElement.wizardItems.plugins {
                elements {
                    job {
                        iconIdentifier = google_for_jobs-plugin-job
                        title = LLL:EXT:google_for_jobs/Resources/Private/Language/locallang_db.xlf:tx_google_for_jobs_job.name
                        description = LLL:EXT:google_for_jobs/Resources/Private/Language/locallang_db.xlf:tx_google_for_jobs_job.description
                        tt_content_defValues {
                            CType = list
                            list_type = googleforjobs_job
                        }
                    }
                }
                show = *
            }
       }'
    );
    
    $iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
    $iconRegistry->registerIcon(
        'google_for_jobs-plugin-job',
        \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
        ['source' => 'EXT:google_for_jobs/Resources/Public/Icons/user_plugin_job.svg']
    );
		
    }
);
// register location migration update wizard
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/install']['update']['migrateLocationsUpdate'] = \Pegasus\GoogleForJobs\Updates\MigrateLocationsUpdate::class;