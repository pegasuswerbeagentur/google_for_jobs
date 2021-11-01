# Changelog
All notable changes to this project will be documented in this file.

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
