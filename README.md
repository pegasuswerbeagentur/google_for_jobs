# TYPO3 Extension ``google_for_jobs``

![google for Jobs](https://github.com/pegasuswerbeagentur/google_for_jobs/blob/master/Resources/Public/Icons/git-repo-teaser.JPG)

## 1. Features

- easy integration
- decide to hide/display fluidtemplate in frontend
- render structured data to your job posting
- more features coming soon

## 2. Usage

### 1) Installation

#### Installation using Composer

The recommended way to install the extension is by using [Composer][1]. In your Composer based TYPO3 project root, just do `composer require pegasus/google-for-jobs`. 

#### Installation as extension from TYPO3 Extension Repository (TER)

Download and install the extension with the extension manager module.

### 2) Setup

1) Include the static TypoScript of the extension.
2) Create some job records on a sysfolder.
3) Create a plugin on a page and select at least the sysfolder as startingpoint.

### 3) Sitemap

Add the following code to your setup.typoscript

plugin.tx_seo.config {
  xmlSitemap {
    sitemaps {
      jobs {
        provider = TYPO3\CMS\Seo\XmlSitemap\RecordsXmlSitemapDataProvider
        config {
          table = tx_googleforjobs_domain_model_job
          sortField = uid
          lastModifiedField = tstamp
          pid = <page id containing news records>
          url {
            pageId = <your detail page id>
            fieldToParameterMap {
              uid = tx_googleforjobs_job[job]
            }
            additionalGetParameters {
              tx_googleforjobs_job.controller = Job
              tx_googleforjobs_job.action = show
            }
            useCacheHash = 1
          }
        }
      }
    }
  }
}

## 3. Administration

### 3.1. Versions and support

| google_for_jobs  | TYPO3      | PHP       | Support/Development                     |
| ---------------- | ---------- | ----------|---------------------------------------- |
| 2.x (coming soon)| 8.7 - 9.x  | 7.0 - 7.2 | Features, Bugfixes, Security Updates    |
| 1.x              | 9.x        | 7.0 - 7.2 | Bugfixes, Security Updates              |


### 3.2. Contribution

Pull requests are welcome in general! Nevertheless please don't forget to add an issue and connect it to your pull requests. This
is very helpful to understand what kind of issue the PR is going to solve.

- Bugfixes: Please describe what kind of bug your fix solve and give us feedback how to reproduce the issue. We're going
to accept only bugfixes if I can reproduce the issue.
- Features: Feel free to contact us if u have some cool ideas or wishes.

[1]: https://getcomposer.org/

### 3.3. Changelog

Read the full Changelog [here](./CHANGELOG.md).
