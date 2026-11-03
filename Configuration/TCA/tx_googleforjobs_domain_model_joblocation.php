<?php

declare(strict_types=1);

defined('TYPO3') or die();

$ll = 'LLL:EXT:google_for_jobs/Resources/Private/Language/locallang_db.xlf:tx_googleforjobs_domain_model_joblocation';

return [
    'ctrl' => [
        'title' => $ll,
        'label' => 'street_address',
        'label_alt' => 'postal_code, city',
        'label_alt_force' => true,
        'default_sortby' => 'city, street_address',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'versioningWS' => true,
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'translationSource' => 'l10n_source',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ],
        'security' => [
            'ignorePageTypeRestriction' => true,
        ],
        'iconfile' => 'EXT:google_for_jobs/Resources/Public/Icons/tx_googleforjobs_domain_model_job.gif',
    ],
    'palettes' => [
        'address' => [
            'showitem' => 'street_address, --linebreak--, postal_code, city, --linebreak--, region, country',
        ],
        'language' => [
            'showitem' => 'sys_language_uid, l10n_parent',
        ],
        'access' => [
            'showitem' => 'hidden, --linebreak--, starttime, endtime',
        ],
    ],
    'types' => [
        '1' => [
            'showitem' => '
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
                    --palette--;;address,
                    jobs,
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,
                    --palette--;;language,
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,
                    --palette--;;access,
            ',
        ],
    ],
    'columns' => [
        'street_address' => [
            'label' => $ll . '.street_address',
            'description' => $ll . '.street_address.description',
            'config' => [
                'type' => 'input',
                'size' => 40,
                'max' => 255,
                'eval' => 'trim',
            ],
        ],
        'postal_code' => [
            'label' => $ll . '.postal_code',
            'config' => [
                'type' => 'input',
                'size' => 10,
                'max' => 255,
                'eval' => 'trim',
            ],
        ],
        'city' => [
            'label' => $ll . '.city',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'max' => 255,
                'eval' => 'trim',
            ],
        ],
        'region' => [
            'exclude' => true,
            'label' => $ll . '.region',
            'description' => $ll . '.region.description',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'max' => 255,
                'eval' => 'trim',
            ],
        ],
        'country' => [
            'label' => $ll . '.country',
            'description' => $ll . '.country.description',
            'config' => [
                'type' => 'input',
                'size' => 10,
                'max' => 255,
                'required' => true,
                'eval' => 'trim',
                'placeholder' => 'DE',
            ],
        ],
        'jobs' => [
            'exclude' => true,
            'label' => $ll . '.jobs',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'foreign_table' => 'tx_googleforjobs_domain_model_job',
                'foreign_table_where' => 'AND {#tx_googleforjobs_domain_model_job}.{#sys_language_uid} IN (-1,0) ORDER BY {#tx_googleforjobs_domain_model_job}.{#title}',
                'MM' => 'tx_googleforjobs_domain_model_job_joblocation_mm',
                'size' => 5,
                'maxitems' => 9999,
                'readOnly' => true,
            ],
        ],
    ],
];
