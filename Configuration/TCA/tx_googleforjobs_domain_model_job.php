<?php
return [
    'ctrl' => [
        'title' => 'LLL:EXT:google_for_jobs/Resources/Private/Language/locallang_db.xlf:tx_googleforjobs_domain_model_job',
        'label' => 'date_posted',
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
        'searchFields' => 'title,description,hiring_organization_name,hiring_organization_website,hiring_organization_logo_url,job_location_street_address,job_location_city,job_location_postal_code,job_location_region,job_location_country,base_salary_currency,base_salary_unit_text,employment_type,job_location_type,applicant_location_requirements',
        'iconfile' => 'EXT:google_for_jobs/Resources/Public/Icons/tx_googleforjobs_domain_model_job.gif'
    ],
    'interface' => [
        'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, title, description, date_posted, hiring_organization_name, hiring_organization_website, hiring_organization_logo_url, job_location_street_address, job_location_city, job_location_postal_code, job_location_region, job_location_country, valid_through, base_salary_currency, base_salary_unit_text, base_salary_value, employment_type, job_location_type, applicant_location_requirements',
    ],
    'types' => [
        '1' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, title, description, employment_type, date_posted, valid_through, hiring_organization_name, hiring_organization_website, hiring_organization_logo_url, job_location_street_address, job_location_city, job_location_postal_code, job_location_region, job_location_country, base_salary_currency, base_salary_unit_text, base_salary_value, job_location_type, applicant_location_requirements, --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access, starttime, endtime'],
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
                'foreign_table' => 'tx_googleforjobs_domain_model_job',
                'foreign_table_where' => 'AND {#tx_googleforjobs_domain_model_job}.{#pid}=###CURRENT_PID### AND {#tx_googleforjobs_domain_model_job}.{#sys_language_uid} IN (-1,0)',
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

        'title' => [
            'exclude' => true,
            'label' => 'LLL:EXT:google_for_jobs/Resources/Private/Language/locallang_db.xlf:tx_googleforjobs_domain_model_job.title',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required'
            ],
        ],
        'date_posted' => [
            'exclude' => true,
            'label' => 'LLL:EXT:google_for_jobs/Resources/Private/Language/locallang_db.xlf:tx_googleforjobs_domain_model_job.date_posted',
            'config' => [
                'dbType' => 'date',
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'size' => 7,
                'eval' => 'date,required',
                'default' => null,
            ],
        ],
        'description' => [
            'exclude' => true,
            'label' => 'LLL:EXT:google_for_jobs/Resources/Private/Language/locallang_db.xlf:tx_googleforjobs_domain_model_job.description',
            'config' => [
                'type' => 'text',
                'enableRichtext' => true,
                'richtextConfiguration' => 'default',
                'fieldControl' => [
                    'fullScreenRichtext' => [
                        'disabled' => false,
                    ],
                ],
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim',
            ],
            
        ],
        'hiring_organization_name' => [
            'exclude' => true,
            'label' => 'LLL:EXT:google_for_jobs/Resources/Private/Language/locallang_db.xlf:tx_googleforjobs_domain_model_job.hiring_organization_name',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required'
            ],
        ],
        'hiring_organization_website' => [
            'exclude' => true,
            'label' => 'LLL:EXT:google_for_jobs/Resources/Private/Language/locallang_db.xlf:tx_googleforjobs_domain_model_job.hiring_organization_website',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputLink',
                'linkPopup' => [
                    'blindLinkOptions' => 'file, mail, page, spec',
                    'blindLinkFields' => 'class, params',
                ],
                'size' => 30,
                'eval' => 'trim,required,domainname'
            ],
        ],
        'hiring_organization_logo_url' => [
            'exclude' => true,
            'label' => 'LLL:EXT:google_for_jobs/Resources/Private/Language/locallang_db.xlf:tx_googleforjobs_domain_model_job.hiring_organization_logo_url',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,domainname'
            ],
        ],
        'job_location_street_address' => [
            'exclude' => true,
            'label' => 'LLL:EXT:google_for_jobs/Resources/Private/Language/locallang_db.xlf:tx_googleforjobs_domain_model_job.job_location_street_address',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required'
            ],
        ],
        'job_location_city' => [
            'exclude' => true,
            'label' => 'LLL:EXT:google_for_jobs/Resources/Private/Language/locallang_db.xlf:tx_googleforjobs_domain_model_job.job_location_city',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required'
            ],
        ],
        'job_location_postal_code' => [
            'exclude' => true,
            'label' => 'LLL:EXT:google_for_jobs/Resources/Private/Language/locallang_db.xlf:tx_googleforjobs_domain_model_job.job_location_postal_code',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required'
            ],
        ],
        'job_location_region' => [
            'exclude' => true,
            'label' => 'LLL:EXT:google_for_jobs/Resources/Private/Language/locallang_db.xlf:tx_googleforjobs_domain_model_job.job_location_region',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required'
            ],
        ],
        'job_location_country' => [
            'exclude' => true,
            'label' => 'LLL:EXT:google_for_jobs/Resources/Private/Language/locallang_db.xlf:tx_googleforjobs_domain_model_job.job_location_country',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required'
            ],
        ],
        'valid_through' => [
            'exclude' => true,
            'label' => 'LLL:EXT:google_for_jobs/Resources/Private/Language/locallang_db.xlf:tx_googleforjobs_domain_model_job.valid_through',
            'config' => [
                'dbType' => 'date',
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'size' => 7,
                'eval' => 'date',
                'default' => null,
            ],
        ],
        'base_salary_currency' => [
            'exclude' => true,
            'label' => 'LLL:EXT:google_for_jobs/Resources/Private/Language/locallang_db.xlf:tx_googleforjobs_domain_model_job.base_salary_currency',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'base_salary_unit_text' => [
            'exclude' => true,
            'label' => 'LLL:EXT:google_for_jobs/Resources/Private/Language/locallang_db.xlf:tx_googleforjobs_domain_model_job.base_salary_unit_text',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'base_salary_value' => [
            'exclude' => true,
            'label' => 'LLL:EXT:google_for_jobs/Resources/Private/Language/locallang_db.xlf:tx_googleforjobs_domain_model_job.base_salary_value',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'double2'
            ]
        ],
        'employment_type' => [
            'exclude' => true,
            'label' => 'LLL:EXT:google_for_jobs/Resources/Private/Language/locallang_db.xlf:tx_googleforjobs_domain_model_job.employment_type',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'items' => [
                    ['LLL:EXT:google_for_jobs/Resources/Private/Language/locallang_db.xlf:tx_googleforjobs_domain_model_job.employment_type_contractor', 'CONTRACTOR'],
                    ['LLL:EXT:google_for_jobs/Resources/Private/Language/locallang_db.xlf:tx_googleforjobs_domain_model_job.employment_type_part_time', 'PART_TIME'],
                    ['LLL:EXT:google_for_jobs/Resources/Private/Language/locallang_db.xlf:tx_googleforjobs_domain_model_job.employment_type_full_time', 'FULL_TIME'],
                    ['LLL:EXT:google_for_jobs/Resources/Private/Language/locallang_db.xlf:tx_googleforjobs_domain_model_job.employment_type_temporary', 'TEMPORARY'],
                    ['LLL:EXT:google_for_jobs/Resources/Private/Language/locallang_db.xlf:tx_googleforjobs_domain_model_job.employment_type_intern', 'INTERN'],
                    ['LLL:EXT:google_for_jobs/Resources/Private/Language/locallang_db.xlf:tx_googleforjobs_domain_model_job.employment_type_volunteer', 'VOLUNTEER'],
                    ['LLL:EXT:google_for_jobs/Resources/Private/Language/locallang_db.xlf:tx_googleforjobs_domain_model_job.employment_type_per_diem', 'PER_DIEM'],
                    ['LLL:EXT:google_for_jobs/Resources/Private/Language/locallang_db.xlf:tx_googleforjobs_domain_model_job.employment_type_other', 'OTHER'],
                ],
            ],
        ],
        'job_location_type' => [
            'exclude' => true,
            'label' => 'LLL:EXT:google_for_jobs/Resources/Private/Language/locallang_db.xlf:tx_googleforjobs_domain_model_job.job_location_type',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'applicant_location_requirements' => [
            'exclude' => true,
            'label' => 'LLL:EXT:google_for_jobs/Resources/Private/Language/locallang_db.xlf:tx_googleforjobs_domain_model_job.applicant_location_requirements',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
    
    ],
];
