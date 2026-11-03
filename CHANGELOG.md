# Changelog
All notable changes to this project will be documented in this file.

## [3.0.0] - 2026-11-03
Compatibility release for TYPO3 13.4 LTS and 14.3 LTS. The structured data
output now follows the current Google requirements for job postings.

### Important
- [!!!] Requires TYPO3 13.4.37 or 14.3.10 (or newer) and PHP 8.2 or newer. Support for TYPO3 10 and 11 is dropped; version 2.x stays available on the `11.5` branch.
- Run the database analyzer ("Add fields and tables" only) and afterwards the upgrade wizards. Existing data is kept; no column is renamed or removed.
- Upgrade wizard "Google for Jobs: Migrate plugin to content element" converts existing plugins to the new content element. Plugin settings and backend group permissions are carried over.
- Upgrade wizard "Google for Jobs: Migrate job locations of version 1.x" is still available for direct upgrades from 1.x. Run it before removing unused database columns.
- Route enhancers and sitemap configurations keep working unchanged, the plugin namespace is still `tx_googleforjobs_job`.

### Breaking
- [!!!] The plugin is registered as content element type `googleforjobs_job` instead of a "list_type" plugin.
- [!!!] The TypoScript files are named `constants.typoscript` and `setup.typoscript`. Templates including `EXT:google_for_jobs/Configuration/TypoScript` keep working; a site set `pegasus/google-for-jobs` is available as alternative.
- [!!!] The action `noJobFound` and its template are removed. Unknown or missing jobs on the detail page now result in a "page not found" response (HTTP 404) handled by the site error handling.
- [!!!] `JobRepository::findByCategories()` is replaced by `JobRepository::findForList()`, `Job::createStructuredData()` by the service `Pegasus\GoogleForJobs\StructuredData\JobPostingBuilder`.
- [!!!] Lists hide jobs whose "valid through" date has passed. This can be switched off per plugin or with `plugin.tx_googleforjobs_job.settings.job.hideExpired = 0`.
- [!!!] The Fluid templates have been rewritten. Custom templates should be compared with the new ones, especially date formats (`strftime` formats such as `%d. %B %Y` are no longer supported by PHP).

### Added
- Support for TYPO3 13.4 LTS and 14.3 LTS.
- New fields for the structured data: reference number (`identifier`), direct application (`directApply`, #24), salary range (`minValue`/`maxValue`), education requirements, experience requirements and "experience in place of education".
- Page title provider: the job title is used as page title of the detail page (`settings.job.setPageTitle`, #21).
- Categories of a job are available in Fluid (`job.categories`, `job.firstCategory`).
- Field descriptions in the backend explain the Google requirements for each field; German translation of all labels.
- Unit and functional tests, PHPStan, coding guidelines and GitHub Actions for TYPO3 13.4 and 14.3.

### Fixed
- `applicantLocationRequirements` was output with a wrong property name and supports multiple countries now.
- The job description is output as HTML as required by Google instead of escaped text, and special characters are no longer escaped twice.
- `baseSalary` is only output if the salary is enabled (#22).
- Organization logos and websites selected via the link browser (`t3://file`, `t3://page`) are output as absolute URLs (#20).
- `validThrough` is output as date and time (end of the selected day).
- Empty values (employment type, address fields, website, logo) are no longer output.
- The list view no longer adds controller and action parameters to the URL (#15, #16).
- Only the configured fields can be used for ordering lists.

## [2.2.0] - 2022-06-16
- compatibility for TYPO3 11

## [2.1.1] - 2021-08-23
Security release: update as soon as possilbe to close a possible XSS vulnerability

### Security
- escape structured data JSON output 
- escape all rendered job properties in fluid templates

## [2.1.0] - 2021-03-08
### Sponsor
- Many thanks to [Cybertrading](https://cybertrading.de/) for sponsoring this update!

### Added
- Support for sytem categories in job records
- Support for list of selected job entries
- Support for setting the order in list view by title, last edited, created and published
- Translation support for Plugin

### Important
- [!!!] Analyze and update database structure after installation

### Fixed
- render missing organization logo url to structured data output
- make validThrough nullable in job model

## [2.0.1] - 2020-06-19
### Fixed
- move flexform registration to tt_content overrides

## [2.0.0] - 2020-06-09
### Added
- Added support for TYPO3 10
- Dropped Support for TYPO3 9

## [1.4.0] - 2020-06-09
### Added
- [!!!][BREAKING] Support for multiple locations per job.
- Support for job locations as seperate records
- Fix: Show job title instead of date in backend record list
- Render structured data to html head as recommended by Google

### Important
- [!!!] Run Upgrade Wizard and update fluid templates. See [here](./README.md#update-from-13-to-higher-Versions)

## [1.3.0] - 2019-11-22
### Added
- Add media, path segment, metadata and alt title to model

### Important
- DB compare needed

## [1.2.0] - 2019-10-28
### Added
- Support for detail view on different page than list view

### Fixed
- correct JSON output for datePosted and validThrough settings

## [1.1.1] - 2019-10-11
### Added
- Changelog.

### Fixed
- Use statement removed from ext_tables.php
