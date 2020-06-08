<?php
declare(strict_types=1);

namespace Pegasus\GoogleForJobs\Controller;

use Pegasus\GoogleForJobs\Domain\Model\Job;
use Pegasus\GoogleForJobs\Domain\Repository\JobRepository;
use TYPO3\CMS\Core\Page\PageRenderer;

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

    /**
     * action list
     * 
     * @return void
     */
    public function listAction(): void
    {   
        if ($this->settings['job']['renderType'] != 'list') {
            $this->redirect('noJobFound');
        }
        $jobs = $this->jobRepository->findAll();
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

        if($this->settings['job']['renderDetailTemplate']) {
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
}
