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
    protected $streetAddress = '';

    /**
     * The city of the business where the employee will report to work.
     *
     * @var string
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     */
    protected $city = '';

    /**
     * The postal code of the business where the employee will report to work.
     *
     * @var string
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     */
    protected $postalCode = '';

    /**
     * The region of the business where the employee will report to work. For example,
     * California or another appropriate first-level Administrative division.
     *
     * @var string
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     */
    protected $region = '';

    /**
     * The country of the business where the employee will report to work. For example,
     * USA. You can also provide the two-letter ISO 3166-1 alpha-2 country code.
     *
     * @var string
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     */
    protected $country = '';

    /**
     * Returns the streetAddress
     *
     * @return string $streetAddress
     */
    public function getStreetAddress(): string
    {
        return $this->streetAddress;
    }

    /**
     * Sets the streetAddress
     *
     * @param string $streetAddress
     * @return void
     */
    public function setStreetAddress(string $streetAddress): void
    {
        $this->streetAddress = $streetAddress;
    }

    /**
     * Returns the city
     *
     * @return string $city
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * Sets the city
     *
     * @param string $city
     * @return void
     */
    public function setCity(string $city): void
    {
        $this->city = $city;
    }

    /**
     * Returns the postalCode
     *
     * @return string $postalCode
     */
    public function getPostalCode(): string
    {
        return $this->postalCode;
    }

    /**
     * Sets the postalCode
     *
     * @param string $postalCode
     * @return void
     */
    public function setPostalCode(string $postalCode): void
    {
        $this->postalCode = $postalCode;
    }

    /**
     * Returns the region
     *
     * @return string $region
     */
    public function getRegion(): string
    {
        return $this->region;
    }

    /**
     * Sets the region
     *
     * @param string $region
     * @return void
     */
    public function setRegion(string $region): void
    {
        $this->region = $region;
    }

    /**
     * Returns the country
     *
     * @return string $country
     */
    public function getCountry(): string
    {
        return $this->country;
    }

    /**
     * Sets the country
     *
     * @param string $country
     * @return void
     */
    public function setCountry(string $country): void
    {
        $this->country = $country;
    }
}
