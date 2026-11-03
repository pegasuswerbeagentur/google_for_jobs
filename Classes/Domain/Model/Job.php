<?php

declare(strict_types=1);

namespace Pegasus\GoogleForJobs\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/***
 *
 * This file is part of the "Google for Jobs" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2019 Michael Kunst <kunst@pega-sus.de>, PEGASUS Werbeagentur GmbH
 *
 ***/
/**
 * Jobs
 */
class Job extends AbstractEntity
{
    /**
     * The original date that employer posted the job in ISO 8601 format. For example,
     * "2017-01-24" or "2017-01-24T19:33:17+00:00".
     *
     * @var \DateTime
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     */
    protected $datePosted = null;

    /**
     * The full description of the job in HTML format. The description should be a
     * complete representation of the job, including job responsibilities,
     * qualifications, skills, working hours, education requirements, and experience
     * requirements. The description can't be the same as the title.
     *
     * @var string
     */
    protected $description = '';

    /**
     * The organization offering the job position. This should be the name of the
     * company, and not the specific location that is hiring.
     *
     * @var string
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     */
    protected $hiringOrganizationName = '';

    /**
     * The website of the organization offering the job position.
     *
     * @var string
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     */
    protected $hiringOrganizationWebsite = '';

    /**
     * If you have a third-party job site, you can provide a different logo for a given
     * organization than the image shown in the organization's Knowledge Graph card.
     *
     * @var string
     */
    protected $hiringOrganizationLogoUrl = '';

    /**
     * The physical location(s) of the business where the employee will report to work.
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Pegasus\GoogleForJobs\Domain\Model\JobLocation>
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     * @TYPO3\CMS\Extbase\Annotation\ORM\Lazy
     */
    protected $jobLocations = null;

    /**
     * The title of the job. For example, "Software Engineer" or "Barista".
     *
     * @var string
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     */
    protected $title = '';

    /**
     * The date when the job posting will expire in ISO 8601 format. For example,
     * "2017-02-24".
     *
     * @var \DateTime
     */
    protected $validThrough = null;

    /**
     * The currency of the base salary for the job.
     *
     * @var string
     */
    protected $baseSalaryCurrency = '';

    /**
     * For the unitText of the base salary, use one of the following case-sensitive
     * values: "HOUR","DAY","WEEK","MONTH","YEAR"
     *
     * @var string
     */
    protected $baseSalaryUnitText = '';

    /**
     * The actual base salary for the job, as provided by the employer (not an
     * estimate).
     *
     * @var float
     */
    protected $baseSalaryValue = 0.0;

    /**
     * Type of employment. Choose one or more of the following case-sensitive values:
     * "FULL_TIME", "PART_TIME", "CONTRACTOR", "TEMPORARY", "INTERN", "VOLUNTEER"
     * "PER_DIEM"
     * "OTHER"
     *
     * @var string
     */
    protected $employmentType = '';

    /**
     * Set this property with the value TELECOMMUTE for jobs in which the employee may
     * or must work remotely 100% of the time.
     *
     * @var string
     */
    protected $jobLocationType = '';

    /**
     * The country in which employees may be located for to be eligible for the remote
     * job.
     *
     * @var string
     */
    protected $applicantLocationRequirements = '';

    /**
     * @var string
     */
    protected $pathSegment;

    /**
     * Fal media items
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
     */
    protected $falMedia;

    /**
     * Fal related files
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
     */
    protected $falRelatedFiles;

    /**
     * @var string
     */
    protected $author;

    /**
     * @var string
     */
    protected $alternativeTitle;

    /**
     * @var string
     */
    protected $category;

    /**
     * @var string
     */
    protected $notes;

    /**
     * __construct
     */
    public function __construct()
    {
        $this->initStorageObjects();
    }

    protected function initStorageObjects(): void
    {
        $this->falMedia = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->falRelatedFiles = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->jobLocations = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }

    /**
     * Get path segment
     */
    public function getPathSegment(): string
    {
        return $this->pathSegment;
    }

    /**
     * Set path segment
     */
    public function setPathSegment(string $pathSegment): void
    {
        $this->pathSegment = $pathSegment;
    }

    /**
     * Get the Fal media items
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
     */
    public function getFalMedia(): ObjectStorage
    {
        return $this->falMedia;
    }

    /**
     * Set Fal media relation
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference> $falMedia
     */
    public function setFalMedia(ObjectStorage $falMedia): void
    {
        $this->falMedia = $falMedia;
    }

    /**
     * Get FAL related files
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
     */
    public function getFalRelatedFiles(): ObjectStorage
    {
        return $this->falRelatedFiles;
    }

    /**
     * Set FAL related files
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference> $falRelatedFiles
     */
    public function setFalRelatedFiles(ObjectStorage $falRelatedFiles): void
    {
        $this->falRelatedFiles = $falRelatedFiles;
    }

    /**
     * Get author
     */
    public function getAuthor(): string
    {
        return $this->author;
    }

    /**
     * Set author
     *
     * @param string $author author
     */
    public function setAuthor(string $author): void
    {
        $this->author = $author;
    }

    /**
     * Get alternative title
     */
    public function getAlternativeTitle(): string
    {
        return $this->alternativeTitle;
    }

    /**
     * Set alternative title
     */
    public function setAlternativeTitle(string $alternativeTitle): void
    {
        $this->alternativeTitle = $alternativeTitle;
    }

    /**
     * Get category
     */
    public function getCategory(): string
    {
        return $this->category;
    }

    /**
     * Set category
     *
     * @param string $category category
     */
    public function setCategory(string $category): void
    {
        $this->category = $category;
    }

    /**
     * Get notes
     */
    public function getNotes(): string
    {
        return $this->notes;
    }

    /**
     * Set notes
     */
    public function setNotes(string $notes): void
    {
        $this->notes = $notes;
    }

    /**
     * Returns the datePosted
     *
     * @return \DateTime $datePosted
     */
    public function getDatePosted(): \DateTime
    {
        return $this->datePosted;
    }

    /**
     * Sets the datePosted
     */
    public function setDatePosted(\DateTime $datePosted): void
    {
        $this->datePosted = $datePosted;
    }

    /**
     * Returns the description
     *
     * @return string $description
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Sets the description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * Returns the hiringOrganizationName
     *
     * @return string $hiringOrganizationName
     */
    public function getHiringOrganizationName(): string
    {
        return $this->hiringOrganizationName;
    }

    /**
     * Sets the hiringOrganizationName
     */
    public function setHiringOrganizationName(string $hiringOrganizationName): void
    {
        $this->hiringOrganizationName = $hiringOrganizationName;
    }

    /**
     * Returns the hiringOrganizationWebsite
     *
     * @return string $hiringOrganizationWebsite
     */
    public function getHiringOrganizationWebsite(): string
    {
        return $this->hiringOrganizationWebsite;
    }

    /**
     * Sets the hiringOrganizationWebsite
     */
    public function setHiringOrganizationWebsite(string $hiringOrganizationWebsite): void
    {
        $this->hiringOrganizationWebsite = $hiringOrganizationWebsite;
    }

    /**
     * Returns the hiringOrganizationLogoUrl
     *
     * @return string $hiringOrganizationLogoUrl
     */
    public function getHiringOrganizationLogoUrl(): string
    {
        return $this->hiringOrganizationLogoUrl;
    }

    /**
     * Sets the hiringOrganizationLogoUrl
     */
    public function setHiringOrganizationLogoUrl(string $hiringOrganizationLogoUrl): void
    {
        $this->hiringOrganizationLogoUrl = $hiringOrganizationLogoUrl;
    }

    /**
     * Returns the jobLocations
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Pegasus\GoogleForJobs\Domain\Model\JobLocation>
     */
    public function getJobLocations(): ObjectStorage
    {
        return $this->jobLocations;
    }

    /**
     * Sets the jobLocations
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Pegasus\GoogleForJobs\Domain\Model\JobLocation>
     */
    public function setJobLocations(ObjectStorage $jobLocations): void
    {
        $this->jobLocations = $jobLocations;
    }

    /**
     * Returns the title
     *
     * @return string $title
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Sets the title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * Returns the validThrough
     *
     * @return \DateTime|null $validThrough
     */
    public function getValidThrough(): ?\DateTime
    {
        return $this->validThrough;
    }

    /**
     * Sets the validThrough
     */
    public function setValidThrough(\DateTime $validThrough): void
    {
        $this->validThrough = $validThrough;
    }

    /**
     * Returns the baseSalaryCurrency
     *
     * @return string $baseSalaryCurrency
     */
    public function getBaseSalaryCurrency(): string
    {
        return $this->baseSalaryCurrency;
    }

    /**
     * Sets the baseSalaryCurrency
     */
    public function setBaseSalaryCurrency(string $baseSalaryCurrency): void
    {
        $this->baseSalaryCurrency = $baseSalaryCurrency;
    }

    /**
     * Returns the baseSalaryUnitText
     *
     * @return string $baseSalaryUnitText
     */
    public function getBaseSalaryUnitText(): string
    {
        return $this->baseSalaryUnitText;
    }

    /**
     * Sets the baseSalaryUnitText
     */
    public function setBaseSalaryUnitText(string $baseSalaryUnitText): void
    {
        $this->baseSalaryUnitText = $baseSalaryUnitText;
    }

    /**
     * Returns the baseSalaryValue
     *
     * @return float $baseSalaryValue
     */
    public function getBaseSalaryValue(): float
    {
        return $this->baseSalaryValue;
    }

    /**
     * Sets the baseSalaryValue
     */
    public function setBaseSalaryValue(float $baseSalaryValue): void
    {
        $this->baseSalaryValue = $baseSalaryValue;
    }

    /**
     * Returns the employmentType
     *
     * @return string $employmentType
     */
    public function getEmploymentType(): string
    {
        return $this->employmentType;
    }

    /**
     * Sets the employmentType
     */
    public function setEmploymentType(string $employmentType): void
    {
        $this->employmentType = $employmentType;
    }

    /**
     * Returns the jobLocationType
     *
     * @return string $jobLocationType
     */
    public function getJobLocationType(): string
    {
        return $this->jobLocationType;
    }

    /**
     * Sets the jobLocationType
     */
    public function setJobLocationType(string $jobLocationType): void
    {
        $this->jobLocationType = $jobLocationType;
    }

    /**
     * Returns the applicantLocationRequirements
     *
     * @return string $applicantLocationRequirements
     */
    public function getApplicantLocationRequirements(): string
    {
        return $this->applicantLocationRequirements;
    }

    /**
     * Sets the applicantLocationRequirements
     */
    public function setApplicantLocationRequirements(string $applicantLocationRequirements): void
    {
        $this->applicantLocationRequirements = $applicantLocationRequirements;
    }

    /**
     * Creates and returns Structured Data JSON string from job data for output
     */
    public function createStructuredData(): string
    {
        $data = [];
        // mandatory key/value
        $data['@context'] = 'https://schema.org/';
        // mandatory key/value
        $data['@type'] = 'JobPosting';
        // title of the job offer
        $data['title'] = htmlspecialchars($this->getTitle());
        // Full HTML description of the job offer
        $data['description'] = htmlspecialchars($this->getDescription());
        // Creation date of the job offer, converts crdate field (unix time) to Y-m-d format
        $data['datePosted'] = htmlspecialchars($this->getDatePosted()->format('Y-m-d'));
        // date through which the offer is valid (format: Y-m-d)
        $validThrough =  $this->getValidThrough();
        if ($validThrough) {
            $data['validThrough'] = htmlspecialchars($validThrough->format('Y-m-d'));
        }
        // type of employment (valid values: FULL_TIME, PART_TIME, CONTRACTOR, TEMPORARY, INTERN, VOLUNTEER, PER_DIEM, OTHER)
        $data['employmentType'] = explode(',', htmlspecialchars($this->getEmploymentType()));

        // mandatory key/value
        $data['identifier']['@type'] = 'PropertyValue';
        // name of the offering organization
        $data['identifier']['name'] = htmlspecialchars($this->getHiringOrganizationName());
        // unique ID for the job offer, uses the CE uid converted to a string
        $data['identifier']['value'] = $this->getUid();

        // mandatory key/value
        $data['hiringOrganization']['@type'] = 'Organization';
        // name of the offering organization
        $data['hiringOrganization']['name'] = htmlspecialchars($this->getHiringOrganizationName());
        // website of the hiring organization
        $data['hiringOrganization']['sameAs'] = htmlspecialchars($this->getHiringOrganizationWebsite());
        // logo of the hiring organization
        $data['hiringOrganization']['logo'] = htmlspecialchars($this->getHiringOrganizationLogoUrl());

        foreach ($this->getJobLocations() as $jobLocation) {
            $location = [];
            // mandatory key/value
            $location['@type'] = 'Place';
            // mandatory key/value
            $location['address']['@type'] = 'PostalAddress';
            // street and no. of the job location
            $location['address']['streetAddress'] = htmlspecialchars($jobLocation->getStreetAddress());
            // city of the job location
            $location['address']['addressLocality'] = htmlspecialchars($jobLocation->getCity());
            // region of the job location
            $location['address']['addressRegion'] = htmlspecialchars($jobLocation->getRegion());
            // postal code of the job location
            $location['address']['postalCode'] = htmlspecialchars($jobLocation->getPostalCode());
            // country of the job location
            $location['address']['addressCountry'] = htmlspecialchars($jobLocation->getCountry());

            $data['jobLocation'][] = $location;
        }

        $data['baseSalary']['@type'] = 'MonetaryAmount';
        $data['baseSalary']['currency'] = htmlspecialchars($this->getBaseSalaryCurrency());
        $data['baseSalary']['value']['@type'] = 'QuantitativeValue';
        $data['baseSalary']['value']['value'] = $this->getBaseSalaryValue();
        $data['baseSalary']['value']['unitText'] = htmlspecialchars($this->getBaseSalaryUnitText());

        if ($this->getJobLocationType()) {
            $data['jobLocationType'] = 'TELECOMMUTE';
            $data['applicantLocationRequirement']['@type'] = 'Country';
            $data['applicantLocationRequirement']['name'] = htmlspecialchars($this->getApplicantLocationRequirements());
        }

        $jsonData = json_encode($data);

        // add script tag
        $sturcturedData = '<script type="application/ld+json">' . $jsonData . '</script>';

        return $sturcturedData;
    }
}
