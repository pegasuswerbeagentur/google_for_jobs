<?php
namespace Pegasus\GoogleForJobs\Tests\Unit\Domain\Model;

/**
 * Test case.
 *
 * @author Michael Kunst <kunst@pega-sus.de>
 */
class JobTest extends \TYPO3\TestingFramework\Core\Unit\UnitTestCase
{
    /**
     * @var \Pegasus\GoogleForJobs\Domain\Model\Job
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \Pegasus\GoogleForJobs\Domain\Model\Job();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function getDatePostedReturnsInitialValueForDateTime()
    {
        self::assertEquals(
            null,
            $this->subject->getDatePosted()
        );
    }

    /**
     * @test
     */
    public function setDatePostedForDateTimeSetsDatePosted()
    {
        $dateTimeFixture = new \DateTime();
        $this->subject->setDatePosted($dateTimeFixture);

        self::assertAttributeEquals(
            $dateTimeFixture,
            'datePosted',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getDescriptionReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getDescription()
        );
    }

    /**
     * @test
     */
    public function setDescriptionForStringSetsDescription()
    {
        $this->subject->setDescription('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'description',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getHiringOrganizationNameReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getHiringOrganizationName()
        );
    }

    /**
     * @test
     */
    public function setHiringOrganizationNameForStringSetsHiringOrganizationName()
    {
        $this->subject->setHiringOrganizationName('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'hiringOrganizationName',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getHiringOrganizationWebsiteReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getHiringOrganizationWebsite()
        );
    }

    /**
     * @test
     */
    public function setHiringOrganizationWebsiteForStringSetsHiringOrganizationWebsite()
    {
        $this->subject->setHiringOrganizationWebsite('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'hiringOrganizationWebsite',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getHiringOrganizationLogoUrlReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getHiringOrganizationLogoUrl()
        );
    }

    /**
     * @test
     */
    public function setHiringOrganizationLogoUrlForStringSetsHiringOrganizationLogoUrl()
    {
        $this->subject->setHiringOrganizationLogoUrl('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'hiringOrganizationLogoUrl',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getJobLocationStreetAddressReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getJobLocationStreetAddress()
        );
    }

    /**
     * @test
     */
    public function setJobLocationStreetAddressForStringSetsJobLocationStreetAddress()
    {
        $this->subject->setJobLocationStreetAddress('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'jobLocationStreetAddress',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getJobLocationCityReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getJobLocationCity()
        );
    }

    /**
     * @test
     */
    public function setJobLocationCityForStringSetsJobLocationCity()
    {
        $this->subject->setJobLocationCity('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'jobLocationCity',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getJobLocationPostalCodeReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getJobLocationPostalCode()
        );
    }

    /**
     * @test
     */
    public function setJobLocationPostalCodeForStringSetsJobLocationPostalCode()
    {
        $this->subject->setJobLocationPostalCode('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'jobLocationPostalCode',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getJobLocationRegionReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getJobLocationRegion()
        );
    }

    /**
     * @test
     */
    public function setJobLocationRegionForStringSetsJobLocationRegion()
    {
        $this->subject->setJobLocationRegion('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'jobLocationRegion',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getJobLocationCountryReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getJobLocationCountry()
        );
    }

    /**
     * @test
     */
    public function setJobLocationCountryForStringSetsJobLocationCountry()
    {
        $this->subject->setJobLocationCountry('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'jobLocationCountry',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getTitleReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getTitle()
        );
    }

    /**
     * @test
     */
    public function setTitleForStringSetsTitle()
    {
        $this->subject->setTitle('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'title',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getValidThroughReturnsInitialValueForDateTime()
    {
        self::assertEquals(
            null,
            $this->subject->getValidThrough()
        );
    }

    /**
     * @test
     */
    public function setValidThroughForDateTimeSetsValidThrough()
    {
        $dateTimeFixture = new \DateTime();
        $this->subject->setValidThrough($dateTimeFixture);

        self::assertAttributeEquals(
            $dateTimeFixture,
            'validThrough',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getBaseSalaryCurrencyReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getBaseSalaryCurrency()
        );
    }

    /**
     * @test
     */
    public function setBaseSalaryCurrencyForStringSetsBaseSalaryCurrency()
    {
        $this->subject->setBaseSalaryCurrency('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'baseSalaryCurrency',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getBaseSalaryUnitTextReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getBaseSalaryUnitText()
        );
    }

    /**
     * @test
     */
    public function setBaseSalaryUnitTextForStringSetsBaseSalaryUnitText()
    {
        $this->subject->setBaseSalaryUnitText('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'baseSalaryUnitText',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getBaseSalaryValueReturnsInitialValueForFloat()
    {
        self::assertSame(
            0.0,
            $this->subject->getBaseSalaryValue()
        );
    }

    /**
     * @test
     */
    public function setBaseSalaryValueForFloatSetsBaseSalaryValue()
    {
        $this->subject->setBaseSalaryValue(3.14159265);

        self::assertAttributeEquals(
            3.14159265,
            'baseSalaryValue',
            $this->subject,
            '',
            0.000000001
        );
    }

    /**
     * @test
     */
    public function getEmploymentTypeReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getEmploymentType()
        );
    }

    /**
     * @test
     */
    public function setEmploymentTypeForStringSetsEmploymentType()
    {
        $this->subject->setEmploymentType('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'employmentType',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getJobLocationTypeReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getJobLocationType()
        );
    }

    /**
     * @test
     */
    public function setJobLocationTypeForStringSetsJobLocationType()
    {
        $this->subject->setJobLocationType('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'jobLocationType',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getApplicantLocationRequirementsReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getApplicantLocationRequirements()
        );
    }

    /**
     * @test
     */
    public function setApplicantLocationRequirementsForStringSetsApplicantLocationRequirements()
    {
        $this->subject->setApplicantLocationRequirements('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'applicantLocationRequirements',
            $this->subject
        );
    }
}
