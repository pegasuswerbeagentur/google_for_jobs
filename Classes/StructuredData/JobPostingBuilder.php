<?php

declare(strict_types=1);

namespace Pegasus\GoogleForJobs\StructuredData;

use Pegasus\GoogleForJobs\Domain\Model\Job;
use Pegasus\GoogleForJobs\Domain\Model\JobLocation;

/*
 * This file is part of the "Google for Jobs" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

/**
 * Builds the schema.org JobPosting structured data of a job as described in
 * https://developers.google.com/search/docs/appearance/structured-data/job-posting
 */
class JobPostingBuilder
{
    public const EMPLOYMENT_TYPES = ['FULL_TIME', 'PART_TIME', 'CONTRACTOR', 'TEMPORARY', 'INTERN', 'VOLUNTEER', 'PER_DIEM', 'OTHER'];

    public const SALARY_UNITS = ['HOUR', 'DAY', 'WEEK', 'MONTH', 'YEAR'];

    public const CREDENTIAL_CATEGORIES = ['high school', 'associate degree', 'bachelor degree', 'professional certificate', 'postgraduate degree'];

    /**
     * @param (\Closure(string): string)|null $urlResolver Turns a stored link (e.g. t3://file?uid=1) into an absolute URL
     * @return array<string, mixed>
     */
    public function build(Job $job, ?\Closure $urlResolver = null): array
    {
        $urlResolver ??= static fn(string $link): string => $link;

        $data = [
            '@context' => 'https://schema.org/',
            '@type' => 'JobPosting',
            'title' => trim($job->getTitle()),
            'description' => trim($job->getDescription()),
        ];

        if ($job->getDatePosted() !== null) {
            $data['datePosted'] = $job->getDatePosted()->format('Y-m-d');
        }
        if ($job->getValidThrough() !== null) {
            $data['validThrough'] = (clone $job->getValidThrough())->setTime(23, 59, 59)->format(\DateTimeInterface::ATOM);
        }

        $employmentTypes = array_values(array_intersect($job->getEmploymentTypes(), self::EMPLOYMENT_TYPES));
        if ($employmentTypes !== []) {
            $data['employmentType'] = count($employmentTypes) === 1 ? $employmentTypes[0] : $employmentTypes;
        }

        $data['hiringOrganization'] = $this->buildHiringOrganization($job, $urlResolver);
        $data['identifier'] = [
            '@type' => 'PropertyValue',
            'name' => trim($job->getHiringOrganizationName()),
            'value' => trim($job->getIdentifier()) !== '' ? trim($job->getIdentifier()) : (string)$job->getUid(),
        ];

        $jobLocations = [];
        foreach ($job->getJobLocations() as $jobLocation) {
            $place = $this->buildPlace($jobLocation);
            if ($place !== null) {
                $jobLocations[] = $place;
            }
        }
        if ($jobLocations !== []) {
            $data['jobLocation'] = count($jobLocations) === 1 ? $jobLocations[0] : $jobLocations;
        }

        if ($job->isRemote()) {
            $data['jobLocationType'] = 'TELECOMMUTE';
            $countries = array_map(
                static fn(string $country): array => ['@type' => 'Country', 'name' => $country],
                $job->getApplicantLocationRequirementsList(),
            );
            if ($countries !== []) {
                $data['applicantLocationRequirements'] = count($countries) === 1 ? $countries[0] : $countries;
            }
        }

        $baseSalary = $this->buildBaseSalary($job);
        if ($baseSalary !== null) {
            $data['baseSalary'] = $baseSalary;
        }

        if ($job->getDirectApply() === Job::DIRECT_APPLY_YES) {
            $data['directApply'] = true;
        } elseif ($job->getDirectApply() === Job::DIRECT_APPLY_NO) {
            $data['directApply'] = false;
        }

        $educationRequirements = $this->buildEducationRequirements($job);
        if ($educationRequirements !== null) {
            $data['educationRequirements'] = $educationRequirements;
        }
        $experienceRequirements = $this->buildExperienceRequirements($job);
        if ($experienceRequirements !== null) {
            $data['experienceRequirements'] = $experienceRequirements;
        }
        if ($job->getExperienceInPlaceOfEducation()
            && is_array($educationRequirements)
            && is_array($experienceRequirements)
        ) {
            $data['experienceInPlaceOfEducation'] = true;
        }

        return $data;
    }

    /**
     * Renders the data as JSON-LD script tag. Characters that could end the
     * script tag are escaped, HTML in the description stays intact.
     *
     * @param array<string, mixed> $data
     */
    public function render(array $data): string
    {
        $json = json_encode(
            $data,
            JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_INVALID_UTF8_SUBSTITUTE | JSON_THROW_ON_ERROR,
        );
        return '<script type="application/ld+json">' . $json . '</script>';
    }

    /**
     * @param \Closure(string): string $urlResolver
     * @return array<string, string>
     */
    private function buildHiringOrganization(Job $job, \Closure $urlResolver): array
    {
        $organization = [
            '@type' => 'Organization',
            'name' => trim($job->getHiringOrganizationName()),
        ];
        $website = $this->resolveUrl($job->getHiringOrganizationWebsite(), $urlResolver);
        if ($website !== '') {
            $organization['sameAs'] = $website;
        }
        $logo = $this->resolveUrl($job->getHiringOrganizationLogoUrl(), $urlResolver);
        if ($logo !== '') {
            $organization['logo'] = $logo;
        }
        return $organization;
    }

    /**
     * @return array<string, mixed>|null
     */
    private function buildPlace(JobLocation $jobLocation): ?array
    {
        $address = array_filter([
            'streetAddress' => trim($jobLocation->getStreetAddress()),
            'addressLocality' => trim($jobLocation->getCity()),
            'addressRegion' => trim($jobLocation->getRegion()),
            'postalCode' => trim($jobLocation->getPostalCode()),
            'addressCountry' => trim($jobLocation->getCountry()),
        ], static fn(string $value): bool => $value !== '');

        if ($address === []) {
            return null;
        }
        return [
            '@type' => 'Place',
            'address' => ['@type' => 'PostalAddress'] + $address,
        ];
    }

    /**
     * @return array<string, mixed>|null
     */
    private function buildBaseSalary(Job $job): ?array
    {
        if (!$job->getBaseSalaryEnable() || trim($job->getBaseSalaryCurrency()) === '') {
            return null;
        }

        $value = ['@type' => 'QuantitativeValue'];
        $minValue = $job->getBaseSalaryMinValue();
        $maxValue = $job->getBaseSalaryMaxValue();
        if ($minValue > 0 && $maxValue >= $minValue) {
            $value['minValue'] = $minValue;
            $value['maxValue'] = $maxValue;
        } elseif ($job->getBaseSalaryValue() > 0) {
            $value['value'] = $job->getBaseSalaryValue();
        } elseif ($minValue > 0) {
            $value['minValue'] = $minValue;
        } else {
            return null;
        }
        if (in_array($job->getBaseSalaryUnitText(), self::SALARY_UNITS, true)) {
            $value['unitText'] = $job->getBaseSalaryUnitText();
        }

        return [
            '@type' => 'MonetaryAmount',
            'currency' => strtoupper(trim($job->getBaseSalaryCurrency())),
            'value' => $value,
        ];
    }

    /**
     * @return string|array<mixed>|null
     */
    private function buildEducationRequirements(Job $job): string|array|null
    {
        $requirements = $job->getEducationRequirementsList();
        if (in_array(Job::NO_REQUIREMENTS, $requirements, true)) {
            return Job::NO_REQUIREMENTS;
        }
        $credentials = [];
        foreach (array_intersect($requirements, self::CREDENTIAL_CATEGORIES) as $category) {
            $credentials[] = ['@type' => 'EducationalOccupationalCredential', 'credentialCategory' => $category];
        }
        if ($credentials === []) {
            return null;
        }
        return count($credentials) === 1 ? $credentials[0] : $credentials;
    }

    /**
     * @return string|array<string, mixed>|null
     */
    private function buildExperienceRequirements(Job $job): string|array|null
    {
        $months = $job->getExperienceMonths();
        if ($months === null || $months < 0) {
            return null;
        }
        if ($months === 0) {
            return Job::NO_REQUIREMENTS;
        }
        return ['@type' => 'OccupationalExperienceRequirements', 'monthsOfExperience' => $months];
    }

    /**
     * @param \Closure(string): string $urlResolver
     */
    private function resolveUrl(string $link, \Closure $urlResolver): string
    {
        $link = trim($link);
        return $link === '' ? '' : trim($urlResolver($link));
    }
}
