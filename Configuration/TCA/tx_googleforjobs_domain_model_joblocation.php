<?php
return [
    'ctrl' => [
        'title' => 'LLL:EXT:google_for_jobs/Resources/Private/Language/locallang_db.xlf:tx_googleforjobs_domain_model_joblocation',
        'default_sortby' => 'street_address',
        'label' => 'street_address',
        'label_alt' => 'city',
        'label_alt_force' => true,
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'versioningWS' => true,
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ],
        'searchFields' => 'street_address,city,postal_code,region,country',
        'iconfile' => 'EXT:google_for_jobs/Resources/Public/Icons/tx_googleforjobs_domain_model_job.gif'
    ],
    'interface' => [
        'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, street_address, city, postal_code, region, country',
    ],
    'types' => [
        '1' => [
            'showitem' => 
                'sys_language_uid, l10n_parent, l10n_diffsource, hidden, street_address, city, postal_code, region, country, base_salary_enable, base_salary_currency, base_salary_unit_text, base_salary_value, type, applicant_location_requirements'
            ],
    ],
    'columns' => [
        'sys_language_uid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.language',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'special' => 'languages',
                'items' => [
                    [
                        'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.allLanguages',
                        -1,
                        'flags-multiple'
                    ]
                ],
                'default' => 0,
            ],
        ],
        'l10n_parent' => [
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.l18n_parent',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'default' => 0,
                'items' => [
                    ['', 0],
                ],
                'foreign_table' => 'tx_googleforjobs_domain_model_joblocation',
                'foreign_table_where' => 'AND {#tx_googleforjobs_domain_model_joblocation}.{#pid}=###CURRENT_PID### AND {#tx_googleforjobs_domain_model_joblocation}.{#sys_language_uid} IN (-1,0)',
            ],
        ],
        'l10n_diffsource' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        't3ver_label' => [
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.versionLabel',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'max' => 255,
            ],
        ],
        'hidden' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.visible',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'items' => [
                    [
                        0 => '',
                        1 => '',
                        'invertStateDisplay' => true
                    ]
                ],
            ],
        ],
        'starttime' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.starttime',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'eval' => 'datetime,int',
                'default' => 0,
                'behaviour' => [
                    'allowLanguageSynchronization' => true
                ]
            ],
        ],
        'endtime' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.endtime',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'eval' => 'datetime,int',
                'default' => 0,
                'range' => [
                    'upper' => mktime(0, 0, 0, 1, 1, 2038)
                ],
                'behaviour' => [
                    'allowLanguageSynchronization' => true
                ]
            ],
        ],
        'street_address' => [
            'exclude' => true,
            'label' => 'LLL:EXT:google_for_jobs/Resources/Private/Language/locallang_db.xlf:tx_googleforjobs_domain_model_joblocation.street_address',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required'
            ],
        ],
        'city' => [
            'exclude' => true,
            'label' => 'LLL:EXT:google_for_jobs/Resources/Private/Language/locallang_db.xlf:tx_googleforjobs_domain_model_joblocation.city',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required'
            ],
        ],
        'postal_code' => [
            'exclude' => true,
            'label' => 'LLL:EXT:google_for_jobs/Resources/Private/Language/locallang_db.xlf:tx_googleforjobs_domain_model_joblocation.postal_code',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required'
            ],
        ],
        'region' => [
            'exclude' => true,
            'label' => 'LLL:EXT:google_for_jobs/Resources/Private/Language/locallang_db.xlf:tx_googleforjobs_domain_model_joblocation.region',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required'
            ],
        ],
        'country' => [
            'exclude' => true,
            'label' => 'LLL:EXT:google_for_jobs/Resources/Private/Language/locallang_db.xlf:tx_googleforjobs_domain_model_joblocation.country',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required'
            ],
        ],
    ],
];
