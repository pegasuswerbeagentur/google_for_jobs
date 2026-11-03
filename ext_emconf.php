<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Google for Jobs',
    'description' => 'Job postings with Google for Jobs structured data (JSON-LD JobPosting).',
    'category' => 'plugin',
    'author' => 'PEGASUS Werbeagentur GmbH',
    'author_email' => 'info@pega-sus.de',
    'author_company' => 'PEGASUS Werbeagentur GmbH',
    'state' => 'stable',
    'version' => '3.0.0',
    'constraints' => [
        'depends' => [
            'php' => '8.2.0-8.5.99',
            'typo3' => '13.4.37-14.3.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
