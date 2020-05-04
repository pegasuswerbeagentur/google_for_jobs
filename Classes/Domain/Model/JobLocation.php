<?php
declare(strict_types=1);

namespace Pegasus\GoogleForJobs\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

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
class JobLocation extends AbstractEntity
{
    /**
     * The Street and No. of the business where the employee will report to work.
     * 
     * @var string
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     */
    protected $jobLocationStreetAddress = '';

    /**
     * The city of the business where the employee will report to work.
     * 
     * @var string
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     */
    protected $jobLocationCity = '';

    /**
     * The postal code of the business where the employee will report to work.
     * 
     * @var string
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     */
    protected $jobLocationPostalCode = '';

    /**
     * The region of the business where the employee will report to work. For example,
     * California or another appropriate first-level Administrative division.
     * 
     * @var string
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     */
    protected $jobLocationRegion = '';

    /**
     * The country of the business where the employee will report to work. For example,
     * USA. You can also provide the two-letter ISO 3166-1 alpha-2 country code.
     * 
     * @var string
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     */
    protected $jobLocationCountry = '';

    /**
     * Returns the jobLocationStreetAddress
     * 
     * @return string $jobLocationStreetAddress
     */
    public function getJobLocationStreetAddress(): string
    {
        return $this->jobLocationStreetAddress;
    }

    /**
     * Sets the jobLocationStreetAddress
     * 
     * @param string $jobLocationStreetAddress
     * @return void
     */
    public function setJobLocationStreetAddress(string $jobLocationStreetAddress): void
    {
        $this->jobLocationStreetAddress = $jobLocationStreetAddress;
    }

    /**
     * Returns the jobLocationCity
     * 
     * @return string $jobLocationCity
     */
    public function getJobLocationCity(): string
    {
        return $this->jobLocationCity;
    }

    /**
     * Sets the jobLocationCity
     * 
     * @param string $jobLocationCity
     * @return void
     */
    public function setJobLocationCity(string $jobLocationCity): void
    {
        $this->jobLocationCity = $jobLocationCity;
    }

    /**
     * Returns the jobLocationPostalCode
     * 
     * @return string $jobLocationPostalCode
     */
    public function getJobLocationPostalCode(): string
    {
        return $this->jobLocationPostalCode;
    }

    /**
     * Sets the jobLocationPostalCode
     * 
     * @param string $jobLocationPostalCode
     * @return void
     */
    public function setJobLocationPostalCode(string $jobLocationPostalCode): void
    {
        $this->jobLocationPostalCode = $jobLocationPostalCode;
    }

    /**
     * Returns the jobLocationRegion
     * 
     * @return string $jobLocationRegion
     */
    public function getJobLocationRegion(): string
    {
        return $this->jobLocationRegion;
    }

    /**
     * Sets the jobLocationRegion
     * 
     * @param string $jobLocationRegion
     * @return void
     */
    public function setJobLocationRegion(string $jobLocationRegion): void
    {
        $this->jobLocationRegion = $jobLocationRegion;
    }

    /**
     * Returns the jobLocationCountry
     * 
     * @return string $jobLocationCountry
     */
    public function getJobLocationCountry(): string
    {
        return $this->jobLocationCountry;
    }

    /**
     * Sets the jobLocationCountry
     * 
     * @param string $jobLocationCountry
     * @return void
     */
    public function setJobLocationCountry(string $jobLocationCountry): void
    {
        $this->jobLocationCountry = $jobLocationCountry;
    }
}