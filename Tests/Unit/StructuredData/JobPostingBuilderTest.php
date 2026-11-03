<?php

declare(strict_types=1);

namespace Pegasus\GoogleForJobs\Tests\Unit\StructuredData;

use Pegasus\GoogleForJobs\Domain\Model\Job;
use Pegasus\GoogleForJobs\Domain\Model\JobLocation;
use Pegasus\GoogleForJobs\StructuredData\JobPostingBuilder;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

final class JobPostingBuilderTest extends UnitTestCase
{
    private JobPostingBuilder $subject;

    protected function setUp(): void
    {
        parent::setUp();
        $this->subject = new JobPostingBuilder();
    }

    private function createJob(bool $withLocation = true): Job
    {
        $job = new Job();
        $job->_setProperty('uid', 42);
        $job->setTitle('Software Engineer');
        $job->setDescription('<p>Build things &amp; ship them.</p><ul><li>PHP</li></ul>');
        $job->setDatePosted(new \DateTime('2026-10-01 00:00:00'));
        $job->setHiringOrganizationName('Example GmbH');
        $job->setHiringOrganizationWebsite('https://www.example.com');
        $job->setEmploymentType('FULL_TIME');

        if (!$withLocation) {
            return $job;
        }

        $location = new JobLocation();
        $location->setStreetAddress('Hauptstraße 1');
        $location->setCity('Berlin');
        $location->setPostalCode('10115');
        $location->setCountry('DE');
        $job->addJobLocation($location);

        return $job;
    }

    #[Test]
    public function requiredPropertiesAreBuilt(): void
    {
        $data = $this->subject->build($this->createJob());

        self::assertSame([
            '@context' => 'https://schema.org/',
            '@type' => 'JobPosting',
            'title' => 'Software Engineer',
            'description' => '<p>Build things &amp; ship them.</p><ul><li>PHP</li></ul>',
            'datePosted' => '2026-10-01',
            'employmentType' => 'FULL_TIME',
            'hiringOrganization' => [
                '@type' => 'Organization',
                'name' => 'Example GmbH',
                'sameAs' => 'https://www.example.com',
            ],
            'identifier' => [
                '@type' => 'PropertyValue',
                'name' => 'Example GmbH',
                'value' => '42',
            ],
            'jobLocation' => [
                '@type' => 'Place',
                'address' => [
                    '@type' => 'PostalAddress',
                    'streetAddress' => 'Hauptstraße 1',
                    'addressLocality' => 'Berlin',
                    'postalCode' => '10115',
                    'addressCountry' => 'DE',
                ],
            ],
        ], $data);
    }

    #[Test]
    public function descriptionIsKeptAsHtmlAndTextIsNotEscapedTwice(): void
    {
        $job = $this->createJob();
        $job->setTitle('Koch & Köchin (m/w/d)');

        $data = $this->subject->build($job);

        self::assertSame('Koch & Köchin (m/w/d)', $data['title']);
        self::assertStringStartsWith('<p>', $data['description']);
    }

    #[Test]
    public function validThroughIsTheEndOfTheSelectedDay(): void
    {
        $job = $this->createJob();
        $job->setValidThrough(new \DateTime('2026-12-31 00:00:00', new \DateTimeZone('Europe/Berlin')));

        self::assertSame('2026-12-31T23:59:59+01:00', $this->subject->build($job)['validThrough']);
    }

    #[Test]
    public function multipleEmploymentTypesAreListedAndUnknownValuesDropped(): void
    {
        $job = $this->createJob();
        $job->setEmploymentType('FULL_TIME,,PART_TIME,full_time,FREELANCE');

        self::assertSame(['FULL_TIME', 'PART_TIME'], $this->subject->build($job)['employmentType']);
    }

    #[Test]
    public function emptyOptionalValuesAreOmitted(): void
    {
        $job = $this->createJob(false);
        $job->setEmploymentType('');
        $job->setHiringOrganizationWebsite('');
        $location = new JobLocation();
        $location->setCountry('DE');
        $job->addJobLocation($location);
        $job->addJobLocation(new JobLocation());

        $data = $this->subject->build($job);

        self::assertArrayNotHasKey('employmentType', $data);
        self::assertArrayNotHasKey('validThrough', $data);
        self::assertArrayNotHasKey('baseSalary', $data);
        self::assertArrayNotHasKey('directApply', $data);
        self::assertSame(['@type' => 'Organization', 'name' => 'Example GmbH'], $data['hiringOrganization']);
        self::assertSame(['@type' => 'Place', 'address' => ['@type' => 'PostalAddress', 'addressCountry' => 'DE']], $data['jobLocation']);
    }

    #[Test]
    public function multipleLocationsAreListed(): void
    {
        $job = $this->createJob();
        $location = new JobLocation();
        $location->setCity('Hamburg');
        $location->setCountry('DE');
        $job->addJobLocation($location);

        $data = $this->subject->build($job);

        self::assertCount(2, $data['jobLocation']);
        self::assertSame('Hamburg', $data['jobLocation'][1]['address']['addressLocality']);
    }

    #[Test]
    public function identifierUsesReferenceNumberIfSet(): void
    {
        $job = $this->createJob();
        $job->setIdentifier(' JOB-2026-17 ');

        self::assertSame('JOB-2026-17', $this->subject->build($job)['identifier']['value']);
    }

    #[Test]
    public function linksAreResolvedToAbsoluteUrls(): void
    {
        $job = $this->createJob();
        $job->setHiringOrganizationWebsite('t3://page?uid=1');
        $job->setHiringOrganizationLogoUrl('t3://file?uid=74');
        $resolver = static fn(string $link): string => match ($link) {
            't3://page?uid=1' => 'https://www.example.com/',
            't3://file?uid=74' => 'https://www.example.com/fileadmin/logo.png',
            default => $link,
        };

        $organization = $this->subject->build($job, $resolver)['hiringOrganization'];

        self::assertSame('https://www.example.com/', $organization['sameAs']);
        self::assertSame('https://www.example.com/fileadmin/logo.png', $organization['logo']);
    }

    #[Test]
    public function remoteJobsListAllAllowedCountries(): void
    {
        $job = $this->createJob();
        $job->setJobLocationType(true);
        $job->setApplicantLocationRequirements('DE, AT;CH');

        $data = $this->subject->build($job);

        self::assertSame('TELECOMMUTE', $data['jobLocationType']);
        self::assertSame([
            ['@type' => 'Country', 'name' => 'DE'],
            ['@type' => 'Country', 'name' => 'AT'],
            ['@type' => 'Country', 'name' => 'CH'],
        ], $data['applicantLocationRequirements']);
        self::assertArrayNotHasKey('applicantLocationRequirement', $data);
    }

    #[Test]
    public function remoteJobWithSingleCountry(): void
    {
        $job = $this->createJob(false);
        $job->setJobLocationType(true);
        $job->setApplicantLocationRequirements('DE');

        $data = $this->subject->build($job);

        self::assertSame(['@type' => 'Country', 'name' => 'DE'], $data['applicantLocationRequirements']);
        self::assertArrayNotHasKey('jobLocation', $data);
    }

    #[Test]
    public function baseSalaryIsOmittedIfDisabled(): void
    {
        $job = $this->createJob();
        $job->setBaseSalaryEnable(false);
        $job->setBaseSalaryCurrency('EUR');
        $job->setBaseSalaryValue(50000);
        $job->setBaseSalaryUnitText('YEAR');

        self::assertArrayNotHasKey('baseSalary', $this->subject->build($job));
    }

    public static function baseSalaryDataProvider(): \Generator
    {
        yield 'exact value' => [50000.0, 0.0, 0.0, ['@type' => 'QuantitativeValue', 'value' => 50000.0, 'unitText' => 'YEAR']];
        yield 'range' => [0.0, 45000.0, 55000.0, ['@type' => 'QuantitativeValue', 'minValue' => 45000.0, 'maxValue' => 55000.0, 'unitText' => 'YEAR']];
        yield 'range wins over value' => [50000.0, 45000.0, 55000.0, ['@type' => 'QuantitativeValue', 'minValue' => 45000.0, 'maxValue' => 55000.0, 'unitText' => 'YEAR']];
        yield 'minimum only' => [0.0, 45000.0, 0.0, ['@type' => 'QuantitativeValue', 'minValue' => 45000.0, 'unitText' => 'YEAR']];
        yield 'invalid range falls back to value' => [50000.0, 55000.0, 45000.0, ['@type' => 'QuantitativeValue', 'value' => 50000.0, 'unitText' => 'YEAR']];
    }

    /**
     * @param array<string, mixed> $expectedValue
     */
    #[Test]
    #[DataProvider('baseSalaryDataProvider')]
    public function baseSalaryIsBuiltIfEnabled(float $value, float $min, float $max, array $expectedValue): void
    {
        $job = $this->createJob();
        $job->setBaseSalaryEnable(true);
        $job->setBaseSalaryCurrency('eur');
        $job->setBaseSalaryUnitText('YEAR');
        $job->setBaseSalaryValue($value);
        $job->setBaseSalaryMinValue($min);
        $job->setBaseSalaryMaxValue($max);

        self::assertSame([
            '@type' => 'MonetaryAmount',
            'currency' => 'EUR',
            'value' => $expectedValue,
        ], $this->subject->build($job)['baseSalary']);
    }

    #[Test]
    public function baseSalaryWithoutAmountIsOmitted(): void
    {
        $job = $this->createJob();
        $job->setBaseSalaryEnable(true);
        $job->setBaseSalaryCurrency('EUR');

        self::assertArrayNotHasKey('baseSalary', $this->subject->build($job));
    }

    public static function directApplyDataProvider(): \Generator
    {
        yield 'not specified' => [Job::DIRECT_APPLY_UNSPECIFIED, null];
        yield 'yes' => [Job::DIRECT_APPLY_YES, true];
        yield 'no' => [Job::DIRECT_APPLY_NO, false];
    }

    #[Test]
    #[DataProvider('directApplyDataProvider')]
    public function directApplyIsOnlyOutputIfSpecified(int $directApply, ?bool $expected): void
    {
        $job = $this->createJob();
        $job->setDirectApply($directApply);

        self::assertSame($expected, $this->subject->build($job)['directApply'] ?? null);
    }

    #[Test]
    public function requirementsAreBuiltWithGoogleValues(): void
    {
        $job = $this->createJob();
        $job->setEducationRequirements('bachelor degree,professional certificate,unknown');
        $job->setExperienceMonths(36);
        $job->setExperienceInPlaceOfEducation(true);

        $data = $this->subject->build($job);

        self::assertSame([
            ['@type' => 'EducationalOccupationalCredential', 'credentialCategory' => 'bachelor degree'],
            ['@type' => 'EducationalOccupationalCredential', 'credentialCategory' => 'professional certificate'],
        ], $data['educationRequirements']);
        self::assertSame(['@type' => 'OccupationalExperienceRequirements', 'monthsOfExperience' => 36], $data['experienceRequirements']);
        self::assertTrue($data['experienceInPlaceOfEducation']);
    }

    #[Test]
    public function noRequirementsAreExpressedAsGoogleExpects(): void
    {
        $job = $this->createJob();
        $job->setEducationRequirements('no requirements,bachelor degree');
        $job->setExperienceMonths(0);
        $job->setExperienceInPlaceOfEducation(true);

        $data = $this->subject->build($job);

        self::assertSame('no requirements', $data['educationRequirements']);
        self::assertSame('no requirements', $data['experienceRequirements']);
        self::assertArrayNotHasKey('experienceInPlaceOfEducation', $data);
    }

    #[Test]
    public function unspecifiedRequirementsAreOmitted(): void
    {
        $job = $this->createJob();
        $job->setExperienceInPlaceOfEducation(true);

        $data = $this->subject->build($job);

        self::assertArrayNotHasKey('educationRequirements', $data);
        self::assertArrayNotHasKey('experienceRequirements', $data);
        self::assertArrayNotHasKey('experienceInPlaceOfEducation', $data);
    }

    #[Test]
    public function renderedScriptCannotBeClosedByContent(): void
    {
        $job = $this->createJob();
        $job->setTitle('</script><script>alert(1)</script>');

        $html = $this->subject->render($this->subject->build($job));

        self::assertSame(1, substr_count($html, '</script>'));
        self::assertStringStartsWith('<script type="application/ld+json">', $html);
        $json = substr($html, strlen('<script type="application/ld+json">'), -strlen('</script>'));
        self::assertSame('</script><script>alert(1)</script>', json_decode($json, true, 512, JSON_THROW_ON_ERROR)['title']);
    }

    #[Test]
    public function renderedJsonKeepsUrlsAndUmlautsReadable(): void
    {
        $html = $this->subject->render($this->subject->build($this->createJob()));

        self::assertStringContainsString('"https://schema.org/"', $html);
        self::assertStringContainsString('Hauptstraße 1', $html);
    }
}
