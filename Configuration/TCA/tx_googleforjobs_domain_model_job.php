<?php
return [
    'ctrl' => [
        'title' => 'LLL:EXT:google_for_jobs/Resources/Private/Language/locallang_db.xlf:tx_googleforjobs_domain_model_job',
        'default_sortby' => 'title',
        'label' => 'title',
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
        'requestUpdate' => 'job_location_type, base_salary_enable',
        'searchFields' => 'title,description,hiring_organization_name,hiring_organization_website,hiring_organization_logo_url,job_locations,base_salary_currency,base_salary_unit_text,employment_type,job_location_type,applicant_location_requirements',
        'iconfile' => 'EXT:google_for_jobs/Resources/Public/Icons/tx_googleforjobs_domain_model_job.gif'
    ],
    'interface' => [
        'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, title, description, date_posted, hiring_organization_name, hiring_organization_website, hiring_organization_logo_url, job_locations, valid_through, base_salary_enable, base_salary_currency, base_salary_unit_text, base_salary_value, employment_type, job_location_type, applicant_location_requirements',
    ],
    'types' => [
        '1' => [
            'showitem' => '
                sys_language_uid, l10n_parent, l10n_diffsource, hidden, alternative_title, path_segment,
                --div--;LLL:EXT:google_for_jobs/Resources/Private/Language/locallang_db.xlf:tx_googleforjobs_domain_model_job.structured_data,
                title, description, employment_type, date_posted, valid_through, hiring_organization_name, hiring_organization_website, hiring_organization_logo_url, job_locations, base_salary_enable, base_salary_currency, base_salary_unit_text, base_salary_value, job_location_type, applicant_location_requirements,
                --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.media,
                fal_media,fal_related_files,
                --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.tabs.metadata,
                author,category,
                --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access, 
                starttime, endtime,
                --div--;LLL:EXT:google_for_jobs/Resources/Private/Language/locallang_db.xlf:tx_googleforjobs_domain_model_job.notes,
                notes,
            '],
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
                'size' => 30,
                'eval' => 'trim,required,domainname'
            ],
        ],
        'hiring_organization_logo_url' => [
            'exclude' => true,
            'label' => 'LLL:EXT:google_for_jobs/Resources/Private/Language/locallang_db.xlf:tx_googleforjobs_domain_model_job.hiring_organization_logo_url',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputLink',
                'size' => 30,
                'eval' => 'trim,domainname'
            ],
        ],
        'job_locations' => [
            'exclude' => true,
            'label' => 'LLL:EXT:google_for_jobs/Resources/Private/Language/locallang_db.xlf:tx_googleforjobs_domain_model_job.job_locations',
            'config' => [
                'type' => 'select',
                'internal_type' => 'db',
                'renderType' => 'selectMultipleSideBySide',
                'foreign_table' => 'tx_googleforjobs_domain_model_joblocation',
                'MM_opposite_field' => 'job_locations_from',
                'size' => 5,
                'minitems' => 1,
                'maxitems' => 100,
                'MM' => 'tx_googleforjobs_domain_model_job_joblocation_mm',
                'wizards' => [
                    'add' => [
                        'module' => [
                            'name' => 'wizard_add',
                        ],
                        'type' => 'script',
                        'title' => 'Create new',
                        'icon' => 'EXT:backend/Resources/Public/Images/FormFieldWizard/wizard_add.gif',
                        'params' => [
                            'table' => 'tx_googleforjobs_domain_model_joblocation',
                            'pid' => '###CURRENT_PID###',
                        ],
                    ],
                ],
            ]
        ],
        'job_locations_from' => [
            'exclude' => true,
            'label' => 'joblocations from',
            'config' => [
                'type' => 'group',
                'internal_type' => 'db',
                'foreign_table' => 'tx_googleforjobs_domain_model_job',
                'allowed' => 'tx_googleforjobs_domain_model_job',
                'size' => 5,
                'maxitems' => 100,
                'MM' => 'tx_googleforjobs_domain_model_job_joblocation_mm',
                'readOnly' => 1,
            ]
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
        'base_salary_enable' => [
            'exclude' => true,
            'label' => 'LLL:EXT:google_for_jobs/Resources/Private/Language/locallang_db.xlf:tx_googleforjobs_domain_model_job.base_salary_enable',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle'
            ],
        ],
        'base_salary_currency' => [
            'exclude' => true,
            'label' => 'LLL:EXT:google_for_jobs/Resources/Private/Language/locallang_db.xlf:tx_googleforjobs_domain_model_job.base_salary_currency',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required'
            ],
            'displayCond' => 'FIELD:base_salary_enable:=:1',
        ],
        'base_salary_unit_text' => [
            'exclude' => true,
            'label' => 'LLL:EXT:google_for_jobs/Resources/Private/Language/locallang_db.xlf:tx_googleforjobs_domain_model_job.base_salary_unit_text',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['LLL:EXT:google_for_jobs/Resources/Private/Language/locallang_db.xlf:tx_googleforjobs_domain_model_job.base_salary_unit_hour', 'HOUR'],
                    ['LLL:EXT:google_for_jobs/Resources/Private/Language/locallang_db.xlf:tx_googleforjobs_domain_model_job.base_salary_unit_day', 'DAY'],
                    ['LLL:EXT:google_for_jobs/Resources/Private/Language/locallang_db.xlf:tx_googleforjobs_domain_model_job.base_salary_unit_week', 'WEEK'],
                    ['LLL:EXT:google_for_jobs/Resources/Private/Language/locallang_db.xlf:tx_googleforjobs_domain_model_job.base_salary_unit_month', 'MONTH'],
                    ['LLL:EXT:google_for_jobs/Resources/Private/Language/locallang_db.xlf:tx_googleforjobs_domain_model_job.base_salary_unit_year', 'YEAR'],
                ],
            ],
            'displayCond' => 'FIELD:base_salary_enable:=:1',
        ],
        'base_salary_value' => [
            'exclude' => true,
            'label' => 'LLL:EXT:google_for_jobs/Resources/Private/Language/locallang_db.xlf:tx_googleforjobs_domain_model_job.base_salary_value',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'double2,required'
            ],
            'displayCond' => 'FIELD:base_salary_enable:=:1',
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
                'type' => 'check',
                'renderType' => 'checkboxToggle'
            ],
        ],
        'applicant_location_requirements' => [
            'exclude' => true,
            'label' => 'LLL:EXT:google_for_jobs/Resources/Private/Language/locallang_db.xlf:tx_googleforjobs_domain_model_job.applicant_location_requirements',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required'
            ],
            'displayCond' => 'FIELD:job_location_type:=:1',
        ],
        'path_segment' => [
            'exclude' => true,
            'label' => 'LLL:EXT:google_for_jobs/Resources/Private/Language/locallang_db.xlf:tx_googleforjobs_domain_model_job.path_segment',
            'config' => [
                'type' => 'slug',
                'generatorOptions' => [
                    'fields' => ['title'],
                    'fieldSeparator' => '/',
                    'prefixParentPageSlug' => true,
                    'replacements' => [
                        '/' => '-',
                        '(' => '-',
                        ')' => '-',
                    ],
                ],
                'fallbackCharacter' => '-',
                'eval' => 'uniqueInSite',
                'default' => ''
            ],
        ],
        'fal_media' => [
            'exclude' => true,
            'label' => 'LLL:EXT:google_for_jobs/Resources/Private/Language/locallang_db.xlf:tx_googleforjobs_domain_model_job.fal_media',
            'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
                'fal_media',
                [
                    'behaviour' => [
                        'allowLanguageSynchronization' => true,
                    ],
                    'appearance' => [
                        'createNewRelationLinkTitle' => 'LLL:EXT:google_for_jobs/Resources/Private/Language/locallang_db.xlf:tx_googleforjobs_domain_model_job.fal_media.add',
                        'showPossibleLocalizationRecords' => true,
                        'showRemovedLocalizationRecords' => true,
                        'showAllLocalizationLink' => true,
                        'showSynchronizationLink' => true
                    ],
                    'foreign_match_fields' => [
                        'fieldname' => 'fal_media',
                        'tablenames' => 'tx_googleforjobs_domain_model_job',
                        'table_local' => 'sys_file',
                    ],
                    // custom configuration for displaying fields in the overlay/reference table
                    // to use the newsPalette and imageoverlayPalette instead of the basicoverlayPalette
                    'overrideChildTca' => [
                        'types' => [
                            \TYPO3\CMS\Core\Resource\File::FILETYPE_UNKNOWN => [
                                'showitem' => '
                                    --palette--;LLL:EXT:lang/Resources/Private/Language/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;newsPalette,
                                    --palette--;;imageoverlayPalette,
                                    --palette--;;filePalette'
                            ],
                            \TYPO3\CMS\Core\Resource\File::FILETYPE_TEXT => [
                                'showitem' => '
                                    --palette--;LLL:EXT:lang/Resources/Private/Language/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;newsPalette,
                                    --palette--;;imageoverlayPalette,
                                    --palette--;;filePalette'
                            ],
                            \TYPO3\CMS\Core\Resource\File::FILETYPE_IMAGE => [
                                'showitem' => '
                                    --palette--;LLL:EXT:lang/Resources/Private/Language/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;newsPalette,
                                    --palette--;;imageoverlayPalette,
                                    --palette--;;filePalette'
                            ],
                            \TYPO3\CMS\Core\Resource\File::FILETYPE_AUDIO => [
                                'showitem' => '
                                    --palette--;LLL:EXT:lang/Resources/Private/Language/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;newsPalette,
                                    --palette--;;imageoverlayPalette,
                                    --palette--;;filePalette'
                            ],
                            \TYPO3\CMS\Core\Resource\File::FILETYPE_VIDEO => [
                                'showitem' => '
                                    --palette--;LLL:EXT:lang/Resources/Private/Language/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;newsPalette,
                                    --palette--;;imageoverlayPalette,
                                    --palette--;;filePalette'
                            ],
                            \TYPO3\CMS\Core\Resource\File::FILETYPE_APPLICATION => [
                                'showitem' => '
                                    --palette--;LLL:EXT:lang/Resources/Private/Language/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;newsPalette,
                                    --palette--;;imageoverlayPalette,
                                    --palette--;;filePalette'
                            ]
                        ],
                    ],
                ],
                $GLOBALS['TYPO3_CONF_VARS']['SYS']['mediafile_ext']
            )
        ],
        'fal_related_files' => [
            'exclude' => true,
            'label' => 'LLL:EXT:google_for_jobs/Resources/Private/Language/locallang_db.xlf:tx_googleforjobs_domain_model_job.fal_related_files',
            'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
                'fal_related_files',
                [
                    'behaviour' => [
                        'allowLanguageSynchronization' => true,
                    ],
                    'appearance' => [
                        'createNewRelationLinkTitle' => 'LLL:EXT:google_for_jobs/Resources/Private/Language/locallang_db.xlf:tx_googleforjobs_domain_model_job.fal_related_files.add',
                        'showPossibleLocalizationRecords' => true,
                        'showRemovedLocalizationRecords' => true,
                        'showAllLocalizationLink' => true,
                        'showSynchronizationLink' => true
                    ],
                    'inline' => [
                        'inlineOnlineMediaAddButtonStyle' => 'display:none'
                    ],
                    'foreign_match_fields' => [
                        'fieldname' => 'fal_related_files',
                        'tablenames' => 'tx_googleforjobs_domain_model_job',
                        'table_local' => 'sys_file',
                    ],
                ]
            )
        ],
        'author' => [
            'exclude' => true,
            'label' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.author_formlabel',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
            ]
        ],
        'alternative_title' => [
            'exclude' => true,
            'label' => 'LLL:EXT:google_for_jobs/Resources/Private/Language/locallang_db.xlf:tx_googleforjobs_domain_model_job.alternative_title',
            'config' => [
                'type' => 'input',
                'size' => 30,
            ]
        ],
        'category' => [
            'exclude' => true,
            'label' => 'LLL:EXT:google_for_jobs/Resources/Private/Language/locallang_db.xlf:tx_googleforjobs_domain_model_job.category',
            'config' => [
                'type' => 'input',
                'size' => 30,
            ]
        ],
        'notes' => [
            'label' => 'LLL:EXT:google_for_jobs/Resources/Private/Language/locallang_db.xlf:tx_googleforjobs_domain_model_job.notes',
            'config' => [
                'type' => 'text',
                'rows' => 10,
                'cols' => 48
            ]
        ],
    ],
];
