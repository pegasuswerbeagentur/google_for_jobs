<?php

declare(strict_types=1);

namespace Pegasus\GoogleForJobs\Domain\Model;

use TYPO3\CMS\Extbase\Annotation\ORM\Lazy;
use TYPO3\CMS\Extbase\Domain\Model\Category;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/*
 * This file is part of the "Google for Jobs" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

/**
 * Job posting, rendered as schema.org JobPosting on the detail page.
 */
class Job extends AbstractEntity
{
    public const DIRECT_APPLY_UNSPECIFIED = 0;
    public const DIRECT_APPLY_YES = 1;
    public const DIRECT_APPLY_NO = 2;

    public const NO_REQUIREMENTS = 'no requirements';

    protected string $title = '';

    protected string $alternativeTitle = '';

    protected string $pathSegment = '';

    protected string $description = '';

    protected string $employmentType = '';

    protected ?\DateTime $datePosted = null;

    protected ?\DateTime $validThrough = null;

    protected string $hiringOrganizationName = '';

    protected string $hiringOrganizationWebsite = '';

    protected string $hiringOrganizationLogoUrl = '';

    /**
     * @var ObjectStorage<JobLocation>
     */
    #[Lazy]
    protected ObjectStorage $jobLocations;

    protected bool $jobLocationType = false;

    protected string $applicantLocationRequirements = '';

    protected bool $baseSalaryEnable = false;

    protected string $baseSalaryCurrency = '';

    protected string $baseSalaryUnitText = '';

    protected float $baseSalaryValue = 0.0;

    protected float $baseSalaryMinValue = 0.0;

    protected float $baseSalaryMaxValue = 0.0;

    protected int $directApply = self::DIRECT_APPLY_UNSPECIFIED;

    protected string $identifier = '';

    protected string $educationRequirements = '';

    protected ?int $experienceMonths = null;

    protected bool $experienceInPlaceOfEducation = false;

    /**
     * @var ObjectStorage<FileReference>
     */
    protected ObjectStorage $falMedia;

    /**
     * @var ObjectStorage<FileReference>
     */
    protected ObjectStorage $falRelatedFiles;

    /**
     * @var ObjectStorage<Category>
     */
    #[Lazy]
    protected ObjectStorage $categories;

    protected string $category = '';

    protected string $author = '';

    protected string $notes = '';

    public function __construct()
    {
        $this->initializeObject();
    }

    public function initializeObject(): void
    {
        $this->jobLocations = new ObjectStorage();
        $this->falMedia = new ObjectStorage();
        $this->falRelatedFiles = new ObjectStorage();
        $this->categories = new ObjectStorage();
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getAlternativeTitle(): string
    {
        return $this->alternativeTitle;
    }

    public function setAlternativeTitle(string $alternativeTitle): void
    {
        $this->alternativeTitle = $alternativeTitle;
    }

    public function getPathSegment(): string
    {
        return $this->pathSegment;
    }

    public function setPathSegment(string $pathSegment): void
    {
        $this->pathSegment = $pathSegment;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getEmploymentType(): string
    {
        return $this->employmentType;
    }

    public function setEmploymentType(string $employmentType): void
    {
        $this->employmentType = $employmentType;
    }

    /**
     * @return list<string>
     */
    public function getEmploymentTypes(): array
    {
        return array_values(array_filter(array_map('trim', explode(',', $this->employmentType))));
    }

    public function getDatePosted(): ?\DateTime
    {
        return $this->datePosted;
    }

    public function setDatePosted(?\DateTime $datePosted): void
    {
        $this->datePosted = $datePosted;
    }

    public function getValidThrough(): ?\DateTime
    {
        return $this->validThrough;
    }

    public function setValidThrough(?\DateTime $validThrough): void
    {
        $this->validThrough = $validThrough;
    }

    public function getHiringOrganizationName(): string
    {
        return $this->hiringOrganizationName;
    }

    public function setHiringOrganizationName(string $hiringOrganizationName): void
    {
        $this->hiringOrganizationName = $hiringOrganizationName;
    }

    public function getHiringOrganizationWebsite(): string
    {
        return $this->hiringOrganizationWebsite;
    }

    public function setHiringOrganizationWebsite(string $hiringOrganizationWebsite): void
    {
        $this->hiringOrganizationWebsite = $hiringOrganizationWebsite;
    }

    public function getHiringOrganizationLogoUrl(): string
    {
        return $this->hiringOrganizationLogoUrl;
    }

    public function setHiringOrganizationLogoUrl(string $hiringOrganizationLogoUrl): void
    {
        $this->hiringOrganizationLogoUrl = $hiringOrganizationLogoUrl;
    }

    /**
     * @return ObjectStorage<JobLocation>
     */
    public function getJobLocations(): ObjectStorage
    {
        return $this->jobLocations;
    }

    /**
     * @param ObjectStorage<JobLocation> $jobLocations
     */
    public function setJobLocations(ObjectStorage $jobLocations): void
    {
        $this->jobLocations = $jobLocations;
    }

    public function addJobLocation(JobLocation $jobLocation): void
    {
        $this->jobLocations->attach($jobLocation);
    }

    public function getJobLocationType(): bool
    {
        return $this->jobLocationType;
    }

    public function setJobLocationType(bool $jobLocationType): void
    {
        $this->jobLocationType = $jobLocationType;
    }

    public function isRemote(): bool
    {
        return $this->jobLocationType;
    }

    public function getApplicantLocationRequirements(): string
    {
        return $this->applicantLocationRequirements;
    }

    public function setApplicantLocationRequirements(string $applicantLocationRequirements): void
    {
        $this->applicantLocationRequirements = $applicantLocationRequirements;
    }

    /**
     * @return list<string>
     */
    public function getApplicantLocationRequirementsList(): array
    {
        return array_values(array_filter(array_map('trim', preg_split('/[,;\n]/', $this->applicantLocationRequirements) ?: [])));
    }

    public function getBaseSalaryEnable(): bool
    {
        return $this->baseSalaryEnable;
    }

    public function setBaseSalaryEnable(bool $baseSalaryEnable): void
    {
        $this->baseSalaryEnable = $baseSalaryEnable;
    }

    public function getBaseSalaryCurrency(): string
    {
        return $this->baseSalaryCurrency;
    }

    public function setBaseSalaryCurrency(string $baseSalaryCurrency): void
    {
        $this->baseSalaryCurrency = $baseSalaryCurrency;
    }

    public function getBaseSalaryUnitText(): string
    {
        return $this->baseSalaryUnitText;
    }

    public function setBaseSalaryUnitText(string $baseSalaryUnitText): void
    {
        $this->baseSalaryUnitText = $baseSalaryUnitText;
    }

    public function getBaseSalaryValue(): float
    {
        return $this->baseSalaryValue;
    }

    public function setBaseSalaryValue(float $baseSalaryValue): void
    {
        $this->baseSalaryValue = $baseSalaryValue;
    }

    public function getBaseSalaryMinValue(): float
    {
        return $this->baseSalaryMinValue;
    }

    public function setBaseSalaryMinValue(float $baseSalaryMinValue): void
    {
        $this->baseSalaryMinValue = $baseSalaryMinValue;
    }

    public function getBaseSalaryMaxValue(): float
    {
        return $this->baseSalaryMaxValue;
    }

    public function setBaseSalaryMaxValue(float $baseSalaryMaxValue): void
    {
        $this->baseSalaryMaxValue = $baseSalaryMaxValue;
    }

    public function getDirectApply(): int
    {
        return $this->directApply;
    }

    public function setDirectApply(int $directApply): void
    {
        $this->directApply = $directApply;
    }

    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    public function setIdentifier(string $identifier): void
    {
        $this->identifier = $identifier;
    }

    public function getEducationRequirements(): string
    {
        return $this->educationRequirements;
    }

    public function setEducationRequirements(string $educationRequirements): void
    {
        $this->educationRequirements = $educationRequirements;
    }

    /**
     * @return list<string>
     */
    public function getEducationRequirementsList(): array
    {
        return array_values(array_filter(array_map('trim', explode(',', $this->educationRequirements))));
    }

    /**
     * Minimum months of experience; null if not specified, 0 if no experience is required.
     */
    public function getExperienceMonths(): ?int
    {
        return $this->experienceMonths;
    }

    public function setExperienceMonths(?int $experienceMonths): void
    {
        $this->experienceMonths = $experienceMonths;
    }

    public function isExperienceSpecified(): bool
    {
        return $this->experienceMonths !== null && $this->experienceMonths >= 0;
    }

    public function getExperienceInPlaceOfEducation(): bool
    {
        return $this->experienceInPlaceOfEducation;
    }

    public function setExperienceInPlaceOfEducation(bool $experienceInPlaceOfEducation): void
    {
        $this->experienceInPlaceOfEducation = $experienceInPlaceOfEducation;
    }

    /**
     * @return ObjectStorage<FileReference>
     */
    public function getFalMedia(): ObjectStorage
    {
        return $this->falMedia;
    }

    /**
     * @param ObjectStorage<FileReference> $falMedia
     */
    public function setFalMedia(ObjectStorage $falMedia): void
    {
        $this->falMedia = $falMedia;
    }

    /**
     * @return ObjectStorage<FileReference>
     */
    public function getFalRelatedFiles(): ObjectStorage
    {
        return $this->falRelatedFiles;
    }

    /**
     * @param ObjectStorage<FileReference> $falRelatedFiles
     */
    public function setFalRelatedFiles(ObjectStorage $falRelatedFiles): void
    {
        $this->falRelatedFiles = $falRelatedFiles;
    }

    /**
     * @return ObjectStorage<Category>
     */
    public function getCategories(): ObjectStorage
    {
        return $this->categories;
    }

    /**
     * @param ObjectStorage<Category> $categories
     */
    public function setCategories(ObjectStorage $categories): void
    {
        $this->categories = $categories;
    }

    public function getFirstCategory(): ?Category
    {
        foreach ($this->categories as $category) {
            return $category;
        }
        return null;
    }

    public function getCategory(): string
    {
        return $this->category;
    }

    public function setCategory(string $category): void
    {
        $this->category = $category;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function setAuthor(string $author): void
    {
        $this->author = $author;
    }

    public function getNotes(): string
    {
        return $this->notes;
    }

    public function setNotes(string $notes): void
    {
        $this->notes = $notes;
    }
}
