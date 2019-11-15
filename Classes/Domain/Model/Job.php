<?php
namespace Pegasus\GoogleForJobs\Domain\Model;


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
class Job extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * The original date that employer posted the job in ISO 8601 format. For example,
     * "2017-01-24" or "2017-01-24T19:33:17+00:00".
     * 
     * @var \DateTime
     * @validate NotEmpty
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
     * @validate NotEmpty
     */
    protected $hiringOrganizationName = '';

    /**
     * The website of the organization offering the job position.
     * 
     * @var string
     * @validate NotEmpty
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
     * The Street and No. of the business where the employee will report to work.
     * 
     * @var string
     * @validate NotEmpty
     */
    protected $jobLocationStreetAddress = '';

    /**
     * The city of the business where the employee will report to work.
     * 
     * @var string
     * @validate NotEmpty
     */
    protected $jobLocationCity = '';

    /**
     * The postal code of the business where the employee will report to work.
     * 
     * @var string
     * @validate NotEmpty
     */
    protected $jobLocationPostalCode = '';

    /**
     * The region of the business where the employee will report to work. For example,
     * California or another appropriate first-level Administrative division.
     * 
     * @var string
     * @validate NotEmpty
     */
    protected $jobLocationRegion = '';

    /**
     * The country of the business where the employee will report to work. For example,
     * USA. You can also provide the two-letter ISO 3166-1 alpha-2 country code.
     * 
     * @var string
     * @validate NotEmpty
     */
    protected $jobLocationCountry = '';

    /**
     * The title of the job. For example, "Software Engineer" or "Barista".
     * 
     * @var string
     * @validate NotEmpty
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

    /** @var string */
    protected $notes;

    /**
     * __construct
     */
    public function __construct()
    {
        $this->initStorageObjects();
    }

    /**
     * @return void
     */
    protected function initStorageObjects()
    {
        $this->falMedia = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->falRelatedFiles = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }

    /**
     * Get path segment
     *
     * @return string
     */
    public function getPathSegment()
    {
        return $this->pathSegment;
    }

    /**
     * Set path segment
     *
     * @param string $pathSegment
     */
    public function setPathSegment($pathSegment)
    {
        $this->pathSegment = $pathSegment;
    }

    /**
     * Get the Fal media items
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference> $falMedia
     */
    public function getFalMedia()
    {
        return $this->falMedia;
    }

    /**
     * Set Fal media relation
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference> $falMedia
     */
    public function setFalMedia(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $falMedia)
    {
        $this->falMedia = $falMedia;
    }

    /**
     * Get FAL related files
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference> $falRelatedFiles
     */
    public function getFalRelatedFiles()
    {
        return $this->falRelatedFiles;
    }

    /**
     * Set FAL related files
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference> $falRelatedFiles
     */
    public function setFalRelatedFiles($falRelatedFiles)
    {
        $this->falRelatedFiles = $falRelatedFiles;
    }

    /**
     * Get author
     *
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set author
     *
     * @param string $author author
     */
    public function setAuthor($author)
    {
        $this->author = $author;
    }

    /**
     * Get alternative title
     *
     * @return string
     */
    public function getAlternativeTitle()
    {
        return $this->alternativeTitle;
    }

    /**
     * Set alternative title
     *
     * @param string $alternativeTitle
     */
    public function setAlternativeTitle($alternativeTitle)
    {
        $this->alternativeTitle = $alternativeTitle;
    }

    /**
     * Get category
     *
     * @return string
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set category
     *
     * @param string $category category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }

    /**
     * @return string
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * @param string $notes
     */
    public function setNotes(string $notes)
    {
        $this->notes = $notes;
    }

    /**
     * Returns the datePosted
     * 
     * @return \DateTime $datePosted
     */
    public function getDatePosted()
    {
        return $this->datePosted;
    }

    /**
     * Sets the datePosted
     * 
     * @param \DateTime $datePosted
     * @return void
     */
    public function setDatePosted(\DateTime $datePosted)
    {
        $this->datePosted = $datePosted;
    }

    /**
     * Returns the description
     * 
     * @return string $description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Sets the description
     * 
     * @param string $description
     * @return void
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Returns the hiringOrganizationName
     * 
     * @return string $hiringOrganizationName
     */
    public function getHiringOrganizationName()
    {
        return $this->hiringOrganizationName;
    }

    /**
     * Sets the hiringOrganizationName
     * 
     * @param string $hiringOrganizationName
     * @return void
     */
    public function setHiringOrganizationName($hiringOrganizationName)
    {
        $this->hiringOrganizationName = $hiringOrganizationName;
    }

    /**
     * Returns the hiringOrganizationWebsite
     * 
     * @return string $hiringOrganizationWebsite
     */
    public function getHiringOrganizationWebsite()
    {
        return $this->hiringOrganizationWebsite;
    }

    /**
     * Sets the hiringOrganizationWebsite
     * 
     * @param string $hiringOrganizationWebsite
     * @return void
     */
    public function setHiringOrganizationWebsite($hiringOrganizationWebsite)
    {
        $this->hiringOrganizationWebsite = $hiringOrganizationWebsite;
    }

    /**
     * Returns the hiringOrganizationLogoUrl
     * 
     * @return string $hiringOrganizationLogoUrl
     */
    public function getHiringOrganizationLogoUrl()
    {
        return $this->hiringOrganizationLogoUrl;
    }

    /**
     * Sets the hiringOrganizationLogoUrl
     * 
     * @param string $hiringOrganizationLogoUrl
     * @return void
     */
    public function setHiringOrganizationLogoUrl($hiringOrganizationLogoUrl)
    {
        $this->hiringOrganizationLogoUrl = $hiringOrganizationLogoUrl;
    }

    /**
     * Returns the jobLocationStreetAddress
     * 
     * @return string $jobLocationStreetAddress
     */
    public function getJobLocationStreetAddress()
    {
        return $this->jobLocationStreetAddress;
    }

    /**
     * Sets the jobLocationStreetAddress
     * 
     * @param string $jobLocationStreetAddress
     * @return void
     */
    public function setJobLocationStreetAddress($jobLocationStreetAddress)
    {
        $this->jobLocationStreetAddress = $jobLocationStreetAddress;
    }

    /**
     * Returns the jobLocationCity
     * 
     * @return string $jobLocationCity
     */
    public function getJobLocationCity()
    {
        return $this->jobLocationCity;
    }

    /**
     * Sets the jobLocationCity
     * 
     * @param string $jobLocationCity
     * @return void
     */
    public function setJobLocationCity($jobLocationCity)
    {
        $this->jobLocationCity = $jobLocationCity;
    }

    /**
     * Returns the jobLocationPostalCode
     * 
     * @return string $jobLocationPostalCode
     */
    public function getJobLocationPostalCode()
    {
        return $this->jobLocationPostalCode;
    }

    /**
     * Sets the jobLocationPostalCode
     * 
     * @param string $jobLocationPostalCode
     * @return void
     */
    public function setJobLocationPostalCode($jobLocationPostalCode)
    {
        $this->jobLocationPostalCode = $jobLocationPostalCode;
    }

    /**
     * Returns the jobLocationRegion
     * 
     * @return string $jobLocationRegion
     */
    public function getJobLocationRegion()
    {
        return $this->jobLocationRegion;
    }

    /**
     * Sets the jobLocationRegion
     * 
     * @param string $jobLocationRegion
     * @return void
     */
    public function setJobLocationRegion($jobLocationRegion)
    {
        $this->jobLocationRegion = $jobLocationRegion;
    }

    /**
     * Returns the jobLocationCountry
     * 
     * @return string $jobLocationCountry
     */
    public function getJobLocationCountry()
    {
        return $this->jobLocationCountry;
    }

    /**
     * Sets the jobLocationCountry
     * 
     * @param string $jobLocationCountry
     * @return void
     */
    public function setJobLocationCountry($jobLocationCountry)
    {
        $this->jobLocationCountry = $jobLocationCountry;
    }

    /**
     * Returns the title
     * 
     * @return string $title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Sets the title
     * 
     * @param string $title
     * @return void
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Returns the validThrough
     * 
     * @return \DateTime $validThrough
     */
    public function getValidThrough()
    {
        return $this->validThrough;
    }

    /**
     * Sets the validThrough
     * 
     * @param \DateTime $validThrough
     * @return void
     */
    public function setValidThrough(\DateTime $validThrough)
    {
        $this->validThrough = $validThrough;
    }

    /**
     * Returns the baseSalaryCurrency
     * 
     * @return string $baseSalaryCurrency
     */
    public function getBaseSalaryCurrency()
    {
        return $this->baseSalaryCurrency;
    }

    /**
     * Sets the baseSalaryCurrency
     * 
     * @param string $baseSalaryCurrency
     * @return void
     */
    public function setBaseSalaryCurrency($baseSalaryCurrency)
    {
        $this->baseSalaryCurrency = $baseSalaryCurrency;
    }

    /**
     * Returns the baseSalaryUnitText
     * 
     * @return string $baseSalaryUnitText
     */
    public function getBaseSalaryUnitText()
    {
        return $this->baseSalaryUnitText;
    }

    /**
     * Sets the baseSalaryUnitText
     * 
     * @param string $baseSalaryUnitText
     * @return void
     */
    public function setBaseSalaryUnitText($baseSalaryUnitText)
    {
        $this->baseSalaryUnitText = $baseSalaryUnitText;
    }

    /**
     * Returns the baseSalaryValue
     * 
     * @return float $baseSalaryValue
     */
    public function getBaseSalaryValue()
    {
        return $this->baseSalaryValue;
    }

    /**
     * Sets the baseSalaryValue
     * 
     * @param float $baseSalaryValue
     * @return void
     */
    public function setBaseSalaryValue($baseSalaryValue)
    {
        $this->baseSalaryValue = $baseSalaryValue;
    }

    /**
     * Returns the employmentType
     * 
     * @return string $employmentType
     */
    public function getEmploymentType()
    {
        return $this->employmentType;
    }

    /**
     * Sets the employmentType
     * 
     * @param string $employmentType
     * @return void
     */
    public function setEmploymentType($employmentType)
    {
        $this->employmentType = $employmentType;
    }

    /**
     * Returns the jobLocationType
     * 
     * @return string $jobLocationType
     */
    public function getJobLocationType()
    {
        return $this->jobLocationType;
    }

    /**
     * Sets the jobLocationType
     * 
     * @param string $jobLocationType
     * @return void
     */
    public function setJobLocationType($jobLocationType)
    {
        $this->jobLocationType = $jobLocationType;
    }

    /**
     * Returns the applicantLocationRequirements
     * 
     * @return string $applicantLocationRequirements
     */
    public function getApplicantLocationRequirements()
    {
        return $this->applicantLocationRequirements;
    }

    /**
     * Sets the applicantLocationRequirements
     * 
     * @param string $applicantLocationRequirements
     * @return void
     */
    public function setApplicantLocationRequirements($applicantLocationRequirements)
    {
        $this->applicantLocationRequirements = $applicantLocationRequirements;
    }

    /**
     * Creates and returns Structured Data JSON string from job data for output 
     */
    public function createStructuredData()
    {   
        $data = [];
        // mandatory key/value
        $data['@context'] = "https://schema.org/";
        // mandatory key/value
        $data['@type'] = 'JobPosting';
        // title of the job offer
        $data['title'] = $this->getTitle();
        // Full HTML description of the job offer
        $data['description'] = $this->getDescription();
        // Creation date of the job offer, converts crdate field (unix time) to Y-m-d format
        $data['datePosted'] = $this->getDatePosted()->format('Y-m-d');
        // date through which the offer is valid (format: Y-m-d)
        $data['validThrough'] = $this->getValidThrough()->format('Y-m-d');
        // type of employment (valid values: FULL_TIME, PART_TIME, CONTRACTOR, TEMPORARY, INTERN, VOLUNTEER, PER_DIEM, OTHER)
        $data['employmentType'] = explode(',', $this->getEmploymentType());
 
        // mandatory key/value
        $data['identifier']['@type'] = 'PropertyValue';
        // name of the offering organization
        $data['identifier']['name'] = $this->getHiringOrganizationName();
        // unique ID for the job offer, uses the CE uid converted to a string
        $data['identifier']['value'] = $this->getUid();
 
        // mandatory key/value
        $data['hiringOrganization']['@type'] = 'Organization';
        // name of the offering organization
        $data['hiringOrganization']['name'] = $this->getHiringOrganizationName();
        // website of the hiring organization
        $data['hiringOrganization']['sameAs'] = $this->getHiringOrganizationWebsite();
 
        // mandatory key/value
        $data['jobLocation']['@type'] = 'Place';
        // mandatory key/value
        $data['jobLocation']['address']['@type'] = 'PostalAddress';
        // street and no. of the job location
        $data['jobLocation']['address']['streetAddress'] = $this->getJobLocationStreetAddress();
        // city of the job location
        $data['jobLocation']['address']['addressLocality'] = $this->getJobLocationCity();
        // region of the job location
        $data['jobLocation']['address']['addressRegion'] = $this->getJobLocationRegion();
        // postal code of the job location
        $data['jobLocation']['address']['postalCode'] = $this->getJobLocationPostalCode();
        // country of the job location
        $data['jobLocation']['address']['addressCountry'] = $this->getJobLocationCountry();

        $data['baseSalary']['@type'] = 'MonetaryAmount';
        $data['baseSalary']['currency'] = $this->getBaseSalaryCurrency();
        $data['baseSalary']['value']['@type'] = 'QuantitativeValue';
        $data['baseSalary']['value']['value'] = $this->getBaseSalaryValue();
        $data['baseSalary']['value']['unitText'] = $this->getBaseSalaryUnitText();

        if($this->getJobLocationType()) {
            $data['jobLocationType'] = 'TELECOMMUTE';
            $data['applicantLocationRequirement']['@type'] = 'Country';
            $data['applicantLocationRequirement']['name'] = $this->getApplicantLocationRequirements();
        }
 
        // convert data to JSON format while keeping certain characters unescaped
        // JSON_UNESCAPED_UNICODE: Don't escape unicode characters (e.g "&")
        // JSON_UNESCAPED_SLASHES: Don't escape slashes
        $jsonData = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        // add script tag
        $sturcturedData = '<script type="application/ld+json">' . $jsonData . '</script>';

        return $sturcturedData;
    }
}
