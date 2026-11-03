<?php

declare(strict_types=1);

defined('TYPO3') or die();

$ll = 'LLL:EXT:google_for_jobs/Resources/Private/Language/locallang_db.xlf:tx_googleforjobs_domain_model_job';

return [
    'ctrl' => [
        'title' => $ll,
        'label' => 'title',
        'default_sortby' => 'title',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'versioningWS' => true,
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'translationSource' => 'l10n_source',
        'delete' => 'deleted',
        'descriptionColumn' => 'notes',
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
        'title' => [
            'showitem' => 'title, --linebreak--, alternative_title, path_segment',
        ],
        'dates' => [
            'label' => $ll . '.palette.dates',
            'showitem' => 'date_posted, valid_through',
        ],
        'organization' => [
            'label' => $ll . '.palette.organization',
            'showitem' => 'hiring_organization_name, --linebreak--, hiring_organization_website, hiring_organization_logo_url',
        ],
        'remote' => [
            'label' => $ll . '.palette.remote',
            'showitem' => 'job_location_type, --linebreak--, applicant_location_requirements',
        ],
        'salary' => [
            'label' => $ll . '.palette.salary',
            'showitem' => 'base_salary_enable, --linebreak--, base_salary_currency, base_salary_unit_text, --linebreak--, base_salary_value, base_salary_min_value, base_salary_max_value',
        ],
        'application' => [
            'label' => $ll . '.palette.application',
            'showitem' => 'identifier, direct_apply',
        ],
        'requirements' => [
            'label' => $ll . '.palette.requirements',
            'description' => $ll . '.palette.requirements.description',
            'showitem' => 'education_requirements, --linebreak--, experience_months, experience_in_place_of_education',
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
                    --palette--;;title,
                    description,
                    employment_type,
                    --palette--;;dates,
                    --palette--;;organization,
                    job_locations,
                    --palette--;;remote,
                    --palette--;;salary,
                    --palette--;;application,
                    --palette--;;requirements,
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:media,
                    fal_media,
                    fal_related_files,
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:categories,
                    categories,
                    category,
                    author,
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,
                    --palette--;;language,
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,
                    --palette--;;access,
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:notes,
                    notes,
            ',
        ],
    ],
    'columns' => [
        'title' => [
            'label' => $ll . '.title',
            'description' => $ll . '.title.description',
            'config' => [
                'type' => 'input',
                'size' => 50,
                'max' => 255,
                'required' => true,
                'eval' => 'trim',
            ],
        ],
        'alternative_title' => [
            'exclude' => true,
            'label' => $ll . '.alternative_title',
            'description' => $ll . '.alternative_title.description',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
            ],
        ],
        'path_segment' => [
            'exclude' => true,
            'label' => $ll . '.path_segment',
            'config' => [
                'type' => 'slug',
                'size' => 50,
                'generatorOptions' => [
                    'fields' => ['title'],
                    'replacements' => [
                        '/' => '-',
                    ],
                ],
                'fallbackCharacter' => '-',
                'eval' => 'uniqueInSite',
                'default' => '',
            ],
        ],
        'description' => [
            'label' => $ll . '.description',
            'description' => $ll . '.description.description',
            'config' => [
                'type' => 'text',
                'enableRichtext' => true,
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim',
            ],
        ],
        'employment_type' => [
            'exclude' => true,
            'label' => $ll . '.employment_type',
            'description' => $ll . '.employment_type.description',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectCheckBox',
                'items' => [
                    ['label' => $ll . '.employment_type_full_time', 'value' => 'FULL_TIME'],
                    ['label' => $ll . '.employment_type_part_time', 'value' => 'PART_TIME'],
                    ['label' => $ll . '.employment_type_contractor', 'value' => 'CONTRACTOR'],
                    ['label' => $ll . '.employment_type_temporary', 'value' => 'TEMPORARY'],
                    ['label' => $ll . '.employment_type_intern', 'value' => 'INTERN'],
                    ['label' => $ll . '.employment_type_volunteer', 'value' => 'VOLUNTEER'],
                    ['label' => $ll . '.employment_type_per_diem', 'value' => 'PER_DIEM'],
                    ['label' => $ll . '.employment_type_other', 'value' => 'OTHER'],
                ],
            ],
        ],
        'date_posted' => [
            'label' => $ll . '.date_posted',
            'description' => $ll . '.date_posted.description',
            'config' => [
                'type' => 'datetime',
                'format' => 'date',
                'dbType' => 'date',
                'required' => true,
                'nullable' => true,
                'default' => null,
            ],
        ],
        'valid_through' => [
            'exclude' => true,
            'label' => $ll . '.valid_through',
            'description' => $ll . '.valid_through.description',
            'config' => [
                'type' => 'datetime',
                'format' => 'date',
                'dbType' => 'date',
                'nullable' => true,
                'default' => null,
            ],
        ],
        'hiring_organization_name' => [
            'label' => $ll . '.hiring_organization_name',
            'description' => $ll . '.hiring_organization_name.description',
            'config' => [
                'type' => 'input',
                'size' => 50,
                'max' => 255,
                'required' => true,
                'eval' => 'trim',
            ],
        ],
        'hiring_organization_website' => [
            'label' => $ll . '.hiring_organization_website',
            'description' => $ll . '.hiring_organization_website.description',
            'config' => [
                'type' => 'link',
                'allowedTypes' => ['url', 'page'],
                'required' => true,
            ],
        ],
        'hiring_organization_logo_url' => [
            'exclude' => true,
            'label' => $ll . '.hiring_organization_logo_url',
            'description' => $ll . '.hiring_organization_logo_url.description',
            'config' => [
                'type' => 'link',
                'allowedTypes' => ['url', 'file'],
                'appearance' => [
                    'allowedFileExtensions' => ['png', 'jpg', 'jpeg', 'gif', 'svg', 'webp'],
                ],
            ],
        ],
        'job_locations' => [
            'label' => $ll . '.job_locations',
            'description' => $ll . '.job_locations.description',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'foreign_table' => 'tx_googleforjobs_domain_model_joblocation',
                'foreign_table_where' => 'AND {#tx_googleforjobs_domain_model_joblocation}.{#sys_language_uid} IN (-1,0) ORDER BY tx_googleforjobs_domain_model_joblocation.city, tx_googleforjobs_domain_model_joblocation.street_address',
                'MM' => 'tx_googleforjobs_domain_model_job_joblocation_mm',
                'MM_opposite_field' => 'jobs',
                'size' => 5,
                'minitems' => 0,
                'maxitems' => 100,
                'fieldControl' => [
                    'addRecord' => [
                        'disabled' => false,
                    ],
                    'editPopup' => [
                        'disabled' => false,
                    ],
                ],
            ],
        ],
        'job_location_type' => [
            'exclude' => true,
            'label' => $ll . '.job_location_type',
            'description' => $ll . '.job_location_type.description',
            'onChange' => 'reload',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'default' => 0,
            ],
        ],
        'applicant_location_requirements' => [
            'exclude' => true,
            'label' => $ll . '.applicant_location_requirements',
            'description' => $ll . '.applicant_location_requirements.description',
            'displayCond' => 'FIELD:job_location_type:=:1',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'max' => 255,
                'required' => true,
                'eval' => 'trim',
                'placeholder' => 'DE, AT, CH',
            ],
        ],
        'base_salary_enable' => [
            'exclude' => true,
            'label' => $ll . '.base_salary_enable',
            'description' => $ll . '.base_salary_enable.description',
            'onChange' => 'reload',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'default' => 0,
            ],
        ],
        'base_salary_currency' => [
            'exclude' => true,
            'label' => $ll . '.base_salary_currency',
            'description' => $ll . '.base_salary_currency.description',
            'displayCond' => 'FIELD:base_salary_enable:=:1',
            'config' => [
                'type' => 'input',
                'size' => 5,
                'max' => 3,
                'required' => true,
                'eval' => 'trim,upper',
                'placeholder' => 'EUR',
            ],
        ],
        'base_salary_unit_text' => [
            'exclude' => true,
            'label' => $ll . '.base_salary_unit_text',
            'description' => $ll . '.base_salary_unit_text.description',
            'displayCond' => 'FIELD:base_salary_enable:=:1',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['label' => $ll . '.base_salary_unit_hour', 'value' => 'HOUR'],
                    ['label' => $ll . '.base_salary_unit_day', 'value' => 'DAY'],
                    ['label' => $ll . '.base_salary_unit_week', 'value' => 'WEEK'],
                    ['label' => $ll . '.base_salary_unit_month', 'value' => 'MONTH'],
                    ['label' => $ll . '.base_salary_unit_year', 'value' => 'YEAR'],
                ],
                'default' => 'YEAR',
            ],
        ],
        'base_salary_value' => [
            'exclude' => true,
            'label' => $ll . '.base_salary_value',
            'description' => $ll . '.base_salary_value.description',
            'displayCond' => 'FIELD:base_salary_enable:=:1',
            'config' => [
                'type' => 'number',
                'format' => 'decimal',
                'size' => 10,
                'default' => 0,
            ],
        ],
        'base_salary_min_value' => [
            'exclude' => true,
            'label' => $ll . '.base_salary_min_value',
            'description' => $ll . '.base_salary_min_value.description',
            'displayCond' => 'FIELD:base_salary_enable:=:1',
            'config' => [
                'type' => 'number',
                'format' => 'decimal',
                'size' => 10,
                'default' => 0,
            ],
        ],
        'base_salary_max_value' => [
            'exclude' => true,
            'label' => $ll . '.base_salary_max_value',
            'description' => $ll . '.base_salary_max_value.description',
            'displayCond' => 'FIELD:base_salary_enable:=:1',
            'config' => [
                'type' => 'number',
                'format' => 'decimal',
                'size' => 10,
                'default' => 0,
            ],
        ],
        'identifier' => [
            'exclude' => true,
            'label' => $ll . '.identifier',
            'description' => $ll . '.identifier.description',
            'config' => [
                'type' => 'input',
                'size' => 20,
                'max' => 255,
                'eval' => 'trim',
            ],
        ],
        'direct_apply' => [
            'exclude' => true,
            'label' => $ll . '.direct_apply',
            'description' => $ll . '.direct_apply.description',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['label' => $ll . '.direct_apply.unspecified', 'value' => 0],
                    ['label' => $ll . '.direct_apply.yes', 'value' => 1],
                    ['label' => $ll . '.direct_apply.no', 'value' => 2],
                ],
                'default' => 0,
            ],
        ],
        'education_requirements' => [
            'exclude' => true,
            'label' => $ll . '.education_requirements',
            'description' => $ll . '.education_requirements.description',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectCheckBox',
                'items' => [
                    ['label' => $ll . '.education_requirements.no_requirements', 'value' => 'no requirements'],
                    ['label' => $ll . '.education_requirements.high_school', 'value' => 'high school'],
                    ['label' => $ll . '.education_requirements.associate_degree', 'value' => 'associate degree'],
                    ['label' => $ll . '.education_requirements.bachelor_degree', 'value' => 'bachelor degree'],
                    ['label' => $ll . '.education_requirements.professional_certificate', 'value' => 'professional certificate'],
                    ['label' => $ll . '.education_requirements.postgraduate_degree', 'value' => 'postgraduate degree'],
                ],
            ],
        ],
        'experience_months' => [
            'exclude' => true,
            'label' => $ll . '.experience_months',
            'description' => $ll . '.experience_months.description',
            'config' => [
                'type' => 'number',
                'size' => 5,
                'nullable' => true,
                'default' => null,
                'range' => [
                    'lower' => 0,
                ],
            ],
        ],
        'experience_in_place_of_education' => [
            'exclude' => true,
            'label' => $ll . '.experience_in_place_of_education',
            'description' => $ll . '.experience_in_place_of_education.description',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'default' => 0,
            ],
        ],
        'fal_media' => [
            'exclude' => true,
            'label' => $ll . '.fal_media',
            'config' => [
                'type' => 'file',
                'allowed' => 'common-media-types',
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
                'appearance' => [
                    'createNewRelationLinkTitle' => $ll . '.fal_media.add',
                    'showPossibleLocalizationRecords' => true,
                ],
            ],
        ],
        'fal_related_files' => [
            'exclude' => true,
            'label' => $ll . '.fal_related_files',
            'config' => [
                'type' => 'file',
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
                'appearance' => [
                    'createNewRelationLinkTitle' => $ll . '.fal_related_files.add',
                    'showPossibleLocalizationRecords' => true,
                ],
            ],
        ],
        'categories' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_tca.xlf:sys_category.categories',
            'config' => [
                'type' => 'category',
            ],
        ],
        'category' => [
            'exclude' => true,
            'label' => $ll . '.category',
            'description' => $ll . '.category.description',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
            ],
        ],
        'author' => [
            'exclude' => true,
            'label' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.author_formlabel',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
            ],
        ],
        'notes' => [
            'label' => $ll . '.notes',
            'config' => [
                'type' => 'text',
                'rows' => 10,
                'cols' => 48,
            ],
        ],
    ],
];
