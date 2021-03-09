<?php

declare(strict_types=1);

namespace Pegasus\GoogleForJobs\Controller;

use Pegasus\GoogleForJobs\Domain\Model\Job;
use Pegasus\GoogleForJobs\Domain\Repository\JobRepository;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Utility\GeneralUtility;

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
 * JobController
 */
class JobController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * jobRepository
     *
     * @var \Pegasus\GoogleForJobs\Domain\Repository\JobRepository
     */
    protected $jobRepository = null;

    public function __construct(JobRepository $jobRepository)
    {
        $this->jobRepository = $jobRepository;
    }

    public function indexAction(): void
    {
        $action = $this->settings['job']['renderType'];
        $this->redirect($action);
    }

    /**
     * actio list
     *
     * @return void
     */
    public function listAction(): void
    {
        if ($this->settings['job']['renderType'] != 'list') {
            $this->redirect('noJobFound');
        }

        $categories = $this->settings['job']['categories'];
        $categoryConjunction = $this->settings['job']['categoryConjunction'];
        $this->setRepositoryOrderings();
        $jobs = $this->jobRepository->findByCategories($categories, $categoryConjunction);
        $this->view->assign('jobs', $jobs);
    }

    /**
     * action show
     *
     * Renders the job detail template and renders the jobs
     * structured data script tag to the html head.
     *
     * @param Job $job
     * @return void
     */
    public function showAction(Job $job): void
    {
        $structuredData = $job->createStructuredData();
        /** @var PageRenderer $pageRenderer */
        $pageRenderer = $this->objectManager->get(PageRenderer::class);
        $pageRenderer->addHeaderData($structuredData);

        if ($this->settings['job']['renderDetailTemplate']) {
            $this->view->assign('job', $job);
        }
    }

    /**
     * Render no job found template
     *
     * @return void
     */
    protected function noJobFoundAction(): void
    {
    }

    /**
     * action listSelected
     *
     * Renders a list view of selected jobs.
     * @return void
     */
    public function listSelectedAction(): void
    {
        /** @var Job[] $jobs */
        $jobs = [];
        $selectedJobIds = GeneralUtility::trimExplode(',', $this->settings['job']['listSelected'], true);

        foreach ($selectedJobIds as $id) {
            $job = $this->jobRepository->findByIdentifier($id);
            if ($job) {
                $jobs[] = $job;
            }
        }

        $this->view->assign('jobs', $jobs);
    }

    /**
     * Get orderings from plugin and set them in repository
     *
     * @return void
     */
    private function setRepositoryOrderings(): void
    {
        $orderBy = 'uid';
        $orderDirection = \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING;

        if ($this->settings['job']['orderBy']) {
            $orderBy = $this->settings['job']['orderBy'];
        }
        if ($this->settings['job']['orderDirection'] == 'desc') {
            $orderDirection = \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING;
        }
        $defaultOrderings = [$orderBy => $orderDirection];

        $this->jobRepository->setDefaultOrderings($defaultOrderings);
    }
}
