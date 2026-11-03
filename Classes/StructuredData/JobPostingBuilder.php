<?php

declare(strict_types=1);

namespace Pegasus\GoogleForJobs\StructuredData;

use Pegasus\GoogleForJobs\Domain\Model\Job;

/*
 * This file is part of the "Google for Jobs" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

/**
 * Builds the schema.org JobPosting structured data of a job.
 */
class JobPostingBuilder
{
    /**
     * @return array<string, mixed>
     */
    public function build(Job $job): array
    {
        $data = [
            '@context' => 'https://schema.org/',
            '@type' => 'JobPosting',
            'title' => htmlspecialchars($job->getTitle()),
            'description' => htmlspecialchars($job->getDescription()),
        ];
        if ($job->getDatePosted() !== null) {
            $data['datePosted'] = $job->getDatePosted()->format('Y-m-d');
        }
        if ($job->getValidThrough() !== null) {
            $data['validThrough'] = $job->getValidThrough()->format('Y-m-d');
        }
        $data['employmentType'] = explode(',', htmlspecialchars($job->getEmploymentType()));
        $data['identifier'] = [
            '@type' => 'PropertyValue',
            'name' => htmlspecialchars($job->getHiringOrganizationName()),
            'value' => $job->getUid(),
        ];
        $data['hiringOrganization'] = [
            '@type' => 'Organization',
            'name' => htmlspecialchars($job->getHiringOrganizationName()),
            'sameAs' => htmlspecialchars($job->getHiringOrganizationWebsite()),
            'logo' => htmlspecialchars($job->getHiringOrganizationLogoUrl()),
        ];
        foreach ($job->getJobLocations() as $jobLocation) {
            $data['jobLocation'][] = [
                '@type' => 'Place',
                'address' => [
                    '@type' => 'PostalAddress',
                    'streetAddress' => htmlspecialchars($jobLocation->getStreetAddress()),
                    'addressLocality' => htmlspecialchars($jobLocation->getCity()),
                    'addressRegion' => htmlspecialchars($jobLocation->getRegion()),
                    'postalCode' => htmlspecialchars($jobLocation->getPostalCode()),
                    'addressCountry' => htmlspecialchars($jobLocation->getCountry()),
                ],
            ];
        }
        $data['baseSalary'] = [
            '@type' => 'MonetaryAmount',
            'currency' => htmlspecialchars($job->getBaseSalaryCurrency()),
            'value' => [
                '@type' => 'QuantitativeValue',
                'value' => $job->getBaseSalaryValue(),
                'unitText' => htmlspecialchars($job->getBaseSalaryUnitText()),
            ],
        ];
        if ($job->isRemote()) {
            $data['jobLocationType'] = 'TELECOMMUTE';
            $data['applicantLocationRequirement'] = [
                '@type' => 'Country',
                'name' => htmlspecialchars($job->getApplicantLocationRequirements()),
            ];
        }
        return $data;
    }

    /**
     * @param array<string, mixed> $data
     */
    public function render(array $data): string
    {
        return '<script type="application/ld+json">' . json_encode($data) . '</script>';
    }
}
